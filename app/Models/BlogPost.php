<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPost extends Model
{
    use HasFactory;

    protected $table = 'blog_posts';

    protected $fillable = [
        'title',
        'description',
        'publication_date',
        'user_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
    ];

    protected $dates = [
        'publication_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function blogPostIntro($count = 100): string
    {
        return substr($this->description, 0, $count) . '...';
    }
}
