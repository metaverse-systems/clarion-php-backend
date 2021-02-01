<?php

namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;
use Composer\Composer;
use Composer\Installer;
use MetaverseSystems\ClarionPHPBackend\Models\ComposerPackage;

class InstallComposerPackage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarion:composer-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install queued composer packages';

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
        $packages = ComposerPackage::whereNull('installed_at')->get();
        if($this->composerRequire($packages))
        {
            $this->composerInstall($packages);
        }
        return 0;
    }

    private function composerRequire($packages)
    {
        $run_install = false;

        $laravel_composer = json_decode(file_get_contents(base_path('composer.json')));

        foreach($packages as $package)
        {
            $installed = \Composer\InstalledVersions::isInstalled($package->name);
            if($installed)
            {
                print $package->name." is installed.\n";
                continue;
            }

            $run_install = true;
            $package->installed_at = date('Y-m-d H:i:s');
            $package->save();
            $laravel_composer->require->{$package->name} = $package->version;
        }

        if(!$run_install) return false;

        file_put_contents(base_path('composer.json'), json_encode($laravel_composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return true;
    }

    private function composerInstall()
    {
        $io = new \Composer\IO\NullIO;
        $composer = \Composer\Factory::create($io, base_path('composer.json'));
        $installer = \Composer\Installer::create($io, $composer);
        $installer->setUpdate(true)->run();
    }
}
