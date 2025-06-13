<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentHistoryResource\Pages;
use App\Filament\Resources\PaymentHistoryResource\RelationManagers;
use App\Models\Company;
use App\Models\ParkSession;
use App\Models\PaymentHistory;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentHistoryResource extends Resource
{
    protected static ?string $model = PaymentHistory::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Otopark Yönetimi';
    protected static ?string $navigationLabel = 'Ödeme Geçmişi';
    protected static ?string $pluralNavigationLabel = 'Ödeme Geçmişi';
    protected static ?string $modelLabel = 'Ödeme Geçmişi';
    protected static ?string $pluralModelLabel = 'Ödeme Geçmişi';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('amount')->required(),
                Forms\Components\Select::make('method')
                    ->options([
                        'cash' => 'Nakit',
                        'credit_card' => 'Kredi Kartı',
                        'hgs' => 'HGS',
                    ])
                    ->required(),
                Forms\Components\Select::make('company_id')
                    ->label('Şirket')
                    ->options(Company::pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->default(fn () => Filament::auth()->user()->company_id)
                    ->visible(fn () => Filament::auth()->user()->hasRole('super-admin')),
                Forms\Components\Select::make('park_session_id')
                    ->label('Otopark Girişi')
                    ->options(ParkSession::pluck('id', 'id'))
                    ->searchable()
                    ->preload()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('Ödeme geçmişi bulunamadı')
            ->emptyStateDescription('Ödeme geçmişi ekleyiniz.')
            ->emptyStateIcon('heroicon-o-credit-card')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Ödeme Geçmişi Ekle')
                    ->icon('heroicon-o-credit-card'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('method'),
                Tables\Columns\TextColumn::make('company.name'),
                Tables\Columns\TextColumn::make('parkSession.id'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Düzenle')
                    ->icon('heroicon-o-pencil'),
                Tables\Actions\DeleteAction::make()
                    ->label('Sil')
                    ->icon('heroicon-o-trash'),
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
            'index' => Pages\ListPaymentHistories::route('/'),
            'create' => Pages\CreatePaymentHistory::route('/create'),
            'edit' => Pages\EditPaymentHistory::route('/{record}/edit'),
        ];
    }
}
