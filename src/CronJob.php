<?php

namespace MetaverseSystems\ClarionPHPBackend;

class CronJob
{
    private $path;

    public function __construct()
    {
        $this->path = base_path();
    }

    public function getCronLine()
    {
        return "* * * * * cd ".$this->path." && /usr/bin/php artisan schedule:run >> /dev/null 2>&1";
    }

    public function checkCrontab()
    {
        exec("crontab -l", $crontab);
        foreach($crontab as $line)
        {
            if($line == $this->getCronLine()) return true;
        }
        return false;
    }

    public function installCrontab()
    {
        exec("crontab -l", $lines);
        $crontab = implode("\n", $lines)."\n";
        $crontab .= $this->getCronLine()."\n";
        $tmpCron = "/tmp/".uniqid();
        file_put_contents($tmpCron, $crontab);
        exec("crontab $tmpCron");
        unlink($tmpCron);
    }
}
