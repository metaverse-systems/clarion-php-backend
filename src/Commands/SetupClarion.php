<?php

namespace MetaverseSystems\ClarionPHPBackend\Commands;

use Illuminate\Console\Command;
use Composer\Composer;
use Composer\Installer;
use MetaverseSystems\ClarionPHPBackend\Models\NPMPackage;

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

    private $npm;

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
            "@material-ui/core": "^4.11.2",
            "pusher-js": "^7.0.3",
            "@metaverse-systems/clarion-store-gui": "*"
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
        $node = env('CLARION_NODE');
        if(strlen($node) == 0)
        {
            $node = \Str::uuid();
            $env = file_get_contents(base_path()."/.env");
            $env.= "CLARION_NODE=$node\n";
            file_put_contents(base_path()."/.env", $env);
        }

        $env = explode('\n', file_get_contents(base_path()."/.env"));
        foreach($env as $k=>$v)
        {
            $line = explode('=', $v);
            switch($line[0])
            {
                case "BROADCAST_DRIVER":
                    $env[$k] = "BROADCAST_DRIVER=clarion_pusher";
                    break;
                case "PUSHER_APP_ID":
                    $env[$k] = "PUSHER_APP_ID=".\Str::uuid();
                    break;
                case "PUSHER_APP_KEY":
                    $env[$k] = "PUSHER_APP_KEY=".\Str::uuid();
                    break;
                case "PUSHER_APP_SECRET":
                    $env[$k] = "PUSHER_APP_SECRET=".\Str::uuid();
                    break;
                default:
                    break;
            }
        }
        file_put_contents(base_path()."/.env", implode('\n',$env));

        \Artisan::call('vendor:publish', [
            '--provider' => 'MetaverseSystems\ClarionPHPBackend\ClarionPHPBackendProvider',
            '--force' => true
        ]);

        \Artisan::call('migrate');

        foreach($this->npm->devDependencies as $name=>$version)
        {
            $p = new NPMPackage;
            $p->dep_type = "devDependency";
            $p->name = $name;
            $p->version = $version;
            $p->save();
        }

        foreach($this->npm->dependencies as $name=>$version)
        {
            $p = new NPMPackage;
            $p->name = $name;
            $p->version = $version;
            $p->save();
        }

        \Artisan::call('clarion:npm-install');
        \Artisan::call('clarion:frontend-build');
        \Artisan::call('clarion:apps-sync');
        \Artisan::call('clarion:cron-setup');
        return 0;
    }
}
