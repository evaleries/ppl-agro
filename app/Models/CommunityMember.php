<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $community_id
 * @property integer $community_role_id
 * @property string $joined_at
 * @property string $created_at
 * @property string $updated_at
 * @property CommunityEventAttendee[] $communityEventAttendees
 */
class CommunityMember extends Model
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
    protected $fillable = ['user_id', 'community_id', 'community_role_id', 'joined_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communityEventAttendees()
    {
        return $this->hasMany('App\Models\CommunityEventAttendee');
    }
}
