<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParkSessionResource\Pages;
use App\Filament\Resources\ParkSessionResource\RelationManagers;
use App\Models\ParkSession;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;
use App\Models\Company;

class ParkSessionResource extends Resource
{
    protected static ?string $model = ParkSession::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';
    protected static ?string $navigationGroup = 'Otopark Yönetimi';
    protected static ?string $navigationLabel = 'Otopark Girişleri';
    protected static ?string $pluralNavigationLabel = 'Otopark Girişleri';
    protected static ?string $modelLabel = 'Otopark Girişi';
    protected static ?string $pluralModelLabel = 'Otopark Girişleri';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('plate')->required(),
            Forms\Components\DateTimePicker::make('entry_time')->required(),
            Forms\Components\DateTimePicker::make('exit_time'),
            Forms\Components\TextInput::make('fee')->numeric(),
            Forms\Components\Select::make('status')
                ->options([
                    'active' => 'Aktif',
                    'completed' => 'Tamamlandı',
                ])
                ->default('active'),
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
            ->emptyStateHeading('Otopark girişi bulunamadı')
            ->emptyStateDescription('Otopark girişi ekleyiniz.')
            ->emptyStateIcon('heroicon-o-truck')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])

            ->columns([
                Tables\Columns\TextColumn::make('plate')->searchable(),
                Tables\Columns\TextColumn::make('entry_time')->dateTime(),
                Tables\Columns\TextColumn::make('exit_time')->dateTime(),
                Tables\Columns\TextColumn::make('fee')->money('TRY'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Aktif',
                        'completed' => 'Tamamlandı',
                        default => $state,
                    })
                    ->colors([
                        'warning' => 'active',
                        'success' => 'completed',
                    ]),
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
            'index' => Pages\ListParkSessions::route('/'),
            'create' => Pages\CreateParkSession::route('/create'),
            'edit' => Pages\EditParkSession::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('company_id', Filament::auth()->user()->company_id);
    }
}
