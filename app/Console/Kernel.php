<?php

namespace App\Console;

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
        // $schedule->command('inspire')->hourly();
        //setting the command to run at this time 
        //$filePath = '/var/log/job1.log';
        $schedule->command('auto:SendEmailsDaily')->dailyAt('03:00')->onOneServer()->runInBackground();
        $schedule->command('auto:SendEmailsHourly')->everyTenMinutes()->unlessBetween('2:30','3:30')->onOneServer()->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
