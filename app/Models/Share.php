<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'content'
    ];

    public static function list()
    {
        return self::all();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
