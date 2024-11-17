<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plataform extends Model
{
    protected $table = 'plataforms';
    protected $fillable = ['name'];

    public function courses() {
        return $this->hasMany(Course::class);
    }
}
