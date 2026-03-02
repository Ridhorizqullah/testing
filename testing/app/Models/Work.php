<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Work extends Model
{
    protected $fillable = [
        'member_id',
        'category_id',
        'title',
        'slug',
        'description',
        'image',
        'image_thumbnail',
        'external_link',
        'is_published',
        'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    // ── Auto-generate Slug ────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Work $work) {
            if (empty($work->slug)) {
                $work->slug = static::generateUniqueSlug($work->title);
            }
        });

        static::updating(function (Work $work) {
            if ($work->isDirty('title') && ! $work->isDirty('slug')) {
                $work->slug = static::generateUniqueSlug($work->title, $work->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug  = Str::slug($title);
        $count = 0;

        while (true) {
            $candidate = $count === 0 ? $slug : "{$slug}-{$count}";
            $query     = static::where('slug', $candidate);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            if (! $query->exists()) {
                return $candidate;
            }
            $count++;
        }
    }

    // ── Relasi ────────────────────────────────────────────────

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
