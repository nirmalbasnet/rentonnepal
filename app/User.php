<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $guarded = ['id'];

    protected $appends = ['average_rating', 'total_deal', 'total_properties'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function agentRating(){
        return $this->hasMany(AgentRating::class, "agent_id");
    }

    public function ratedByUser(){
        return $this->hasMany(AgentRating::class, "user_id");
    }

    public function getAverageRatingAttribute()
    {
        return (integer) ceil($this->agentRating()->where('publish', 'Yes')->average('rate'));
    }

    public function getTotalDealAttribute(){
        return $this->posts()->whereIn("status", ["Rented", "Sold"])->count();
    }

    public function getTotalPropertiesAttribute(){
        return $this->posts()->where("published", "Yes")->count();
    }

    public function posts(){
        return $this->hasMany(Post::class, "user_id");
    }

    public function getNameAttribute($value){
        return ucwords($value);
    }
}
