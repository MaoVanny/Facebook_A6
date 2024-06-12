<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'description',

    ];
    public static function list(){
        return self::all();
    }
    public function createComment($userId,$postID,$description){
        $comment = new Comment();
        $comment->user_id = $userId;
        $comment->post_id = $postID;
        $comment->description = $description;
        try{
            $comment->save();
            return $comment;
        }catch(Exception $erorr){
            return $erorr->getMessage();
        }
    }
    public function updateComment($description){
        $id = $this -> id;
        $comment = Comment::where('id',$id)->first();
        $comment->description = $description;
        try{
            $this->save();
            return $this;
        }catch(Exception $erorr){
            return $erorr->getMessage();
        }
    }
    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function post():BelongsTo{
        return $this->belongsTo(Post::class);
    }
}
