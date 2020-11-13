<meta name="frm_search" content="frm_search_times">
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
                {!! Form::open(['method' => 'POST', 'id' => 'frm_search_times', 'class' => 'needs-validation']) !!}
                <input type="hidden" name="action" value="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-4">Employee</label>
                            <div class="col-md-6">
                                <select name="user_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($employees as $item_user)
                                        <option value="{{ $item_user->id }}" {!! (isset($params['user_id']) && $item_user->id == $params['user_id']) ? 'selected' : '' !!}>{{ $item_user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-4">Project</label>
                            <div class="col-md-6">
                                <select name="id_project" class="form-control">
                                    <option value=""></option>
                                    @foreach($projects as $item_project)
                                        <option value="{{ $item_project->id }}" {!! (isset($params['id_project']) && $item_project->id == $params['id_project']) ? 'selected' : '' !!}>{{ $item_project->name_project }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-4">Working Date</label>
                            <div class="col-md-6">
                                <input name="working_date" class="form-control datepicker" value="{!! isset($params['working_date']) ? $params['working_date'] : '' !!}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-4">Start Working Day</label>
                            <div class="col-md-3">
                                <input name="start_working_day" class="form-control div-textfield--160 datepicker" value="{!! isset($params['start_working_day']) ? $params['start_working_day'] : '' !!}">
                            </div>
                            <div class="col-md-3">
                                <input name="end_working_day" class="form-control div-textfield--160 datepicker" value="{!! isset($params['end_working_day']) ? $params['end_working_day'] : '' !!}">
                            </div>
                            @if($errors->has('end_working_day'))
                                <div class="text text-danger text-sm px-3">{{ $errors->first('end_working_day')}}</div>
                            @endif
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="text-right my-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add_times">
                    <i class="fas fa-plus-square"></i> Add
                </button>
                <button type="button" class="btn btn-primary btn_search">Search</button>
            </div>
            <table class="table table-bordered table-striped w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">{!! sort_title('user_id', __('User')) !!}</th>
                        <th class="px-4 py-2">{!! sort_title('working_date', __('Working date')) !!}</th>
                        <th class="px-4 py-2">{!! sort_title('start_working_day', __('Start working date')) !!}</th>
                        <th class="px-4 py-2">{!! sort_title('start_working_time', __('Start working time')) !!}</th>
                        <th class="px-4 py-2">{!! sort_title('end_working_day', __('End working date')) !!}</th>
                        <th class="px-4 py-2">{!! sort_title('start_working_time', __('End working time')) !!}</th>
                        <th class="px-4 py-2">{!! sort_title('rest_time', __('Rest time')) !!}</th>
                        <th class="px-4 py-2"></th>
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
                            <td class="border px-4 py-2">
                                <button class="btn btn-default btn-sm btn_edit_times" data-id="{{ $item->id }}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-default btn-sm text-danger btn_del_times" data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">No result!</td>
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
    @include('time_trackers.partials.add_project_modal')
    {!! Form::open(['id' => 'frm_reload', 'class' => 'form-horizontal']) !!}
    <input type="hidden" name="id" value="">
    {!! Form::close() !!}
    @section('javascript')
        <script type="text/javascript" src="{{ asset('js/app_times.js?version='.config('setting.version')) }}"></script>
        <script type="text/javascript" src="{{ asset('js/time_trackers.js?version='.config('setting.version')) }}"></script>
    @stop
</x-app-layout>

