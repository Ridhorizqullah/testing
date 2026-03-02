<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    // ─────────────────────────────────────────────────────────────────────────
    // BOOT: Auto-generate slug dari name
    // ─────────────────────────────────────────────────────────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // ─────────────────────────────────────────────────────────────────────────
    // RELASI
    // ─────────────────────────────────────────────────────────────────────────

    public function works()
    {
        return $this->hasMany(Work::class);
    }
}
