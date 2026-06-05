<?php

namespace App\Jobs;

use App\Services\OverdueTaskService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessOverdueTasks implements ShouldQueue
{
    use Queueable;

    public function handle(OverdueTaskService $service): void
    {
        $service->process();
    }
}
