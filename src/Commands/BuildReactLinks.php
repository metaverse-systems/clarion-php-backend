<?php
  
namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;

class BuildReactLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarion:links-build';

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
        $import_header .= "import { Button, TextField } from '@material-ui/core';\n";
        $links = "function DynamicLinks(props) {\n";
        $links .= "  return <div style={ {textAlign: 'center', width: '100%'} }>\n";

        foreach($laravel_package->dependencies as $name=>$version)
        {   
            $package_path = base_path("node_modules/$name/package.json");
            $package = json_decode(file_get_contents($package_path));

            if(!isset($package->link)) continue;

            $links .= "    <a href=\"".$package->link->href."\">";
            $links .= "<Button color=\"primary\" variant=\"contained\" style={ {marginRight: '15px'} }>";
            $links .= $package->link->text."</Button></a>\n";
        }

        $links .= "  </div>;\n};\nexport default DynamicLinks;\n";

        $dyn_links = $import_header.$links;
        file_put_contents(base_path("resources/js/components/DynamicLinks.js"), $dyn_links);
    }
}
