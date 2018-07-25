<?php

namespace Zvermafia\Lavoter\Contracts;

/**
 * Interface Voteable.
 */
interface Voteable
{
    /**
     * Get relation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function votes();

    /**
     * Get relation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function voteUps();

    /**
     * Get relation.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function voteDowns();
}
