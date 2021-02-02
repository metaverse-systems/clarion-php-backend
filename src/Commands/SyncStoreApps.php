<?php

namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;
use Composer\Composer;
use Composer\Installer;
use MetaverseSystems\ClarionPHPBackend\Models\StoreApp;
use MetaverseSystems\ClarionPHPBackend\Models\StoreAppPackage;

class SyncStoreApps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clarion:apps-sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get latest data from app store';

    private $appStoreUrl = "https://store.clarion.app";

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
        $results = file_get_contents($this->appStoreUrl);
        $apps = json_decode($results);
        foreach($apps as $app)
        {
            $name = explode("/", $app->name);

            $a = StoreApp::where('organization', $name[0])->where('name', $name[1])->where('version', $app->version)->first();
            if(!$a)
            {
                $a = new StoreApp;
            }
            $a->organization = $name[0];
            $a->name = $name[1];
            $a->version = $app->version;
            $a->description = $app->description;
            $a->storepage = $app->storepage;
            $a->author_email = $app->author->email;
            $a->author_name = $app->author->name;
            $a->author_homepage = $app->author->homepage;
            $a->save();

            foreach($app->packages as $package)
            {
                $name = explode("/", $package->name);
                $p = StoreAppPackage::where('app_id', $a->id)->where('type', $package->type)
                                      ->where('organization', $name[0])->where('name', $name[1])
                                      ->where('version', $package->version)->first();
                if(!$p)
                {
                    $p = new StoreAppPackage;
                }

                $p->app_id = $a->id;
                $p->type = $package->type;
                $p->organization = $name[0];
                $p->name = $name[1];
                $p->version = $package->version;
                $p->save();
            }
        }
        return 0;
    }
}
