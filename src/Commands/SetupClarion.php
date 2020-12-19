<?php

namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;
use Composer\Composer;
use Composer\Installer;

class SetupClarion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarion:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure Clarion';

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
        \Artisan::call('vendor:publish', [
            '--provider' => 'MetaverseSystems\ClarionPHPBackend\ClarionPHPBackendProvider',
            '--force' => true
        ]);
        return 0;
    }
}
