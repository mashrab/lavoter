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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lavoter_votes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['voteable_id', 'voteable_type', 'uuid', 'value'];

    /**
     * The attributes that aren't mass assignable.
     *
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
     * @param  int  $value
     * @return void
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = ($value === -1) ? -1 : 1;
    }

    /**
     * @param  Model  $voteable
     * @return int
     */
    public static function sum(Model $voteable)
    {
        return $voteable->votes()
                        ->sum('value');
    }

    /**
     * @param  Model  $voteable
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
     * @param  Model  $voteable
     * @param  int    $value
     * @return int
     */
    public static function countDowns(Model $voteable, $value = -1)
    {
        return $voteable->votes()
                        ->where('value', $value)
                        ->count();
    }

    /**
     * @param  Model   $voteable
     * @param  string  $from
     * @param  string  $to
     * @return int
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
     * @param  Model   $voteable
     * @param  string  $uuid
     * @return bool
     */
    public static function up(Model $voteable, $uuid = null)
    {
        return static::cast($voteable, 1, $uuid);
    }


    /**
     * @param  Model   $voteable
     * @param  string  $uuid
     * @return bool
     */
    public static function down(Model $voteable, $uuid = null)
    {
        return static::cast($voteable, -1, $uuid);
    }

    /**
     * @param  Model   $voteable
     * @param  string  $uuid
     * @return boolean
     */
    public static function isAlreadyVotedUp(Model $voteable, $uuid = null)
    {
        return static::isAlreadyVoted($voteable, $uuid, 1);
    }

    /**
     * @param  Model   $voteable
     * @param  string  $uuid
     * @return boolean
     */
    public static function isAlreadyVotedDown(Model $voteable, $uuid = null)
    {
        return static::isAlreadyVoted($voteable, $uuid, -1);
    }

    /**
     * @param  Model   $voteable
     * @param  string  $uuid
     * @param  int     $value
     * @return boolean
     */
    public static function isAlreadyVoted(Model $voteable, $uuid = null, $value == null)
    {
        $voteable->votes()->where('uuid', $uuid);

        if ( ! is_null($value))
            $voteable->where('value', $value);

        return $voteable->first() ? true : false;
    }

    /**
     * @param  Model  $voteable
     * @param  int    $value
     * @return bool
     */
    protected static function cast(Model $voteable, $value = 1, $uuid = null)
    {
        if ( ! $voteable->exists || ! $uuid || ! uuid::whereuuid($uuid)->first()) {
            return false;
        }

        $vote = static::firstOrCreate([
            'voteable_id'   => $voteable->id,
            'voteable_type' => get_class($voteable),
            'uuid'          => $uuid,
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
