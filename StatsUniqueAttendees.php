<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\User;
use App\Models\Attendee;

class StatsUniqueAttendees extends LineChartWidget
{
    protected static ?string $heading = 'Unique Attendees';

    protected function getData(): array
    {
       // show unique attendees
        $data = Trend::query(Attendee::query()->distinct('user_id'))
            ->between(
                start: now()->setDate(2021, 1, 1),
                end: now(),
            )
            ->perMonth()
            ->count();

            return [
                'datasets' => [
                    [
                        'label' => 'Unique Attendees',
                        'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    ],
                ],
                'labels' => $data->map(fn (TrendValue $value) => $value->date),
            ];
    }
}
