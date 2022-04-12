<?php

namespace App\Console;

use App\Models\Monster;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Reduce Monsters' energy every 2 minutes
        $schedule->call(function ()
        {
            Monster::where('sleeping', '=', 0)->decrement('energy', 1);
        })->everyTwoMinutes();

        $schedule->call(function ()
        {
            // Increase sleeping Monsters' energy every minute.
            Monster::where('sleeping', '=', 1)->where('dead', '=', 0)->increment('energy', 1);

            // Put to sleep tired monsters
            Monster::where('energy', '=', 0)->update([
                'sleeping' => 1
            ]);

            // Awaken sleeping monsters
            Monster::where('energy', '=', 100)->update([
                'sleeping' => 0
            ]);

            // Increase Monsters' hunger every minute
            Monster::where('hunger', '<', 100)->increment('hunger', 1);

            // Decrease Monsters' life if hunger is at 100
            Monster::where('hunger', '=', 100)->where('life', '>', 0)->decrement('life', 1);

            // Kill starving monsters
            Monster::where('life', '=', 0)->update([
                'dead' => 1,
                'sleeping' => 1,
                'energy' => 0,
            ]);
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
