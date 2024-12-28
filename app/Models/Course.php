<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';
    protected $fillable = ['plataform_id', 'name', 'total_modules', 'total_classes', 'done_modules', 'done_classes'];

    public function plataform() {
        return $this->belongsTo(Plataform::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function annotations() {
        return $this->hasMany(Annotation::class);
    }
}
