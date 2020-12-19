<?php

namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;

class BuildReactRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarion:routes-build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $laravel_package = json_decode(file_get_contents(base_path('package.json')));
        $import_header = "import React, { Component } from 'react';\n";
        $import_header .= "import { Route, Switch} from 'react-router-dom'\n";
        $routes = "function DynamicRoutes(props) {\n";
        $routes .= "  return <Switch>\n";

        foreach($laravel_package->dependencies as $name=>$version)
        {
            $package_path = base_path("node_modules/$name/package.json");
            $package = json_decode(file_get_contents($package_path));

            if(isset($package->importModules))
            {
                foreach($package->importModules as $mod)
                {
                    $import_header .= "import { $mod } from '$name';\n";
                }
            }
            if(isset($package->routes))
            {
                foreach($package->routes as $route)
                {
                    $routes .= "    <Route exact path=\"".$route->route."\" render={props => <".$route->component." {...props.match.params} />} />\n";
                }
            }
        }

        $routes .= "  </Switch>;\n};\nexport default DynamicRoutes;\n";

        $dyn_routes = $import_header.$routes;
        file_put_contents(base_path("resources/js/components/DynamicRoutes.js"), $dyn_routes);
    }
}
