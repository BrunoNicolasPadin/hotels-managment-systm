<?php

namespace App\Jobs;

use App\Models\Process;
use App\Services\ExportServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array|null $query;

    public Process $process;

    /**
     * Create a new job instance.
     */
    public function __construct(array|null $query, Process $process)
    {
        $this->query = $query;
        $this->process = $process;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $exportProcess = new ExportServices;
        $exportProcess->handle($this->query, $this->process);
    }
}
