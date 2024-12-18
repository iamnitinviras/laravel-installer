<?php

Route::group(['prefix' => 'install', 'as' => 'LaravelInstaller::', 'namespace' => 'IamNitinViras\LaravelInstaller\Controllers', 'middleware' => ['web']], function () {

    Route::get('/', [
        'as' => 'index',
        'uses' => 'WelcomeController@index',
    ]);

    Route::get('/step0', [
        'as' => 'step0',
        'uses' => 'WelcomeController@index',
    ]);

    Route::get('/step1', [
        'as' => 'step1',
        'uses' => 'WelcomeController@step1',
    ]);

    Route::get('/step2', [
        'as' => 'step2',
        'uses' => 'WelcomeController@step2',
    ]);

    Route::any('/step3', [
        'as' => 'step3',
        'uses' => 'WelcomeController@step3',
    ]);

    Route::get('/step4', [
        'as' => 'step4',
        'uses' => 'WelcomeController@step4',
    ]);

    Route::get('/confirmImport', [
        'as' => 'confirmImport',
        'uses' => 'WelcomeController@confirmImport',
    ]);

    Route::get('/confirmInstall', [
        'as' => 'confirmInstall',
        'uses' => 'WelcomeController@confirmInstall',
    ]);

    Route::any('/finalizingSetup', [
        'as' => 'finalizingSetup',
        'uses' => 'WelcomeController@finalizingSetup',
    ]);

    Route::get('/success', [
        'as' => 'success',
        'uses' => 'WelcomeController@success',
    ]);
});
