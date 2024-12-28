<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TaskStatus: string implements HasColor, HasIcon, HasLabel {
    case ToDo = "todo";
    case Ongoing = "ongoing";
    case Completed = "completed";

    public function getLabel(): string
    {
        return match ($this) {
            self::ToDo => "ToDo",
            self::Ongoing => "Ongoing",
            self::Completed => "Completed",
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::ToDo => "info",
            self::Ongoing => "warning",
            self::Completed => "success",
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::ToDo => "heroicon-m-sparkles",
            self::Ongoing => "heroicon-m-arrow-path",
            self::Completed => "heroicon-m-check-badge",
        };
    }
}
