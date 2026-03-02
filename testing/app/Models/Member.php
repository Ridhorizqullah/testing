<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Member extends Model
{
    protected $table = 'members';

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'position',
        'bio',
        'photo',
        'email',
        'phone',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ── Auto-generate Slug ────────────────────────────────────

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Member $member) {
            if (empty($member->slug)) {
                $member->slug = static::generateUniqueSlug($member->name);
            }
        });

        static::updating(function (Member $member) {
            if ($member->isDirty('name') && ! $member->isDirty('slug')) {
                $member->slug = static::generateUniqueSlug($member->name, $member->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug  = Str::slug($name);
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function works(): HasMany
    {
        return $this->hasMany(Work::class)->orderBy('sort_order');
    }
}
