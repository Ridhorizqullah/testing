<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Work extends Model
{
    use HasFactory;

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

    // ─────────────────────────────────────────────────────────────────────────
    // BOOT: Auto-generate slug dari title saat create
    // ─────────────────────────────────────────────────────────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Work $work) {
            if (empty($work->slug)) {
                $work->slug = static::generateUniqueSlug($work->title);
            }
        });

        static::updating(function (Work $work) {
            if ($work->isDirty('title') && !$work->isDirty('slug')) {
                $work->slug = static::generateUniqueSlug($work->title, $work->id);
            }
        });
    }

    /**
     * Generate slug unik dari judul karya.
     */
    protected static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug     = $baseSlug;
        $counter  = 2;

        while (
            static::where('slug', $slug)
                ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    // ─────────────────────────────────────────────────────────────────────────
    // SCOPES
    // ─────────────────────────────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // RELASI
    // ─────────────────────────────────────────────────────────────────────────

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // ACCESSOR
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * URL gambar penuh.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    /**
     * URL thumbnail.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->image_thumbnail) {
            return asset('storage/' . $this->image_thumbnail);
        }
        // Fallback ke gambar penuh jika tidak ada thumbnail
        return $this->imageUrl;
    }

    /**
     * Route binding menggunakan slug.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
