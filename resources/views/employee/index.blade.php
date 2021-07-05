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
    <div class="container-fluid mx-auto">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6">
            <div class="">
                {!! Form::open(['route' => 'employee', 'method' => 'GET', 'id' => 'frm_search', 'class' => 'needs-validation']) !!}
                <input type="hidden" name="action" value="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-1">Year</label>
                            <div class="col-md-3">
                                <select name="year" class="form-control div-textfield--160">
                                    <option value="0"></option>
                                    @for($i=date('Y');$i >= date('Y') - 10;$i--)
                                        <option value="{!! $i !!}" {!! isset($params['year']) && $params['year'] == $i ? 'selected' :'' !!}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <label class="col-form-label col-md-2">Month</label>
                            <div class="col-md-3">
                                <select name="month" class="form-control div-textfield--160">
                                    <option value="0"></option>
                                    @for($i=1;$i<=12;$i++)
                                        @php($month = date('F', mktime(0, 0, 0, $i, 10)))
                                        <option value="{!! $i !!}" {!! isset($params['month']) && $params['month'] == $i ? 'selected' : '' !!}>{{ $month }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right my-3">
                    <button type="submit" class="btn btn-primary btn_search">Search</button>
                </div>
                {!! Form::close() !!}
            </div>

            <table class="table table-bordered table-striped w-full">
                <thead>
                <tr>
                    <th class="px-4 py-2" width="15%">{!! sort_title('user_id', __('Project')) !!}</th>
                    <th class="px-4 py-2" width="25%">{!! sort_title('user_id', __('User')) !!}</th>
                    <th class="px-4 py-2" width="10%"></th>
                </tr>
                </thead>
                <tbody>
                @if(isset($lists) && count($lists) > 0)
                    @foreach($lists as $item)
                        <tr>
                            <td class="border px-4 py-2">
                                {{ $item->name_project }}
                            </td>
                            <td class="border px-4 py-2">
                                {{ $item->employee_name }}
                            </td>
                            <td class="border px-4 py-2">
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center">No result!</td>
                    </tr>
                @endif
                </tbody>
            </table>
            <div class="row">
{{--                <div class="col-sm-12">--}}
{{--                    {{ isset($lists) ? $lists->appends([--}}
{{--                    'user_id'=> Request::get('user_id'),--}}
{{--                    'month'=> Request::get('month'),--}}
{{--                    'year'=> Request::get('year'),--}}
{{--                    'id_project'=> Request::get('id_project'),--}}
{{--                    'sortfield'=> Request::get('sortfield'),--}}
{{--                    'sorttype'=> Request::get('sorttype')])->links() : ''--}}
{{--                    }}--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
{{--    @include('time_trackers.partials.add_project_modal')--}}
{{--    {!! Form::open(['id' => 'frm_reload', 'class' => 'form-horizontal']) !!}--}}
{{--    <input type="hidden" name="id" value="">--}}
{{--    <input type="hidden" name="reload" value="1">--}}
{{--    {!! Form::close() !!}--}}
    @section('javascript')
        <script type="text/javascript" src="{{ asset('js/app_times.js?version='.config('setting.version')) }}"></script>
        <script type="text/javascript" src="{{ asset('js/employee.js?version='.config('setting.version')) }}"></script>
    @stop
</x-app-layout>

