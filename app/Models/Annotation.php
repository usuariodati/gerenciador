<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Annotation extends Model
{
    protected $table = 'annotations';
    protected $fillable = ['course_id', 'module', 'title', 'content'];

    public function course() {
        return $this->belongsTo(Course::class);
    }

}
