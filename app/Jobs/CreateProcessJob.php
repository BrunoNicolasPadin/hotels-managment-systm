<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Lov;
use App\Models\Hotel;
use App\Models\Process;
use App\Exports\HotelsExport;
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
        try {
            $path = null;
            $name = null;
            $params = $this->query;
            $model = $this->process->model->label;

            $today = Carbon::now('America/Argentina/Buenos_Aires')->format('d_m_Y_H_i_s');
            $name = $this->process->id.'_'.$model.'_'.$today;
            $path = 'processes/exports/files/'.$name.'.xlsx';

            if ($model === 'Hotel') {
                if (empty($params) || (! isset($params['searchData']) && isset($params['filter']))) {
                    $hotels = Hotel::withTrashed()->with('type')->get();
                } else {
                    $hotels = Hotel::withTrashed()->with('type')->filter($params)->get();
                }
    
                Excel::store(new HotelsExport($hotels->toArray()), $path, 'public');

                $total = $hotels->count();
            }

            $this->process->status_id = Lov::where('code', 'STATUS_PROCESS_COMPLETED')->first()->id;
            $this->process->file = 'public/'.$path;
            $this->process->total = $total;
            $this->process->save();
        } catch (\Throwable $th) {
            $this->process->status_id = Lov::where('code', 'STATUS_PROCESS_FAILED')->first()->id;
            $this->process->save();

            Log::error($th->getMessage());

            $file = 'Row,Attribute,Errors,'.PHP_EOL;
            $file .= $th->getMessage();
            $path = 'processes/exports/logs'.$name.'_Log.csv';

            //guardo el log en el storage local
            Storage::putFileAs(
                'public/processes/exports/logs', $file, $name.'_Log.csv'
            );

            $this->process->log = $path;
            $this->process->save();
        }
    }
}
