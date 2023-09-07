<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Role;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(),
                Forms\Components\TextInput::make('password')
                    ->required()
                    ->password()
                    ->maxLength(255)
                    ->rule(Password::default())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name') 
                    ->searchable(),
                Tables\Columns\TextColumn::make('role.name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),                 
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('role') 
                    ->options([
                        Role::ROLE_USER => 'User',
                        Role::ROLE_OWNER => 'Owner',
                        Role::ROLE_ADMINISTRATOR => 'Administrator',
                    ])
                    ->attribute('role_id'), 
            ])
            ->actions([
                 Tables\Actions\EditAction::make(),
                // Action::make('changePassword') 
                //     ->action(function (User $record, array $data): void {
                //         $record->update([
                //             'password' => Hash::make($data['new_password']),
                //         ]);
 
                //         Filament::notify('success', 'Password changed successfully.');
                //     })
                //     ->form([
                //         Forms\Components\TextInput::make('new_password')
                //             ->password()
                //             ->label('New Password')
                //             ->required()
                //             ->rule(Password::default()),
                //         Forms\Components\TextInput::make('new_password_confirmation')
                //             ->password()
                //             ->label('Confirm New Password')
                //             ->rule('required', fn($get) => ! ! $get('new_password'))
                //             ->same('new_password'),
                //     ])
                //     ->icon('heroicon-o-key')
                //     ->visible(fn (User $record): bool => $record->role_id === Role::ROLE_ADMINISTRATOR),
                // Action::make('deactivate')
                //     ->color('danger')
                //     ->icon('heroicon-o-trash')
                //     ->action(fn (User $record) => $record->delete())
                //     ->visible(fn (User $record): bool => $record->role_id === Role::ROLE_ADMINISTRATOR),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
