<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Geoobject;
use Filament\Tables\Table;
use App\Rules\LatitudeRule;
use App\Rules\LongitudeRule;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GeographicalObjectResource\Pages;
use App\Filament\Resources\GeographicalObjectResource\RelationManagers;

class GeographicalObjectResource extends Resource
{
    protected static ?string $model = Geoobject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Geography';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name') 
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('lat')
                    ->required()
                    ->rules([new LatitudeRule()]),
                Forms\Components\TextInput::make('long')
                    ->required()
                    ->rules([new LongitudeRule()]),
                Forms\Components\Select::make('city_id')
                    ->relationship('city', 'name')
                    ->preload()
                    ->required()
                    ->searchable()
                    ->columnSpanFull(), 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'), 
                Tables\Columns\TextColumn::make('lat'),
                Tables\Columns\TextColumn::make('long'),
                Tables\Columns\TextColumn::make('city.name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGeographicalObjects::route('/'),
            'create' => Pages\CreateGeographicalObject::route('/create'),
            'edit' => Pages\EditGeographicalObject::route('/{record}/edit'),
        ];
    }    
}
