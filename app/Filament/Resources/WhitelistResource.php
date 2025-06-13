<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhitelistResource\Pages;
use App\Filament\Resources\WhitelistResource\RelationManagers;
use App\Models\Company;
use App\Models\Whitelist;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WhitelistResource extends Resource
{
    protected static ?string $model = Whitelist::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'Otopark Yönetimi';
    protected static ?string $navigationLabel = 'Beyaz Liste';
    protected static ?string $pluralNavigationLabel = 'Beyaz Liste';
    protected static ?string $modelLabel = 'Beyaz Liste';
    protected static ?string $pluralModelLabel = 'Beyaz Liste';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('plate')->required(),
                Forms\Components\TextInput::make('note')->required(),
                Forms\Components\Select::make('company_id')
                    ->label('Şirket')
                    ->options(Company::pluck('name', 'id'))
                    ->searchable()
                    ->visible(fn () => Filament::auth()->user()->hasRole('super-admin')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Beyaz liste bulunamadı')
            ->emptyStateDescription('Beyaz liste ekleyiniz.')
            ->emptyStateIcon('heroicon-o-check-circle')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('plate')->searchable(),
                Tables\Columns\TextColumn::make('note'),
                Tables\Columns\TextColumn::make('company.name'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhitelists::route('/'),
            'create' => Pages\CreateWhitelist::route('/create'),
            'edit' => Pages\EditWhitelist::route('/{record}/edit'),
        ];
    }
}
