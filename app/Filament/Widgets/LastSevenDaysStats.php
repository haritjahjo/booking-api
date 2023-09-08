<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Property;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LastSevenDaysStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Last 7 days new properties', Property::where('created_at', '>', now()->subDays(7)->endOfDay())->count()),
            Stat::make('Last 7 days new users', User::where('created_at', '>', now()->subDays(7)->endOfDay())->count())
        ];
    }
}
