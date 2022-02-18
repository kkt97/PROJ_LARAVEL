<?php

namespace App\Models\Board;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'image_name',
        'image_path',
        'image_name_2',
        'image_path_2'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
