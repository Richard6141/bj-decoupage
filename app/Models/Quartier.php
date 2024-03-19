<?php

namespace App\Models;

use App\Models\Arrondissement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quartier extends Model
{
    use HasFactory;

    protected $hidden = ['arrondissement_id', 'created_at', 'updated_at'];
}