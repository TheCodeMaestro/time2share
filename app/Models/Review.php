<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        $table->string('titel');
        $table->text('message')->nullable();
        $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('reviewed_user_id')->constrained('users')->onDelete('cascade');
        $table->unsignedInt('score');
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function reviewedUser()
    {
        return $this->belongsTo(User::class, 'reviewed_user_id');
    }
}
