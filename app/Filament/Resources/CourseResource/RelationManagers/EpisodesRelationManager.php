<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EpisodesRelationManager extends RelationManager
{
    protected static string $relationship = 'episodes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('vimeo_id')
                    ->label('Vimeo ID')
                    ->required(),
                Forms\Components\TextInput::make('length_in_minutes')
                    ->suffix('Minutes')
                    ->numeric()
                    ->hint('Video lenght in minutes')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\Textarea::make('overview')
                    ->required()
                    ->columnSpanFull()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('vimeo_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->grow(),
                Tables\Columns\TextColumn::make('formatted_length')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
