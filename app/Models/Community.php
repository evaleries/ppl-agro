<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property boolean $is_active
 * @property string $name
 * @property string $founder
 * @property string $logo
 * @property string $description
 * @property string $founded_at
 * @property string $created_at
 * @property string $updated_at
 * @property CommunityEvent[] $communityEvents
 */
class Community extends Model
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
    protected $fillable = ['is_active', 'name', 'founder', 'logo', 'description', 'founded_at', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function communityEvents()
    {
        return $this->hasMany('App\Models\CommunityEvent');
    }
}
