<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name'];

    public function faculty()
    {
        return $this->hasOne(Faculty::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
