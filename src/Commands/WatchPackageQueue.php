<?php

namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;
use Composer\Composer;
use Composer\Installer;
use MetaverseSystems\ClarionPHPBackend\Models\NPMPackage;
use MetaverseSystems\ClarionPHPBackend\Models\ComposerPackage;

class WatchPackageQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarion:watch-package-queue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monitor package queue for new installation requests';


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
        for($i = 0; $i < 10; $i++)
        {
            \Artisan::call('clarion:composer-install');
            sleep(5);
        }
        return 0;
    }
}
