<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;
    
    protected $fillable = ['label'];

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }

    protected $hidden = ['created_at', 'updated_at'];
}