<?php

namespace IamNitinViras\LaravelInstaller\Controllers;

use App\Models\CmsPage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WelcomeController extends Controller
{
    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vendor.installer.step0');
    }

    public function step1()
    {
        return view('vendor.installer.step1');
    }

    function step2($param1 = '')
    {
        if ($param1 == 'error') {
            $error = 'Purchase Code Verification Failed';
        } else {
            $error = "";
        }
        return view('vendor.installer.step2', ['error' => $error]);
    }

    public function step3(Request $request)
    {
        $db_connection = "";
        $data = $request->all();
        if ($data) {
            $hostname = $data['hostname'];
            $username = $data['username'];
            $password = $data['password'];
            $dbname   = $data['dbname'];
            // check db connection using the above credentials
            $db_connection = $this->check_database_connection($hostname, $username, $password, $dbname);
            if ($db_connection == 'success') {
                
                // proceed to step 4
                session(['hostname' => $hostname]);
                session(['username' => $username]);
                session(['password' => $password]);
                session(['dbname' => $dbname]);

                $env_data = [
                    'DB_HOST' => $hostname,
                    'DB_DATABASE' => $dbname,
                    'DB_USERNAME' => $username,
                    'DB_PASSWORD' => $password,
                ];
    
                DotenvEditor::setKeys($env_data)->save();
                Artisan::call('config:clear');

                return redirect()->route('LaravelInstaller::step4');
            } else {
                return view('vendor.installer.step3', ['db_connection' => $db_connection]);
            }
        }

        return view('vendor.installer.step3', ['db_connection' => $db_connection]);
    }

    public function check_database_connection($hostname, $username, $password, $dbname)
    {

        $newName = uniqid('db'); //example of unique name

        Config::set("database.connections." . $newName, [
            "host"      => $hostname,
            "port"      => env('DB_PORT', '3306'),
            "database"  => $dbname,
            "username"  => $username,
            "password"  => $password,
            'driver'    => env('DB_CONNECTION', 'mysql'),
            'charset'   => env('DB_CHARSET', 'utf8mb4'),
        ]);
        try {
            DB::connection($newName)->getPdo();
            return 'success';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function step4(Request $request)
    {
        return view('vendor.installer.step4');
    }

    public function confirmImport()
    {
        // write database.php here
        $this->configure_database();

        // redirect to admin creation page
        return view('vendor.installer.install');
    }

    public function confirmInstall()
    {
        // run sql
        $this->run_blank_sql();

        // redirect to admin creation page
        return redirect()->route('LaravelInstaller::finalizingSetup');
    }

    public function configure_database()
    {
        // write database.php
        $data_db = file_get_contents(base_path('config/database.php'));
        $data_db = str_replace('db_name',    session('dbname'),    $data_db);
        $data_db = str_replace('db_user',    session('username'),    $data_db);
        $data_db = str_replace('db_pass',    session('password'),    $data_db);
        $data_db = str_replace('db_host',    session('hostname'),    $data_db);
        file_put_contents(base_path('config/database.php'), $data_db);
    }

    public function run_blank_sql()
    {

        Artisan::call('migrate', [
            '--force' => true,
        ]);
    }

    public function finalizingSetup(Request $request)
    {

        $data = $request->all();
        if ($data) {

            $env_data = [
                'APP_NAME' => $request->app_name,
                'APP_URL' => $request->app_url,
            ];

            DotenvEditor::setKeys($env_data)->save();
            Artisan::call('config:clear');

            /*admin data*/
            $admin_data['first_name']      = $data['first_name'];
            $admin_data['last_name']      = $data['last_name'];
            $admin_data['email']     = $data['admin_email'];
            $admin_data['password']  = Hash::make($data['admin_password']);
            $admin_data['user_type']      = 1;
            $admin_data['phone_number']      = $data['admin_phone'];
            $admin_data['email_verified_at'] = date('Y-m-d H:i:s', time());
            $admin_data['created_at'] = date('Y-m-d H:i:s');

            DB::table('users')->insert($admin_data);

            Artisan::call('db:seed', [
                '--force' => true,
            ]);
            return redirect()->route('LaravelInstaller::success');
        }

        return view('vendor.installer.finalizing_setup');
    }

    public function success($param1 = '')
    {
        if ($param1 == 'login') {
            return view('auth.login');
        }

        $admin_email = User::where('user_type', 1)->first()->email;

        $page_data['admin_email'] = $admin_email;
        $page_data['page_name'] = 'success';


        $installedLogFile = storage_path('installed');
        $message ="installed";
        file_put_contents($installedLogFile, $message);

        return view('vendor.installer.success', ['admin_email' => $admin_email]);
    }
}
