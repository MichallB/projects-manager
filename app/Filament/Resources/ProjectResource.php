<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use DateTimeImmutable;
use DateTimeInterface;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make("name")->required(),
                Forms\Components\Textarea::make("description")->required(),
                Forms\Components\DatePicker::make("start_date")
                    ->required()
                    ->reactive()
                    ->maxDate(function (Get $get) {
                        return $get("end_date");
                    })
                    ->default((new DateTimeImmutable())->format(DateTimeInterface::ATOM)),
                Forms\Components\DatePicker::make("end_date")
                    ->reactive()
                    ->minDate(function (Get $get) {
                        return $get("start_date");
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("name")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("description")->searchable()->words(10),
                Tables\Columns\TextColumn::make("start_date")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("end_date")->searchable()->sortable(),
            ])
            ->filters([
                Tables\Filters\QueryBuilder::make()
                    ->constraints([
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make("name"),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make("start_date"),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make("end_date"),
                    ]),
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
            RelationManagers\TasksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListProjects::route("/"),
            "create" => Pages\CreateProject::route("/create"),
            "edit" => Pages\EditProject::route("/{record}/edit"),
        ];
    }
}
