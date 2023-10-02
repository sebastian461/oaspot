<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Filament\Resources\DocumentResource\RelationManagers;
use App\Models\Document;
use App\Models\Parking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;

class DocumentResource extends Resource
{
  protected static ?string $model = Document::class;

  protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

  protected static ?string $navigationLabel = 'Documentos';

  protected static ?string $modelLabel = 'Documentos';

  protected static ?string $navigationGroup = 'Gestión de parqueaderos';

  protected static ?int $navigationSort = 3;

  public static function form(Form $form): Form
  {
    return $form
      ->schema([
        Forms\Components\Select::make('parking_id')
          ->options(Parking::where('user_id', auth()->id())->pluck('name', 'id'))
          ->required()
          ->label('Parqueadero'),
        Forms\Components\TextInput::make('name')
          ->required()
          ->maxLength(255)
          ->label('Nombre'),
        FileUpload::make('attachment')
          ->downloadable()
          ->acceptedFileTypes(['application/pdf'])
          ->required()
          ->label('URL'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        Tables\Columns\TextColumn::make('parking.name')
          ->numeric()
          ->sortable()
          ->label('Parqueadero'),
        Tables\Columns\TextColumn::make('name')
          ->searchable()
          ->label('Nombre'),
        Tables\Columns\TextColumn::make('created_at')
          ->dateTime()
          ->sortable(),
        Tables\Columns\TextColumn::make('updated_at')
          ->dateTime()
          ->sortable()
          ->toggleable(isToggledHiddenByDefault: true),
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
      ->modifyQueryUsing(function (Builder $query) {
        if (auth()->user()->hasRole(['User'])) {
          $query->whereHas('parking', function ($query) {
            $query->where('user_id', auth()->id());
          });
        }
      });
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
      'index' => Pages\ListDocuments::route('/'),
      'create' => Pages\CreateDocument::route('/create'),
      'edit' => Pages\EditDocument::route('/{record}/edit'),
    ];
  }
}
