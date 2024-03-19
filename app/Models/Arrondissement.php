<?php

namespace App\Models;

use App\Models\Quartier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Arrondissement extends Model
{
    use HasFactory;
    protected $fillable = ['label'];
    protected $hidden = ['commune_id', 'created_at', 'updated_at'];

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function quartiers()
    {
        return $this->hasMany(Quartier::class);
    }
}