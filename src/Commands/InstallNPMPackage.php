<?php

namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;
use Composer\Composer;
use Composer\Installer;
use stdClass;
use MetaverseSystems\ClarionPHPBackend\Models\NPMPackage;

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
     * @return int
     */
    public function handle()
    {
        $packages = new stdClass;
        $packages->dependencies = NPMPackage::whereNull('installed_at')->where('dep_type', 'dependency')->get();
        $packages->devDependencies = NPMPackage::whereNull('installed_at')->where('dep_type', 'devDependency')->get();
        if($this->npmRequire($packages))
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

        foreach($packages->devDependencies as $package)
        {
            $installed = isset($laravel_package->devDependencies->{$package->name});
            if($installed)
            {
                print $package->name." is installed.\n";
                continue;
            }

            $run_install = true;
            $package->installed_at = date('Y-m-d H:i:s');
            $package->save();
            $laravel_package->devDependencies->{$package->name} = $package->version;
        }

        foreach($packages->dependencies as $package)
        {
            $installed = isset($laravel_package->dependencies->{$package->name});
            if($installed)
            {
                print $package->name." is installed.\n";
                continue;
            }

            $run_install = true;
            $package->installed_at = date('Y-m-d H:i:s');
            $package->save();
            $laravel_package->dependencies->{$package->name} = $package->version;
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
