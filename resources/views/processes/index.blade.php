<x-app-layout>
    <x-slot name="header">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="#" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                        Processes
                    </a>
                </li>
            </ol>
        </nav>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session()->has('successMessage'))
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-300 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <span class="font-medium">{{ session()->get('successMessage') }}</span>
                </div>
            @endif

            <form class="my-6" action="{{ route('processes.index') }}">
                <div class="flex">
                    <select name="filter" class="text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100">
                        <option value="" @if (isset($params['filter']) && $params['filter'] === '') selected @endif>Todos</option>
                        <option value="id" @if (isset($params['filter']) && $params['filter'] === 'id') selected @endif>ID</option>
                        <option value="file" @if (isset($params['filter']) && $params['filter'] === 'file') selected @endif>File</option>
                        <option value="log" @if (isset($params['filter']) && $params['filter'] === 'log') selected @endif>Log</option>
                        <option value="type" @if (isset($params['filter']) && $params['filter'] === 'type') selected @endif>Type</option>
                        <option value="status" @if (isset($params['filter']) && $params['filter'] === 'status') selected @endif>Status</option>
                        <option value="user" @if (isset($params['filter']) && $params['filter'] === 'user') selected @endif>User</option>
                        <option value="model" @if (isset($params['filter']) && $params['filter'] === 'model') selected @endif>Model</option>
                    </select>
                    <div class="relative w-full">
                        <input type="search" name="searchData" id="search-dropdown" @if (isset($params['searchData']) && ($params['searchData'] !== null || $params['searchData'] !== '')) value="{{ $params['searchData'] }}" @endif class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-r-lg border-l-gray-50 border-l-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Search...">
                        <button type="submit" class="absolute top-0 right-0 p-2.5 text-sm font-medium text-white bg-blue-700 rounded-r-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            <svg aria-hidden="true" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
            </form>

            @if ($processes->count() > 0)
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Model
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    User
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    File
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Log
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($processes as $process)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $process->id }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $process->type->label }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $process->model->label }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $process->status->label }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $process->total }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $process->user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($process->file !== null)
                                            <a href="{{ Storage::url($process->file) }}">{{ $process->file }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($process->log !== null)
                                            <a href="{{ Storage::url($process->log) }}">{{ $process->log }}</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="grid grid-cols-3 px-6 py-4 space-x-3">
                                        <form method="POST" action="{{ route('processes.destroy', $process->id) }}">
                                            @method('delete')
                                            @csrf
                                            <button type="submit"
                                                onclick="return confirm('¿Are you sure do you want to remove process with ID: {{ $process->id }}?')"
                                                class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="my-4">
                    {{ $processes->appends($params)->links() }}
                </div>
            @else
                <div class="text-center mt-3">
                    <h1 class="text-3xl">Processes not found</h1>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>