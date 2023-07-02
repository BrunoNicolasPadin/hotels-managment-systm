<?php

namespace App\Http\Controllers;

use App\Models\Process;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\ProcessStoreRequest;
use App\Jobs\CreateProcessJob;
use App\Jobs\CreateRunProcessJob;
use App\Models\Lov;
use Illuminate\Support\Facades\Auth;

class ProcessController extends Controller
{
    public function index(Request $request): View
    {
        $params = $request->except('_token');
        $processes = null;
        $pages = 10;

        if (empty($params) || (! isset($params['searchData']) && isset($params['filter']))) {
            $processes = Process::with(['type', 'status', 'user', 'model'])
                ->orderBy('id', 'DESC')
                ->paginate($pages);
        } else {
            $processes = Process::with(['type', 'status', 'user', 'model'])
                ->filter($params)
                ->orderBy('id', 'DESC')
                ->paginate($pages);
        }

        return view('processes.index', [
            'processes' => $processes,
            'params' => $params,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        //Get model using route name
        $previousUrl = URL::previous();
        $query = null;
        $parsedUrl = parse_url($previousUrl);
        isset($parsedUrl['query']) ? parse_str($parsedUrl['query'], $query) : null;

        $newProcess = new Process();
        $newProcess->type_id = Lov::where('code', $request->type)->first()->id;
        $newProcess->status_id = Lov::where('code', $request->status)->first()->id;
        $newProcess->user_id = Auth::id();
        $newProcess->model_id = Lov::where('code', $request->model)->first()->id;
        $newProcess->save();

        $process = Process::with('model')->findOrFail($newProcess->id);
        CreateProcessJob::dispatch($query, $process);

        return redirect()->route('processes.index');
    }

    public function show(Request $request, Process $process): View
    {
        return view('processes.show');
    }

    public function destroy(Process $process) : RedirectResponse 
    {
        //
    }
}
