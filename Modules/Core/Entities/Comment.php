<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Comment
 * @package Modules\Platform\Core\Entities
 */
class Comment extends Model
{
    const UPVOTES_TABLE_NAME = 'comments_user_upvotes';

    protected $fillable = [
        'comment',
        'upvote',
        'approved',
        'commentable_id',
        'commentable_type',
        'commented_id',
        'commented_type',
        'parent_id'
    ];

    public $table = 'comments';

    protected $casts = [
        'approved' => 'boolean'
    ];



    public function commentable()
    {
        return $this->morphTo();
    }

    public function commented()
    {
        return $this->morphTo();
    }

    /**
     * @return $this
     */
    public function approve()
    {
        $this->approved = true;
        $this->save();

        return $this;
    }
}
