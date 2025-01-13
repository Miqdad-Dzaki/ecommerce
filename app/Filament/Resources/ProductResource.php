<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\Products;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

use function Laravel\Prompts\select;

class ProductResource extends Resource
{
    protected static ?string $model = Products::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Product Information')->schema([
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
                        ->unique(Products::class, 'slug', ignoreRecord:true)
                        ->maxLength(255),

                        MarkdownEditor::make('description')
                        ->columnSpanFull()
                        ->fileAttachmentsDirectory('product')
                    ])->columns(2),

                    Section::make('Images')->schema([
                        FileUpload::make('image')
                        ->directory('product')
                        ->maxFiles(5)
                        ->reorderable()
                    ])
                ])->columnSpan(2),
                    
                Group::make()->schema([
                    Section::make('Price')->schema([
                        TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('IDR')
                    ]),

                    Section::make('Stock')->schema([
                        TextInput::make('stock')
                        ->required()
                        ->numeric()
                    ]),

                    Section::make('Associations')->schema([
                        Select::make('id_category')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->relationship('categories', 'name'),

                        Select::make('id_brand')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->relationship('brands', 'name'),
                    ])
                    
                ])->columnSpan(1)

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->searchable(),

                TextColumn::make('categories.name')
                ->sortable(),

                TextColumn::make('brands.name')
                ->sortable(),

                TextColumn::make('price')
                ->sortable()
                ->money('IDR'),

                TextColumn::make('stock')
                ->searchable()
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
