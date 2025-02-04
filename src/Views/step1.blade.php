@extends('vendor.installer.index')

@section('content')
<?php
$db_file_write_perm = is_writable('config/database.php');
$routes_file_write_perm = is_writable('routes/web.php');
$curl_enabled = function_exists('curl_version');
$valid = true;

// if ($db_file_write_perm == false || $routes_file_write_perm == false || $curl_enabled == false) {
//     $valid = false;
// } else {
//     $valid = true;
// }

// Required PHP version
$required_php_version = '8.2';

// List of required PHP extensions
$required_extensions = ['ctype' => 'Ctype PHP Extension', 'curl' => 'cURL PHP Extension', 'dom' => 'DOM PHP Extension', 'fileinfo' => 'Fileinfo PHP Extension', 'filter' => 'Filter PHP Extension', 'hash' => 'Hash PHP Extension', 'mbstring' => 'Mbstring PHP Extension', 'openssl' => 'OpenSSL PHP Extension', 'pcre' => 'PCRE PHP Extension', 'pdo' => 'PDO PHP Extension', 'session' => 'Session PHP Extension', 'tokenizer' => 'Tokenizer PHP Extension', 'xml' => 'XML PHP Extension'];

// Flag to track status
$all_requirements_met = true;

// Check PHP version
if (version_compare(PHP_VERSION, $required_php_version, '>=')) {
} else {
    $all_requirements_met = false;
}

foreach ($required_extensions as $key => $extension) {
    if (extension_loaded($key)) {

    } else {
        $all_requirements_met = false;
    }
}
    ?>
<div class="row justify-content-center ins-two">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="panel panel-default ins-three" data-collapsed="0">
                    <!-- panel body -->
                    <div class="panel-body ins-four">

                        @if (version_compare(PHP_VERSION, $required_php_version, '>='))
                            <div class="alert alert-success" role="alert">
                                {{"PHP version is sufficient: " . PHP_VERSION}}
                            </div>
                        @else
                            <div class="alert alert-danger" role="alert">
                                {{"PHP version is insufficient: " . PHP_VERSION . ". Required: $required_php_version or higher"}}
                            </div>

                        @endif

                        <p class="ins-four mt-3">
                            To continue the installation process, below file and folder must have writable permission.
                        </p>


                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td>{{ __('config/database.php') }}</td>
                                    <td>File</td>
                                    <td>@if($db_file_write_perm)
                                        <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fafas fa-check ins-nine text-success"></i>
                                    @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>storage</td>
                                    <td>Folder</td>
                                    <td>@if($db_file_write_perm)
                                        <i class="fas fa-check-circle text-success"></i>
                                    @else
                                        <i class="fas fafas fa-check ins-nine text-success"></i>
                                    @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr />
                        <p class="ins-four mt-3">
                            To continue the installation process, below php extensions must be loaded on your server.
                        </p>

                        <table class="table table-bordered">
                            <tbody>
                                @foreach ($required_extensions as $key => $extension)
                                    <tr>
                                        <td>{{$extension}}</td>
                                        <td>@if(extension_loaded($key))
                                            <i class="fas fa-check-circle text-success"></i>
                                        @else
                                            <i class="fas fa-times-circle text-danger"></i>
                                        @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <br>
                        <?php if ($valid == true && $all_requirements_met == true) { ?>
                        <a href="{{ route('LaravelInstaller::step3') }}" class="btn btn-primary w-100">
                            {{ __('Continue') }}
                        </a>
                        <?php } else { ?>
                        <a href="{{ route('LaravelInstaller::step1') }}" class="btn btn-primary w-100">
                            <i class="mdi mdi-refresh"></i>{{ __('Reload') }}
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection