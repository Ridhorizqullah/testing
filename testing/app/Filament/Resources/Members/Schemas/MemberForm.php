<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->maxLength(255),
                Select::make('position')
                    ->label('Posisi')
                    ->options([
                        'anggota aktif' => 'anggota aktif',
                        'anggota non aktif' => 'anggota non aktif',
                        'Leader' => 'Leader',
                    ])
                   ->native(false)
                   ->required(),
                Textarea::make('bio')
                    ->label('Bio')
                    ->rows(4)
                    ->columnSpanFull(),
                FileUpload::make('photo')
                    ->label('Foto Profil')
                    ->image()
                    ->disk('public')
                    ->directory('members/photos')
                    ->required()
                    ->maxSize(2048)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),

            ]);
    }
}
