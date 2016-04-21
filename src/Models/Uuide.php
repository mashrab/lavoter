<?php

namespace Zvermafia\Lavoter\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Uuide.
 */
class Uuide extends Model
{
	/**
	 * @var string
	 */
	protected $table = 'lavoter_uuides';

	/**
	 * @var array
	 */
	protected $fillable = ['uuide'];

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
     * Get the model's uuide property.
     * 
     * @return string
     */
	public function getUuideAttribute()
	{
		return (string) $this->attributes['uuide'];
	}
}
