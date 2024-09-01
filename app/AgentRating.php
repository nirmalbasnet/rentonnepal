<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentRating extends Model
{
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function agent(){
        return $this->belongsTo(User::class, "agent_id");
    }
}
