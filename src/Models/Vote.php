<?php

namespace Zvermafia\Lavoter\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Vote.
 */
class Vote extends Model
{
    /**
     * @var string
     */
    protected $table = 'lavoter_votes';

    /**
     * @var array
     */
    protected $fillable = ['voteable_id', 'voteable_type', 'uuide', 'value'];

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function voteable()
    {
        return $this->morphTo();
    }

    /**
     * @param Model $voteable
     *
     * @return mixed
     */
    public static function sum(Model $voteable)
    {
        return $voteable->votes()
                        ->sum('value');
    }

    /**
     * @param Model $voteable
     *
     * @return mixed
     */
    public static function count(Model $voteable)
    {
        return $voteable->votes()
                        ->count();
    }

    /**
     * @param Model $voteable
     * @param int   $value
     *
     * @return mixed
     */
    public static function countUps(Model $voteable, $value = 1)
    {
        return $voteable->votes()
                        ->where('value', $value)
                        ->count();
    }

    /**
     * @param Model $voteable
     * @param int   $value
     *
     * @return mixed
     */
    public static function countDowns(Model $voteable, $value = -1)
    {
        return $voteable->votes()
                        ->where('value', $value)
                        ->count();
    }

    /**
     * @param Model $voteable
     * @param       $from
     * @param null  $to
     *
     * @return mixed
     */
    public static function countByDate(Model $voteable, $from, $to = null)
    {
        $query = $voteable->votes();

        if (!empty($to)) {
            $range = [new Carbon($from), new Carbon($to)];
        } else {
            $range = [
                ( new Carbon($from) )->startOfDay(),
                ( new Carbon($to) )->endOfDay(),
            ];
        }

        return $query->whereBetween('created_at', $range)
                     ->count();
    }

    /**
     * @param Model $voteable
     * @param string $uuide
     *
     * @return bool
     */
    public static function up(Model $voteable, $uuide = null)
    {
        return static::cast($voteable, 1, $uuide);
    }


    /**
     * @param Model $voteable
     * @param string $uuide
     *
     * @return bool
     */
    public static function down(Model $voteable, $uuide = null)
    {
        return static::cast($voteable, -1, $uuide);
    }

    /**
     * @param  Model   $voteable
     * @param  string  $uuide
     * @param  integer $value
     * 
     * @return boolean
     */
    public static function isAlreadyVoted(Model $voteable, $uuide = null, $value = 1)
    {
        $item = $voteable->votes()
                         ->where('uuide', $uuide)
                         ->where('value', $value)
                         ->first();

        return $item ? true : false;
    }

    /**
     * @param  Model   $voteable
     * @param  string  $uuide
     * 
     * @return boolean
     */
    public static function isAlreadyVotedUp(Model $voteable, $uuide = null)
    {
        return static::isAlreadyVoted($voteable, $uuide, 1);
    }

    /**
     * @param  Model   $voteable
     * @param  string  $uuide
     * 
     * @return boolean
     */
    public static function isAlreadyVotedDown(Model $voteable, $uuide = null)
    {
        return static::isAlreadyVoted($voteable, $uuide, -1);
    }

    /**
     * @param $value
     */
    public function setValueAttribute($value)
    {
        $this->attributes[ 'value' ] = ($value == -1) ? -1 : 1;
    }

    /**
     * @param Model $voteable
     * @param int   $value
     *
     * @return bool
     */
    protected static function cast(Model $voteable, $value = 1, $uuide = null)
    {
        if ( ! $voteable->exists || ! $uuide || ! Uuide::whereUuide($uuide)->first()) {
            return false;
        }

        $vote = static::firstOrCreate([
            'voteable_id'   => $voteable->id,
            'voteable_type' => get_class($voteable),
            'uuide'         => $uuide,
        ]);

        /**
         * If step_back parameter is ture
         */
        if (config('lavoter.step_back') && $vote->value != 0 && $vote->value != $value)
        {
            $vote->delete();

            return null;
        }

        $vote->value = $value;
        $vote = $vote->voteable()
                    ->associate($voteable)
                    ->save();

        /**
         * If the given model has a vote_total column
         * then fill it with aggregate function sum('value')
         */
        if (\Schema::hasColumn($voteable->getTable(), 'vote_total'))
        {
            $voteable = $voteable->fresh(['votes']);
            $voteable->vote_total = $voteable->votes->sum('value');
            $voteable->save();
        }

        return $vote;
    }
}
