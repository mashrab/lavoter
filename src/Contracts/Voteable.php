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
     * Get sum of all votes for a given item of the model.
     * 
     * @return integer
     */
    public function getVoteTotalAttribute();

    /**
     * Get count of vote ups for a given item of the model.
     * 
     * @return integer
     */
    public function getVoteUpsAttribute();

    /**
     * Get count of vote downs for a given item of the model.
     * 
     * @return integer
     */
    public function getVoteDownsAttribute();
}
