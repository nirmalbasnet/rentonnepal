<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];

    public function postImages(){
        return $this->hasMany(PostImage::class);
    }

    public function agent(){
        return $this->belongsTo(User::class, "user_id");
    }
}
