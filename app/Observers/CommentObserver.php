<?php

namespace App\Observers;

use App\Models\Comment;
use App\Notifications\ReplyNotification;
use Illuminate\Support\Facades\Log;

class CommentObserver
{
    public function created(Comment $comment){
        if($comment->reply_user_id){
            Log::info('创建评论成功，评论，观察者模式：回复别人');
            $comment->replyUser->notify(new ReplyNotification($comment));
        }else{
            Log::info('评论文章');
            $comment->article->author->notify(new ReplyNotification($comment));
        }
    }
}
