<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Lov;
use App\Models\Hotel;
use App\Models\Process;
use App\Exports\HotelsExport;
use App\Services\ExportServices;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

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
