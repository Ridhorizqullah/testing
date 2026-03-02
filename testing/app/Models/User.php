<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // FILAMENT: Wajib implement FilamentUser (Filament v5)
    // Menentukan siapa yang boleh masuk ke panel /admin
    // ─────────────────────────────────────────────────────────────────────────
    public function canAccessPanel(Panel $panel): bool
    {
        // Baik admin maupun user biasa bisa masuk panel
        // Pembatasan aksi per-role dilakukan di level Resource Filament
        return in_array($this->role, ['admin', 'user']);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // RELASI
    // ─────────────────────────────────────────────────────────────────────────

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // HELPER ROLE
    // ─────────────────────────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}
