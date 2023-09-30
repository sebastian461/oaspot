<?php

namespace App\Filament\Resources\ParkingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ImageRelationManager extends RelationManager
{
  protected static string $relationship = 'image';

  public function form(Form $form): Form
  {
    return $form
      ->schema([
        FileUpload::make('url')->required()->image(),
      ]);
  }

  public function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('url')
      ->columns([
        Tables\Columns\TextColumn::make('url'),
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
