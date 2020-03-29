<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['name', 'message', 'post_id', 'parent_comment_id', 'nested_level'];

    /**
     * Setup parent and child relation
     */
    public function children() {
        return $this->hasMany('App\Comment', 'parent_comment_id', 'id');
    }

    /**
     * Get nested comments by child to child relation
     */
    public function grandchildren()
    {
        return $this->children()->with('grandchildren');
    }
}
