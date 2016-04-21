<?php

namespace Zvermafia\Lavoter\Traits;

use Zvermafia\Lavoter\Models\Vote;

/**
 * Class Voteable.
 */
trait Voteable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function getVoteUpsAttribute()
    {
        return $this->votes()->whereValue(1)->count();
    }

    public function getVoteDownsAttribute()
    {
        return $this->votes()->whereValue(-1)->count();
    }
}
