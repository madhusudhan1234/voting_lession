<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Return the value of trusted of $user
     *
     * @return mixed
     */
    public function isTrusted()
    {
        return !!$this->trusted;
    }

    public function voteFor(CommunityLink $link)
    {
        return $link->votes()->create(['user_id'=>$this->id]);
    }

    public function votedFor(CommunityLink $link)
    {
        return $link->votes->contains('user_id',$this->id);
    }
}
