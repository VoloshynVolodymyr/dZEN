<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = false;

    protected $fillable = [
        'user_id',
        'parent_id',
        'text',
        'image',
    ];

    // Відношення до користувача
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}