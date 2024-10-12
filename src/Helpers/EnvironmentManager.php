<?php

namespace IamNitinViras\LaravelInstaller\Helpers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EnvironmentManager
{
    /**
     * @var string
     */
    private $envPath;

    /**
     * @var string
     */
    private $envExamplePath;

    /**
     * Set the .env and .env.example paths.
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
    }

    /**
     * Get the content of the .env file.
     *
     * @return string
     */
    public function getEnvContent()
    {
        if (! file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }

        return file_get_contents($this->envPath);
    }

    /**
     * Get the the .env file path.
     *
     * @return string
     */
    public function getEnvPath()
    {
        return $this->envPath;
    }

    /**
     * Get the the .env.example file path.
     *
     * @return string
     */
    public function getEnvExamplePath()
    {
        return $this->envExamplePath;
    }

    /**
     * Save the edited content to the .env file.
     *
     * @param Request $input
     * @return string
     */
    public function saveFileClassic(Request $input)
    {
        $message = trans('installer_messages.environment.success');

        try {
            file_put_contents($this->envPath, $input->get('envConfig'));
        } catch (Exception $e) {
            $message = trans('installer_messages.environment.errors');
        }

        return $message;
    }

    /**
     * Save the form content to the .env file.
     *
     * @param Request $request
     * @return string
     */
    public function saveFileWizard(Request $request)
    {
        $results = trans('installer_messages.environment.success');

        $envFileData =
        'APP_NAME=\''.$request->app_name."'\n".
        'APP_ENV='.$request->environment."\n".
        'APP_KEY='.'base64:'.base64_encode(Str::random(32))."\n".
        'APP_DEBUG='.$request->app_debug."\n".
        'APP_TIMEZONE=UTC'."\n".
        'APP_URL='.$request->app_url."\n".
        'ASSET_URL='.rtrim($request->app_url,'/').'/public'."\n".

        'APP_LOCALE=en'."\n".
        'APP_FALLBACK_LOCALE=en'."\n".
        'APP_FAKER_LOCALE=en'."\n".

        'APP_MAINTENANCE_DRIVER=file'."\n".
        'BCRYPT_ROUNDS=12'."\n".
        'LOG_CHANNEL=stack'."\n".
        'LOG_STACK=single'."\n".
        'LOG_DEPRECATIONS_CHANNEL=null'."\n".
        'LOG_LEVEL='.$request->app_log_level."\n".


        'DB_CONNECTION='.$request->database_connection."\n".
        'DB_HOST='.$request->database_hostname."\n".
        'DB_PORT='.$request->database_port."\n".
        'DB_DATABASE='.$request->database_name."\n".
        'DB_USERNAME='.$request->database_username."\n".
        'DB_PASSWORD='.$request->database_password."\n\n".

        'BROADCAST_DRIVER='.$request->broadcast_driver."\n".
        'CACHE_DRIVER='.$request->cache_driver."\n".

        'SESSION_DRIVER=file'."\n".
        'SESSION_LIFETIME=120'."\n".
        'SESSION_ENCRYPT=false'."\n".
        'SESSION_PATH=/'."\n".
        'SESSION_DOMAIN=null'."\n".

        'BROADCAST_CONNECTION=log'."\n".
        'FILESYSTEM_DISK=local'."\n\n".

        'QUEUE_CONNECTION=database'."\n".
        'CACHE_STORE=database'."\n".
        'CACHE_PREFIX='."\n".

        'REDIS_CLIENT=phpredis'."\n".
        'REDIS_HOST=127.0.0.1'."\n".
        'REDIS_PASSWORD=null'."\n".
        'REDIS_PORT=6379'."\n\n".

        'MAIL_MAILER=smtp'."\n".
        'MAIL_HOST=smtp.host.com'."\n".
        'MAIL_PORT=587'."\n".
        'MAIL_USERNAME=user'."\n".
        'MAIL_PASSWORD=password'."\n".
        'MAIL_ENCRYPTION=tsl'."\n\n".
        'MAIL_FROM_ADDRESS=from@email.com'."\n".
        'MAIL_FROM_NAME="${APP_NAME}"'."\n".

        'AWS_ACCESS_KEY_ID='."\n".
        'AWS_SECRET_ACCESS_KEY='."\n".
        'AWS_DEFAULT_REGION=us-east-1'."\n".
        'AWS_BUCKET='."\n".
        'AWS_USE_PATH_STYLE_ENDPOINT=false'."\n".


        'VITE_APP_NAME="${APP_NAME}"'."\n".
        'SUPPORT_EMAIL=support@mail.com'."\n".
        'SUPPORT_PHONE=12345678910'."\n".
        'FACEBOOK_URL=https://www.facebook.com'."\n".
        'INSTAGRAM_URL=https://www.instagram.com'."\n".
        'TWITTER_URL=https://x.com'."\n".
        'YOUTUBE_URL=https://www.youtube.com'."\n".
        'LINKEDIN_URL=https://www.linkedin.com'."\n".
        'CURRENCY_POSITION=left'."\n".
        'APP_DATE_TIME_FORMAT="d/m/Y h:i"'."\n".
        'APP_DATE_FORMAT="d/m/Y"'."\n".
        'APP_TIME_FORMAT="h:i"'."\n".
        'APP_CURRENCY=USD'."\n".
        'APP_CURRENCY_SYMBOL=$'."\n";

        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            $results = trans('installer_messages.environment.errors');
        }

        return $results;
    }
}
