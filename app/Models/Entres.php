<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entres extends Model
{
    use HasFactory;

    protected $fillable = [
        'plaque',
        'type',
        'name',
        'phone',
        'user_id',
        
    ];

    public function sortie()
{
    return $this->hasOne(Sorties::class, 'entree_id');
}
}



