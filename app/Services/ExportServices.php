<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Lov;
use App\Models\Hotel;
use App\Models\Process;
use App\Exports\HotelsExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ExportServices 
{
    public function handle(array|null $query, Process $process) : void
    {
        try {
            $path = null;
            $name = null;
            $params = $query;
            $model = $process->model->label;

            $today = Carbon::now('America/Argentina/Buenos_Aires')->format('d_m_Y_H_i_s');
            $name = $process->id.'_'.$model.'_'.$today;
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

            $process->status_id = Lov::where('code', 'STATUS_PROCESS_COMPLETED')->first()->id;
            $process->file = 'public/'.$path;
            $process->total = $total;
            $process->save();
        } catch (\Throwable $th) {
            $process->status_id = Lov::where('code', 'STATUS_PROCESS_FAILED')->first()->id;
            $process->save();

            Log::error($th->getMessage());

            $file = 'Row,Attribute,Errors,'.PHP_EOL;
            $file .= $th->getMessage();
            $path = 'processes/exports/logs'.$name.'_Log.csv';

            //guardo el log en el storage local
            Storage::putFileAs(
                'public/processes/exports/logs', $file, $name.'_Log.csv'
            );

            $process->log = $path;
            $process->save();
        }
    }
}