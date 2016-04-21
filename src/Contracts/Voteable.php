<?php

namespace Zvermafia\Lavoter\Contracts;

/**
 * Interface Voteable.
 */
interface Voteable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function votes();
}
