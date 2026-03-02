<?php

namespace App\Filament\Resources\Works\Schemas;

use App\Models\Category;
use App\Models\Member;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;



class WorkForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ── Baris 1: Pilih Anggota & Kategori ────────────────
                Select::make('member_id')
                    ->label('Anggota Pemilik')
                    ->options(Member::orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Select::make('category_id')
                    ->label('Kategori')
                    ->options(Category::orderBy('name')->pluck('name', 'id'))
                    ->searchable()
                    ->nullable()
                    ->placeholder('— Tanpa Kategori —'),

                // ── Baris 2: Judul & Slug ─────────────────────────────
                TextInput::make('title')
                    ->label('Judul Karya')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (callable $set, ?string $state) =>
                        $set('slug', Str::slug($state ?? ''))
                    ),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Otomatis terisi dari judul.'),

                // ── Deskripsi ─────────────────────────────────────────
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(4)
                    ->columnSpanFull(),

                // ── Link Eksternal ────────────────────────────────────
                TextInput::make('external_link')
                    ->label('Link Demo / Eksternal')
                    ->url()
                    ->maxLength(500)
                    ->placeholder('https://...')
                    ->columnSpanFull(),

                // ── Upload Gambar Utama ───────────────────────────────
                FileUpload::make('image')
                    ->label('Gambar Karya (Utama)')
                    ->image()
                    ->disk('public')
                    ->directory('works/images')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(5120)
                    ->helperText('Maks. 5MB. Format: JPG, PNG, WebP.'),

                // ── Upload Thumbnail ──────────────────────────────────
                FileUpload::make('image_thumbnail')
                    ->label('Thumbnail Karya')
                    ->image()
                    ->disk('public')
                    ->directory('works/thumbnails')
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->maxSize(2048)
                    ->helperText('Versi kecil untuk grid/list. Maks. 2MB.'),

                // ── Toggle Publikasi & Urutan ─────────────────────────
                Toggle::make('is_published')
                    ->label('Tampilkan di Publik')
                    ->default(true),

                TextInput::make('sort_order')
                    ->label('Urutan Tampil')
                    ->numeric()
                    ->default(0),
            ]);
    }
}
