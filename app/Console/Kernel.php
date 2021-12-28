<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

		# Weekly a reminder to users with no post registration data
		#$schedule->call('App\Http\Controllers\PostRegistrationController@reminder')->weekly();
		
		$schedule->call('App\Http\Controllers\ReminderController@postregistration')->weekly();
		$schedule->call('App\Http\Controllers\ReminderController@checkout')->daily();
		$schedule->call('App\Http\Controllers\ReminderController@invoices')->monthly();
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
