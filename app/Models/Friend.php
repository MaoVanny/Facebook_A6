<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'friend_id'
    ];
    
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friend_requests', 'user_id', 'friend_id');
    }

}
