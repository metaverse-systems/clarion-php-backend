<?php

namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;
use MetaverseSystems\ClarionPHPBackend\CronJob;

class SetupCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarion:cron-setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configure cron job';

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
        $c = new CronJob(base_path());
        if(!$c->checkCrontab())
        {
            print "Installing cron job.\n";
            $c->installCrontab();
        }
        return 0;
    }
}
