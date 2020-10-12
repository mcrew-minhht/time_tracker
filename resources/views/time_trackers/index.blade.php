<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Time Trackers
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <div class="text-right m-5">
            <button class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full">
                Add Project
            </button>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6">
            <table class="table-fixed w-full">
                <thead>
                    <tr>
                        <th class="border">Project</th>
                        <th class="border">User</th>
                        <th class="border">Time</th>
                        <th class="border"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($list))
                        @foreach($list as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->employee_name }}</td>
                            <td class="border px-4 py-2">{{ $item->name_project }}</td>
                            <td class="border px-4 py-2">
                                {{ $item->working_day }}
                            </td>
                            <td class="border px-4 py-2">
                                <a href="{{ url('/time_trackers/'.$item->working_day.'/'.$item->id_project.'/'.$item->employee_code) }}" class="text-blue-500 hover:text-blue-800 focus:outline-none">
                                    Update |
                                </a>
                                <a class="text-blue-500 hover:text-blue-800 focus:outline-none">
                                    Del
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2">No result!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    @include('time_trackers.partials.add_project_modal')
    @section('javascript')
        <script type="text/javascript" src="{{ asset('js/app_times.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/time_trackers.js') }}"></script>
    @stop
</x-app-layout>

