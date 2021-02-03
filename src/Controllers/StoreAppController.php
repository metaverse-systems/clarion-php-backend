<?php

namespace MetaverseSystems\ClarionPHPBackend\Controllers;

use MetaverseSystems\ClarionPHPBackend\Models\StoreApp;
use MetaverseSystems\ClarionPHPBackend\Models\StoreAppPackage;
use MetaverseSystems\ClarionPHPBackend\Models\NPMPackage;
use MetaverseSystems\ClarionPHPBackend\Models\ComposerPackage;
use Illuminate\Http\Request;

class StoreAppController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = StoreApp::get();
        return $apps;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  StoreApp  $storeApp
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $storeApp = StoreApp::find($id)->with('packages')->first();
        return $storeApp;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  StoreApp  $storeApp
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreApp $storeApp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $action = $request->input('action');
        switch($action)
        {
            case "install":
                return $this->install($id);
                break;
            case "uninstall":
                return $this->uninstall($id);
                break;
            default:
                // ERROR: Unknown action
                break;
        }
    }

    private function install($id)
    {
        $storeApp = StoreApp::find($id)->with('packages')->first();
        foreach($storeApp->packages as $package)
        {
            switch($package->type)
            {
                case "composer":
                    $c = new ComposerPackage;
                    $c->app_install_id = $package->app_id;
                    $c->name = $package->organization."/".$package->name;
                    $c->version = $package->version;
                    $c->save();
                    break;
                case "npm":
                    $n = new NPMPackage;
                    $n->app_install_id = $package->app_id;
                    $n->name = $package->organization."/".$package->name;
                    $n->version = $package->version;
                    $n->save();
                    break;
                default:
                    // ERROR: Unknown package type 
                    break;
            }
        }

        $storeApp->installed_at = date("Y-m-d H:i:s");
        $storeApp->save();
        return $storeApp;
    }

    private function uninstall($id)
    {
        $storeApp = StoreApp::find($id)->with('packages')->first();
        return $storeApp;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  StoreApp  $storeApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreApp $storeApp)
    {
        //
    }
}
