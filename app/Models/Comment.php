<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['createdAtHuman', 'publishedAtHuman'];

    public function article(){
        return $this->belongsTo(Article::class);
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function replies(){
        return $this->hasMany(Comment::class, 'parent_comment_id');
    }

    public function parentComment(){
        return $this->belongsTo(Comment::class, 'parent_comment_id');
    }

    public function scopePublished(Builder $builder){
        return $builder->where('is_published', 1);
    }

    public function scopeNoReplies(Builder $builder){
        return $builder->where('parent_comment_id', null);
    }

    public function getCreatedAtHumanAttribute(){
        $carbonDate = new Carbon($this->created_at);
        return $carbonDate->diffForHumans();
    }

    public function getPublishedAtHumanAttribute(){
        $carbonDate = new Carbon($this->published_at);
        return $carbonDate->diffForHumans();
    }
}
