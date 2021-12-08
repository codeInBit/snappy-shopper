<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;
    use HasFactory;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'name', 'price', 'type'
    ];

    /**
     * Type values
     *
     * @var array
     */
    public const TYPE = [
        'flat' => 'Flat',
        'detached-house' => 'Detached House',
        'attached-house' => 'Attached House',
    ];

    /**
     * The agents that belong to the property.
     */
    public function agents()
    {
        return $this->belongsToMany('App\Models\Agent', 'agent_property', 'property_id', 'agent_id')
            ->withPivot('role')->withTimestamps();
    }
}
