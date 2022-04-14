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
        $schedule->call(function () // This happens every 10 minutes, because of limitations of Heroku
        {
            // Reduce Monsters' energy
            Monster::where('sleeping', '=', 0)->decrement('energy', 5);

            // Increase sleeping Monsters' energy
            Monster::where('sleeping', '=', 1)->where('dead', '=', 0)->increment('energy', 10);

            // Put to sleep tired monsters
            Monster::where('energy', '=', 0)->update([
                'sleeping' => 1
            ]);

            // Awaken sleeping monsters
            Monster::where('energy', '>=', 100)->update([
                'sleeping' => 0,
                'energy' => 100,
            ]);

            // Increase Monsters' hunger
            Monster::where('hunger', '<', 100)->increment('hunger', 1);

            // Decrease Monsters' life if hunger is at 100
            Monster::where('hunger', '=', 100)->where('life', '>', 0)->decrement('life', 10);

            // Kill starving monsters
            Monster::where('life', '<=', 0)->update([
                'dead' => 1,
                'sleeping' => 1,
                'energy' => 0,
            ]);
        });
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
