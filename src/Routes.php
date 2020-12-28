<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware'=>['api'], 'prefix'=>'api' ], function () {
    Route::get('package/composer', 'MetaverseSystems\ClarionPHPBackend\Controllers\ComposerPackageController@index');
    Route::post('package/composer', 'MetaverseSystems\ClarionPHPBackend\Controllers\ComposerPackageController@store');

    Route::get('package/npm', 'MetaverseSystems\ClarionPHPBackend\Controllers\NPMPackageController@index');
    Route::post('package/npm', 'MetaverseSystems\ClarionPHPBackend\Controllers\NPMPackageController@store');
});