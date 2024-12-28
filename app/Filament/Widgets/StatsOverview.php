<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("Total projects", Project::count()),
            Stat::make("Total tasks", Task::count()),
            Stat::make("User tasks", Task::where("user_id", Filament::auth()->user()->getAuthIdentifier())->count()),
        ];
    }
}
