<?php

namespace Zvermafia\Lavoter\Traits;

use Zvermafia\Lavoter\Models\Vote;

/**
 * Class Voteable.
 */
trait Voteable
{
    /**
     * Get relation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    /**
     * Get sum of all votes for a given item of the model.
     * 
     * @return integer
     */
    public function getVoteTotalAttribute()
    {
        return $this->votes()->sum('value');
    }

    /**
     * Get count of vote ups for a given item of the model.
     * 
     * @return integer
     */
    public function getVoteUpsAttribute()
    {
        return $this->votes()->whereValue(1)->count();
    }

    /**
     * Get count of vote downs for a given item of the model.
     * 
     * @return integer
     */
    public function getVoteDownsAttribute()
    {
        return $this->votes()->whereValue(-1)->count();
    }
}
