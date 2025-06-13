<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Kullanıcı Yönetimi';
    protected static ?string $navigationLabel = 'Kullanıcılar';
    protected static ?string $pluralNavigationLabel = 'Kullanıcılar';
    protected static ?string $modelLabel = 'Kullanıcı';
    protected static ?string $pluralModelLabel = 'Kullanıcılar';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Adı')->placeholder('Adınızı giriniz')->required(),
            Forms\Components\TextInput::make('email')->label('E-Posta')->email()->placeholder('E-Posta adresinizi giriniz')->required(),
            Forms\Components\Select::make('company_id')
                ->label('Şirket')
                ->helperText('Kullanıcının ait olduğu şirketi seçiniz.')
                ->placeholder('Şirket seçiniz')
                ->relationship('company', 'name')
                ->preload()
                ->searchable(),
            Forms\Components\Select::make('roles')
                ->label('Rol')
                ->helperText('Birden fazla rol seçebilirsiniz.')
                ->placeholder('Rol seçiniz')
                ->multiple()
                ->relationship('roles', 'name')
                ->preload()
                ->searchable()
                ->required(),
            Forms\Components\TextInput::make('password')
                ->password()
                ->required(fn($livewire) => $livewire instanceof CreateUser)
                ->dehydrated(fn($state) => filled($state))
                ->dehydrateStateUsing(fn($state) => Hash::make($state)),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('company.name'),
                Tables\Columns\TextColumn::make('roles.name'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('company_id')
                    ->label('Şirket')
                    ->relationship('company', 'name')
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('roles')
                    ->label('Rol')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            ->where('company_id', auth()->user()->company_id);
    }
}
