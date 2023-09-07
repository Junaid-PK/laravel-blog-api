<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'image_url'
    ];    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
