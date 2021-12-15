<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = ['code' , 'title'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
