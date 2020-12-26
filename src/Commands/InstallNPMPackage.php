<?php

namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;
use Composer\Composer;
use Composer\Installer;
use stdClass;

class InstallNPMPackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarion:npm-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install queued NPM packages';

    protected $npm;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->npm = json_decode('{
          "devDependencies": {
            "@babel/preset-react": "^7.10.1",
            "react": "^16.13.1",
            "react-dom": "^16.13.1"
          },
          "dependencies": {
            "@babel/plugin-proposal-class-properties": "^7.10.1",
            "react-router-dom": "^5.2.0",
            "@material-ui/core": "^4.11.2"
          }
        }');
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->npmRequire($this->npm))
        {
            $this->npmInstall();
        }
        return 0;
    }

    private function npmRequire($packages)
    {
        $run_install = false;

        $laravel_package = json_decode(file_get_contents(base_path('package.json')));
        if(!isset($laravel_package->devDependencies)) $laravel_package->devDependencies = new \stdClass;
        if(!isset($laravel_package->dependencies)) $laravel_package->dependencies = new \stdClass;

        foreach($packages->devDependencies as $name=>$version)
        {
            $installed = isset($laravel_package->devDependencies->$name);
            if($installed)
            {
                print "$name is installed.\n";
                continue;
            }

            $run_install = true;
            $laravel_package->devDependencies->$name = $version;
        }

        foreach($packages->dependencies as $name=>$version)
        {
            $installed = isset($laravel_package->dependencies->$name);
            if($installed)
            {
                print "$name is installed.\n";
                continue;
            }

            $run_install = true;
            $laravel_package->dependencies->$name = $version;
        }

        if(!$run_install) return false;

        file_put_contents(base_path('package.json'), json_encode($laravel_package, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        return true;
    }

    private function npmInstall()
    {
        exec(base_path("vendor/bin/npm i"));
    }
}
