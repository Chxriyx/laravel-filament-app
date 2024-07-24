<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->rules('required|string|max:255'),
                Forms\Components\TextInput::make('company_name')->rules('nullable|string|max:255'),
                Forms\Components\TextInput::make('email')->required()->unique(ignoreRecord: true)->rules('email'),
                Forms\Components\TextInput::make('phone')->rules('nullable|string|max:15|regex:/^[0-9+\-() ]*$/'),
                Forms\Components\Textarea::make('address')->rules('nullable|string'),
                Forms\Components\TextInput::make('website')->rules('nullable|url|max:255'),
                Forms\Components\TextInput::make('industry')->rules('nullable|string|max:255'),
                Forms\Components\Textarea::make('notes')->rules('nullable|string'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('company_name')->sortable()->searchable()->limit(20),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('address')->limit(20),
                Tables\Columns\TextColumn::make('website')->limit(20),
                Tables\Columns\TextColumn::make('industry'),
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
