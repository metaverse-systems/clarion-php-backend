<?php

namespace MetaverseSystems\ClarionPHPBackend\Controllers;

use MetaverseSystems\ClarionPHPBackend\Models\ComposerPackage;
use Illuminate\Http\Request;

class ComposerPackageController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = ComposerPackage::get();
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
        $package = new ComposerPackage;
        $package->name = $request->input('name');
        $package->version = $request->input('version');
        $package->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  ComposerPackage  $composerPackage
     * @return \Illuminate\Http\Response
     */
    public function show(ComposerPackage $composerPackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ComposerPackage  $composerPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(ComposerPackage $composerPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  ComposerPackage  $composerPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComposerPackage $composerPackage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ComposerPackage  $composerPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComposerPackage $composerPackage)
    {
        //
    }
}
