<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessStoreRequest;
use App\Models\Process;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProcessController extends Controller
{
    public function index(Request $request): View
    {
        return view('processes.index');
    }

    public function store(ProcessStoreRequest $request): RedirectResponse
    {
        $process = Process::create($request->validated());

        return redirect()->route('processes.index');
    }

    public function show(Request $request, Process $process): View
    {
        return view('processes.show');
    }
}
