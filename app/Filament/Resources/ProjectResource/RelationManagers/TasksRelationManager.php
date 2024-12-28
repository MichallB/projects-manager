<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Enums\TaskStatus;
use DateTimeImmutable;
use DateTimeInterface;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = "tasks";

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make("name")->required(),
                Forms\Components\TextInput::make("description")->required(),
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
                Forms\Components\ToggleButtons::make("status")
                    ->inline()
                    ->required()
                    ->options(TaskStatus::class),
                Forms\Components\Select::make("user_id")
                    ->relationship(name: "user", titleAttribute: "name"),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute("description")
            ->columns([
                Tables\Columns\TextColumn::make("name")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("description")->searchable(),
                Tables\Columns\TextColumn::make("start_date")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("end_date")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("status")->searchable()->sortable(),
                Tables\Columns\TextColumn::make("user.name")->searchable()->sortable(),

            ])
            ->filters([
                Tables\Filters\QueryBuilder::make()
                    ->constraints([
                        Tables\Filters\QueryBuilder\Constraints\TextConstraint::make("name"),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make("start_date"),
                        Tables\Filters\QueryBuilder\Constraints\DateConstraint::make("end_date"),
                        Tables\Filters\QueryBuilder\Constraints\SelectConstraint::make("status")
                            ->multiple()
                            ->options(TaskStatus::class),
                    ]),
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
