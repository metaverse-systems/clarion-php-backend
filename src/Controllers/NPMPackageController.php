<?php

namespace MetaverseSystems\ClarionPHPBackend\Controllers;

use MetaverseSystems\ClarionPHPBackend\Models\NPMPackage;
use Illuminate\Http\Request;

class NPMPackageController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = NPMPackage::get();
        return $packages;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $package = new NPMPackage;
        $package->name = $request->input('name');
        $package->version = $request->input('version');
        $package->save();

        \Artisan::call('clarion:npm-install');
        \Artisan::call('clarion:frontend-build');
    }

    /**
     * Display the specified resource.
     *
     * @param  NPMPackage  $npmPackage
     * @return \Illuminate\Http\Response
     */
    public function show(NPMPackage $npmPackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  NPMPackage  $npmPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(NPMPackage $npmPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  NPMPackage  $npmPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NPMPackage $npmPackage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  NPMPackage  $npmPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(NPMPackage $npmPackage)
    {
        //
    }
}
