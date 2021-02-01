<?php

namespace MetaverseSystems\ClarionPHPBackend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use MetaverseSystems\ClarionPHPBackend\Models\StoreAppPackage;

class StoreApp extends Model
{
    use HasFactory;

    public function packages()
    {
        return $this->hasMany(StoreAppPackage::class, 'app_id');
    }
}
