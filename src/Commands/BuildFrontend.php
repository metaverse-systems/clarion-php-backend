<?php

namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;
use Composer\Composer;
use Composer\Installer;

class BuildFrontend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarion:frontend-build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rebuild frontend';

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
        \Artisan::call('clarion:routes-build');
        \Artisan::call('clarion:links-build');
        exec(base_path("vendor/bin/npm run prod"));
        return 0;
    }
}
