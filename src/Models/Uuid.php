<?php

namespace Zvermafia\Lavoter\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Uuid.
 */
class Uuid extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'lavoter_uuids';

	/**
	 * @var array
	 */
	protected $fillable = ['uuid'];

    /**
     * @var array
     */
    protected $guarded = ['created_at'];

    /**
     * @var boolean
     */
	public $timestamps = false;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
	public static function boot()
	{
	    parent::boot();

	    static::creating(function ($model)
	    {
	        $model->setCreatedAt($model->freshTimestamp());
	    });
	}

    /**
     * Get the model's uuid property.
     * 
     * @return string
     */
	public function getUuidAttribute()
	{
		return (string) $this->attributes['uuid'];
	}
}
