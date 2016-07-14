<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CommunityLink
 * @package App
 */
class CommunityLink extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'channel_id',
        'link',
        'title'
    ];

    /**
     * A community link has a creator
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Create a new instance and associate it with the given user
     *
     * @param User $user
     * @return static
     */
    public static function from(User $user)
    {
        $link = new static;
        $link->user_id = $user->id;

        if($user->isTrusted()){
            $link->approve();
        }
        return $link;
    }

    /**
     * Contribute the community link
     *
     * @param $attribute
     * @return bool
     */
    public function contribute($attribute)
    {
        return $this->fill($attribute)->save();
    }

    public function approve()
    {
        $this->approved = true;

        return $this;
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }
}
