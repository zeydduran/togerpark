<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HgsResource\Pages;
use App\Filament\Resources\HgsResource\RelationManagers;
use App\Models\Company;
use App\Models\Hgs;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HgsResource extends Resource
{
    protected static ?string $model = Hgs::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Otopark Yönetimi';
    protected static ?string $navigationLabel = 'HGS';
    protected static ?string $pluralNavigationLabel = 'HGS';
    protected static ?string $modelLabel = 'HGS';
    protected static ?string $pluralModelLabel = 'HGS';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('plate')->required(),
                Forms\Components\TextInput::make('tag_number')->required(),
                Forms\Components\Select::make('company_id')
                    ->label('Şirket')
                    ->options(Company::pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->default(fn () => Filament::auth()->user()->company_id)
                    ->visible(fn () => Filament::auth()->user()->hasRole('super-admin')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('HGS bulunamadı')
            ->emptyStateDescription('HGS ekleyiniz.')
            ->emptyStateIcon('heroicon-o-tag')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('plate')->searchable(),
                Tables\Columns\TextColumn::make('tag_number')->searchable(),
                Tables\Columns\TextColumn::make('company.name'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHgs::route('/'),
            'create' => Pages\CreateHgs::route('/create'),
            'edit' => Pages\EditHgs::route('/{record}/edit'),
        ];
    }
}
