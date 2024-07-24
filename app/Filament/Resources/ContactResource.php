<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required(),
                Forms\Components\TextInput::make('first_name')->required()->rules('required|string|max:255'),
                Forms\Components\TextInput::make('last_name')->required()->rules('required|string|max:255'),
                Forms\Components\TextInput::make('email')->required()->unique(ignoreRecord: true)->rules('email'),
                Forms\Components\TextInput::make('phone')->rules('nullable|string|max:15|regex:/^[0-9+\-() ]*$/'),
                Forms\Components\TextInput::make('position')->rules('nullable|string|max:255'),
                Forms\Components\TextInput::make('department')->rules('nullable|string|max:255'),
                Forms\Components\TextInput::make('linkedin')->rules('nullable|url|max:255'),
                Forms\Components\Textarea::make('notes')->rules('nullable|string|max:1000'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('first_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('last_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('position'),
                Tables\Columns\TextColumn::make('department'),
                Tables\Columns\TextColumn::make('linkedin')->limit(20),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
