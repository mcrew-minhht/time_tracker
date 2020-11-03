<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Time Trackers
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <div class="text-right m-5">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add_times">
                Add Project
            </button>
        </div>
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6">
            <table class="table-fixed w-full">
                <thead>
                    <tr>
                        <th class="border">User</th>
                        <th class="border">Working date</th>
                        <th class="border">Start working date</th>
                        <th class="border">Start working time</th>
                        <th class="border">End working date</th>
                        <th class="border">End working time</th>
                        <th class="border">Rest time</th>
                        <th class="border"></th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($list))
                        @foreach($list as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->employee_name }}</td>
                            <td class="border px-4 py-2">
                                {{ $item->working_date }}
                                <input type="hidden" name="working_date" value="{{ $item->working_date }}">
                            </td>
                            <td class="border px-4 py-2">
                                {{ $item->start_working_day }}
                                <input type="hidden" name="start_working_day" value="{{ $item->start_working_day }}">
                            </td>
                            <td class="border px-4 py-2">{{ $item->start_working_time }}</td>
                            <td class="border px-4 py-2">
                                {{ $item->end_working_day }}
                                <input type="hidden" name="end_working_day" value="{{ $item->end_working_day }}">
                            </td>
                            <td class="border px-4 py-2">
                                {{ $item->end_working_time }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ $item->rest_time }}
                                <input type="hidden" name="rest_time" value="{{ $item->rest_time }}">
                            </td>
                            <td class="border px-4 py-2">
{{--                                <a href="{{ url('/time_trackers/'.$item->working_day.'/'.$item->id_project.'/'.$item->employee_code) }}" class="text-blue-500 hover:text-blue-800 focus:outline-none">--}}
{{--                                    Detail |--}}
{{--                                </a>--}}

                                <button class="btn btn-default btn-sm btn_edit_times" data-id="{{ $item->id }}">Edit</button>
                                <button class="btn btn-default btn-sm" data-id="{{ $item->id }}">Del</button>
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
    {!! Form::open(['id' => 'frm_reload', 'class' => 'form-horizontal']) !!}
    <input type="hidden" name="id" value="">
    {!! Form::close() !!}
    @section('javascript')
        <script type="text/javascript" src="{{ asset('js/app_times.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/time_trackers.js') }}"></script>
    @stop
</x-app-layout>

