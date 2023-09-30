<?php

namespace App\Filament\Resources\ParkingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DocumentsRelationManager extends RelationManager
{
  protected static string $relationship = 'documents';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        TextInput::make('name')->required(),
        FileUpload::make('attachment')->required()->acceptedFileTypes(['application/pdf']),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('attachment')
      ->columns([
        TextColumn::make('name'),
        Tables\Columns\TextColumn::make('attachment'),
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
