<meta name="frm_search" content="frm_search_times">
<x-app-layout>
    <x-slot name="header">
        <div class="box-header with-border overflow-hidden row">
            <div class="col-6">
                <h3 class="box-title">
                    <span>Time Tracker</span>
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
                                    <option value="0"></option>
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
                            <div class="col-md-3">
                                <select name="month" class="form-control div-textfield--160">
                                    <option value="0"></option>
                                    @for($i=1;$i<=12;$i++)
                                        @php($month = date('F', mktime(0, 0, 0, $i, 10)))
                                    <option value="{!! $i !!}" {!! isset($params['month']) && $params['month'] == $i ? 'selected' : '' !!}>{{ $month }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="year" class="form-control div-textfield--160">
                                    <option value="0"></option>
                                    @for($i=date('Y');$i >= date('Y') - 10;$i--)
                                        <option value="{!! $i !!}" {!! isset($params['year']) && $params['year'] == $i ? 'selected' :'' !!}>{{ $i }}</option>
                                    @endfor
                                </select>
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
                <a href="{{ url('time_trackers_pdf') }}" class="btn btn-info" id="btn_export_pdf">Export</a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add_times">
                    <i class="fas fa-plus-square"></i> Add
                </button>
                <button type="button" class="btn btn-primary btn_search">Search</button>
            </div>
            <table class="table table-bordered table-striped w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2" width="25%">{!! sort_title('user_id', __('Project')) !!}</th>
                        <th class="px-4 py-2" width="25%">{!! sort_title('user_id', __('User')) !!}</th>
                        <th class="px-4 py-2">{!! sort_title('working_date', __('Working date')) !!}</th>
                        <th class="px-4 py-2 text-primary">{!!  __('Weekday') !!}</th>
                        <th class="px-4 py-2">{!! sort_title('working_time', __('Working time')) !!}</th>
                        <th class="px-4 py-2" width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($lists) && count($lists) > 0)
                        @foreach($lists as $item)
                        <tr>
                            <td class="border px-4 py-2">
                                {{ $item->name_project }}
                                <input type="hidden" name="id_project" value="{{ $item->id_project }}">
                            </td>
                            <td class="border px-4 py-2">
                                {{ $item->employee_name }}
                                <input type="hidden" name="user_id" value="{{ $item->user_id }}">
                            </td>
                            <td class="border px-4 py-2">
                                {{ format_date($item->working_date) }}
                                <input type="hidden" name="working_date" value="{{ format_date($item->working_date) }}">
                            </td>
                            <td class="border px-4 py-2">
                                {{ format_date($item->working_date,'l') }}
                            </td>
                            <td class="border px-4 py-2" align="right">
                                {{ $item->working_time }}
                                <input type="hidden" name="working_time" value="{{ $item->working_time }}">
                            </td>
                            <td class="border px-4 py-2">
                                <input type="hidden" name="memo" value="{{ $item->memo }}">
                                <button class="btn btn-default btn-sm btn_edit_times" data-id="{{ $item->id }}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-default btn-sm text-danger btn_del_times" data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9" class="text-center">No result!</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-12">
                    {{ isset($lists) ? $lists->appends([
                    'user_id'=> Request::get('user_id'),
                    'month'=> Request::get('month'),
                    'year'=> Request::get('year'),
                    'id_project'=> Request::get('id_project'),
                    'sortfield'=> Request::get('sortfield'),
                    'sorttype'=> Request::get('sorttype')])->links() : ''
                    }}
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

