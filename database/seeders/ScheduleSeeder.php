<?php
namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseSchedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::where('is_published', true)->take(6)->get();
        $modes = ['virtual', 'in_person', 'hybrid'];
        $venues = [
            'IFS Training Centre, Victoria Island, Lagos',
            'Eko Hotels & Suites, Lagos',
            'Transcorp Hilton, Abuja',
        ];

        foreach ($courses as $index => $course) {
            for ($i = 1; $i <= 3; $i++) {
                $startDate = Carbon::now()->addMonths($i)->startOfMonth()->next(Carbon::MONDAY);
                $endDate   = $startDate->copy()->addDays($course->duration_days - 1);
                $mode      = $modes[$i - 1];

                CourseSchedule::firstOrCreate(
                    [
                        'course_id'  => $course->id,
                        'start_date' => $startDate->format('Y-m-d'),
                    ],
                    [
                        'end_date'      => $endDate->format('Y-m-d'),
                        'venue'         => $mode !== 'virtual' ? $venues[$i - 1] : null,
                        'mode'          => $mode,
                        'max_delegates' => $course->max_delegates ?? 25,
                        'status'        => 'open',
                    ]
                );
            }
        }
    }
}
