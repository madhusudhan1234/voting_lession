<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Channel
 * @package App
 */
class Channel extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'color',
    ];

    /**
     * Return The Slug
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
