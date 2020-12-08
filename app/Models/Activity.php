<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table = 'activity_log';
    protected $fillable = ['*'];

    /**
     * Relation to User id
     *
     * @return void
     */
    public function getUser(){
        return $this->belongsTo(User::class,'causer_id','id');
    }

    /**
     * Relation to subject id
     *
     * @return void
     */
    public function getSubject(){
        return $this->belongsTo(User::class,'subject_id','id');
    }
}
