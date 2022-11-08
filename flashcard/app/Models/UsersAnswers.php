<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersAnswers extends Model
{
    use HasFactory;
    protected $fillable = [
        'answer',
        'user_id',
        'flashcards_id'
    ];

    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the flashcards that owns the phone.
     */
    public function flashcards()
    {
        return $this->belongsTo(Flashcards::class);
    }
}
