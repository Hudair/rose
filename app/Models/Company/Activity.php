<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

      protected $table = 'activities';

    /**
     * Mass Assignable fields of model
     * @var array
     */

    protected $fillable = [

    ];

    /**
     * Default values for model fields
     * @var array
     */
    protected $attributes = [
    ];
    /**
     * Guarded fields of model
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('ins', function ($builder) {
            $builder->where('ins', '=', auth()->user()->ins);
        });
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Access\User\User')->withoutGlobalScopes();
    }
}
