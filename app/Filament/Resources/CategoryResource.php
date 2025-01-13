<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Models\Categories;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use PhpParser\Node\Expr\Cast\String_;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Categories::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make([
                Grid::make()
                ->schema([
                    TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live()
                    ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation
                    === 'create' ?  $set('slug', Str::slug($state)) : null),

                    TextInput::make('slug')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->unique(Categories::class, 'slug', ignoreRecord:true)
                    ->maxLength(255),

                ]),

                Toggle::make('is_activ')
                ->required()
                ->default(true)
            ])
         ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                ->searchable(),

                Tables\Columns\IconColumn::make('is_activ')
                ->boolean(),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
