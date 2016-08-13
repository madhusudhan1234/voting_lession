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

    public function votes()
    {
        return $this->belongsToMany(CommunityLink::class,'community_link_votes')->withTimeStamps();
    }

    /*public function voteFor(CommunityLink $link)
    {
        return $link->votes()->sync([$link->id],false);
    }

    public function unvoteFor(CommunityLink $link)
    {
        return $this->votes()->detach($link);
    }*/

    public function togglevoteFor(CommunityLink $link)
    {
        CommunityLinkVote::firstOrNew([
            'user_id' => $this->id,
            'community_link_id' => $link->id
            ])->toggle();
    }

    public function votedFor(CommunityLink $link)
    {
        return $link->votes->contains('user_id',$this->id);
    }
}
