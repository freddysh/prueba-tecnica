<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regiones extends Model
{
    use HasFactory;
    protected $table='regiones';
    public function provincias()
    {
        return $this->hasMany(Provincia::class, 'region_id');
    }

}
