<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property CommunityRole $communityRole
 */
class CommunityRole extends Model
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
    protected $fillable = ['parent_id', 'name', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function communityRole()
    {
        return $this->belongsTo('App\Models\CommunityRole', 'parent_id');
    }
}
