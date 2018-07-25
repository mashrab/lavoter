<?php

namespace Zvermafia\Lavoter\Traits;

use Zvermafia\Lavoter\Models\Vote;

/**
 * Class Voteable.
 */
trait Voteable
{
    /** @return \Illuminate\Database\Eloquent\Relations\MorphMany */
    public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    /** @return \Illuminate\Database\Eloquent\Relations\MorphMany */
    public function voteUps()
    {
        return $this->morphMany(Vote::class, 'voteable')
            ->whereValue(1);
    }

    /** @return \Illuminate\Database\Eloquent\Relations\MorphMany */
    public function voteDowns()
    {
        return $this->morphMany(Vote::class, 'voteable')
            ->whereValue(-1);
    }
}
