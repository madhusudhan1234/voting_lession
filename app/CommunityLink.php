<?php

namespace App;

use App\Exceptions\CommunityLinkAlreadySubmitted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Builder;

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
     * Scope The query to records from a particular channel
     *
     * @param  Builder $builder
     * @param Channel $channel
     * @return Builder
     */
    public static function scopeForChannel($builder, $channel)
    {
        if($channel->exists){
            return $builder->where('channel_id',$channel->id);
        }

        return $builder;
    }

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
     * Contribute The Community Link
     *
     * @param $attributes
     * @return bool
     * @throws CommunityLinkAlreadySubmitted
     */
    public function contribute($attributes)
    {
        if($existing = $this->hasAlreadyBeenSubmitted($attributes['link'])){
            return $existing->touch();

            throw new CommunityLinkAlreadySubmitted();
        }

        return $this->fill($attributes)->save();
    }

    /**
     * Mark The community link as approved
     *
     * @return $this
     */
    public function approve()
    {
        $this->approved = true;

        return $this;
    }

    /**
     * CommunityLink Belong To Channel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /*
     *A Community Link may have many votes
     *
     *@return \Illiminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(CommunityLinkVote::class,'community_link_id');
    }

    /**
     * Check If there is link already Exist
     *
     * @param $link
     * @return mixed
     */
    protected function hasAlreadyBeenSubmitted($link)
    {
        return static::where('link',$link)->first();
    }
}
