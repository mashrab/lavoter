<?php

namespace Zvermafia\Lavoter\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Schema;

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
     * @param  Model  $voteable
     * @param  int    $value
     * @return bool
     */
    protected static function cast(Model $voteable, $value = 1, $uuid = null)
    {
        if ( ! $voteable->exists || ! $uuid || ! Uuid::whereuuid($uuid)->first()) {
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

            return ture;
        }

        // Update vote value
        $vote->update['value' => $value]);

        /**
         * If the given model has a vote_total column
         * then fill it with aggregate function sum('value')
         */
        if (Schema::hasColumn($voteable->getTable(), 'vote_total'))
        {
            $voteable = $voteable->fresh(['votes']);
            $voteable->vote_total = $voteable->votes->sum('value');
            $voteable->save();
        }

        return $vote;
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

}
