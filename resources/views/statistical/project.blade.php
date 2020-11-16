<meta name="frm_search" content="frm_search_project">
<x-app-layout>
    <x-slot name="header">
        <div class="box-header with-border overflow-hidden row">
            <div class="col-6">
                <h3 class="box-title">
                    <span>Time Trackers</span>
                </h3>
            </div>
            <div class="col-12">
            @if ($errors->any())
                <ul class="ul_error">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            </div>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6">
            <div class="">
                {!! Form::open(['method' => 'POST', 'id' => 'frm_search_project', 'class' => 'needs-validation']) !!}
                <input type="hidden" name="action" value="">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="font-semibold col-md-1">Project</label>
                            <div class="col-md-4">
                                <select name="id_project" class="form-control">
                                    <option value=""></option>
                                    @foreach($projects as $item_project)
                                        <option value="{{ $item_project->id }}" {!! (isset($old->id_project) && $item_project->id == $old->id_project) ? 'selected' : '' !!}>{{ $item_project->name_project }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary btn_search">Search</button>
                                <a href="{{ url('pdf_project?all=1') }}" class="btn btn-info">Export All</a>
                                <a href="{{ url('pdf_project') }}" class="btn btn-info">Export Page</a>
                            </div>
                        </div>
                        @if(!empty($project_info))
                        <div>
                            <label class="font-semibold">Begin:</label> {{ $project_info->start_date }} <label class="font-semibold">&nbsp&nbsp&nbsp     End:</label> {{ $project_info->end_date }}
                        </div>
                        @endif
                    </div>

                {!! Form::close() !!}
            </div>

            <table class="table table-bordered table-striped w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Working date</th>
                        <th class="px-4 py-2">Start working date</th>
                        <th class="px-4 py-2">Start working time</th>
                        <th class="px-4 py-2">End working date</th>
                        <th class="px-4 py-2">End working time</th>
                        <th class="px-4 py-2">Rest time</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($lists) && count($lists) > 0)
                        @foreach($lists as $item)
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
                            <td class="border px-4 py-2">
                                {{ $item->start_working_time }}
                                <input type="hidden" name="start_working_time" value="{{ $item->start_working_time }}">
                            </td>
                            <td class="border px-4 py-2">
                                {{ $item->end_working_day }}
                                <input type="hidden" name="end_working_day" value="{{ $item->end_working_day }}">
                            </td>
                            <td class="border px-4 py-2">
                                {{ $item->end_working_time }}
                                <input type="hidden" name="end_working_time" value="{{ $item->end_working_time }}">
                            </td>
                            <td class="border px-4 py-2">
                                {{ $item->rest_time }}
                                <input type="hidden" name="rest_time" value="{{ $item->rest_time }}">
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">No result!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-12">
                    {{ isset($lists) ? $lists->appends(['sortfield'=> Request::get('sortfield'), 'sorttype'=> Request::get('sorttype')])->links() : '' }}
                </div>
            </div>
        </div>
    </div>

    {!! Form::open(['id' => 'frm_reload', 'class' => 'form-horizontal']) !!}
    <input type="hidden" name="id" value="">
    {!! Form::close() !!}
    @section('javascript')
        <script type="text/javascript" src="{{ asset('js/app_times.js?version='.config('setting.version')) }}"></script>
        <script type="text/javascript" src="{{ asset('js/time_trackers.js?version='.config('setting.version')) }}"></script>
    @stop
</x-app-layout>
