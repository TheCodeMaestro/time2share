<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category',
        'deadline',
        'user_id',
        'loaner_id',
        'status',
        'image_path',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function loaner()
    {
        return $this->belongsTo(User::class, 'loaner_id')->withDefault();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
