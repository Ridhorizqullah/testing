<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory;

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

    // ─────────────────────────────────────────────────────────────────────────
    // BOOT: Auto-generate slug dari name saat create
    // ─────────────────────────────────────────────────────────────────────────
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Member $member) {
            if (empty($member->slug)) {
                $member->slug = static::generateUniqueSlug($member->name);
            }
        });

        static::updating(function (Member $member) {
            if ($member->isDirty('name') && !$member->isDirty('slug')) {
                $member->slug = static::generateUniqueSlug($member->name, $member->id);
            }
        });
    }

    /**
     * Generate slug unik dari nama.
     * Jika slug sudah ada, tambahkan angka: 'budi-santoso-2', dst.
     */
    protected static function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($name);
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

    /**
     * Hanya anggota aktif yang ditampilkan di halaman publik.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Urutkan sesuai sort_order, lalu nama ascending.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // RELASI
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Anggota mungkin memiliki akun user (opsional).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Anggota memiliki banyak karya.
     */
    public function works()
    {
        return $this->hasMany(Work::class)->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    /**
     * Karya yang sudah dipublikasikan (untuk halaman publik).
     */
    public function publishedWorks()
    {
        return $this->hasMany(Work::class)
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // ACCESSOR
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * URL lengkap foto profil, atau placeholder jika tidak ada.
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }

        // Placeholder avatar menggunakan initial nama
        $initial = urlencode(mb_substr($this->name, 0, 1));
        return "https://ui-avatars.com/api/?name={$initial}&size=400&background=random";
    }

    /**
     * Route binding menggunakan slug, bukan ID.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
