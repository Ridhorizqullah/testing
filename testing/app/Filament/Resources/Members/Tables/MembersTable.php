<?php

namespace App\Filament\Resources\Members\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // Foto — klik langsung navigate ke halaman edit
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->height(64)
                    ->width(64)
                    ->circular()
                    ->defaultImageUrl('https://ui-avatars.com/api/?name=?&background=6366f1&color=fff&size=64')
                    ->url(fn ($record) => route('filament.admin.resources.kelola-member.edit', ['record' => $record]))
                    ->openUrlInNewTab(false),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),

                // Posisi anggota — tampil sebagai badge teks
                TextColumn::make('position')
                    ->label('Posisi')
                    ->searchable()
                    ->badge(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Status Anggota')
                    ->trueLabel('Aktif')
                    ->falseLabel('Non-Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
