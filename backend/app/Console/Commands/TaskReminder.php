<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TaskReminder extends Command
{
    protected $signature = 'task:reminder';

    protected $description = 'Send task reminders to users';

    public function handle()
    {
        Log::info('Task reminder cron job ran at ' . now());

        $this->info('Task reminder executed successfully!');
    }
}
