<?php

namespace App\Console;

use App\Console\Commands\NotifyRepay;
use App\Console\Commands\RemoveImg;
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
        RemoveImg::class,
        NotifyRepay::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //每周删本地图片文件
        $schedule->command('z:remove')->weekly();
        //每月提醒账单
//        $schedule->command('z:Notify-user')->monthlyOn(13,'9:00');
        $schedule->command('z:Notify-user')->dailyAt('8:00');
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
