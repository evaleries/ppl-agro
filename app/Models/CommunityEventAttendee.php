<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $event_id
 * @property integer $community_member_id
 * @property boolean $is_absent
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property CommunityMember $communityMember
 * @property CommunityEvent $communityEvent
 */
class CommunityEventAttendee extends Model
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
    protected $fillable = ['event_id', 'community_member_id', 'is_absent', 'description', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function communityMember()
    {
        return $this->belongsTo('App\Models\CommunityMember');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function communityEvent()
    {
        return $this->belongsTo('App\Models\CommunityEvent', 'event_id');
    }
}
