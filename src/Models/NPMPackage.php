<?php

namespace MetaverseSystems\ClarionPHPBackend\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NPMPackage extends Model
{
    use HasFactory;

    protected $table = "npm_packages";
}
