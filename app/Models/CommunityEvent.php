<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $community_id
 * @property string $name
 * @property string $banner
 * @property string $description
 * @property string $location
 * @property int $max_attendees
 * @property string $started_at
 * @property string $ended_at
 * @property string $created_at
 * @property string $updated_at
 * @property Community $community
 * @property CommunityEventAttendee[] $communityEventAttendees
 */
class CommunityEvent extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['community_id', 'name', 'banner', 'description', 'location', 'max_attendees', 'started_at', 'ended_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function community()
    {
        return $this->belongsTo('App\Models\Community');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communityEventAttendees()
    {
        return $this->hasMany('App\Models\CommunityEventAttendee', 'event_id');
    }
}
