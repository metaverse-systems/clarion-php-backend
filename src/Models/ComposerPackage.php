<?php

namespace MetaverseSystems\ClarionPHPBackend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComposerPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'app_install_id',
        'name',
        'version'
    ];
}
