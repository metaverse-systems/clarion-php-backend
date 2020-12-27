<?php

namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;
use Composer\Composer;
use Composer\Installer;
use MetaverseSystems\ClarionPHPBackend\Models\ComposerPackage;

class MigrateClarion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarion:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run queued migrations';

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
        $packages = ComposerPackage::whereNotNull('installed_at')->where('migration_waiting', true)->get();
        if(count($packages))
        {
            \Artisan::call('migrate');
        }

        foreach($packages as $p)
        {
            $p->migration_waiting = false;
            $p->save();
        }
        return 0;
    }
}
