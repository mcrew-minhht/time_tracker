<meta name="frm_search" content="frm_search_month">
<x-app-layout>
    <x-slot name="header">
        <div class="box-header with-border overflow-hidden row">
            <div class="col-6">
                <h3 class="box-title">
                    <span>Time Trackers</span>
                </h3>
            </div>
            {{--<div class="col-12">
            @if ($errors->any())
                <ul class="ul_error">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            </div>--}}
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6">
            <div class="col-xs-12">
                {!! Form::open(['method' => 'POST', 'id' => 'frm_search_month', 'class' => 'needs-validation']) !!}
                <input type="hidden" name="action" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-form-label col-md-1">User</label>
                            <div class="col-md-2">
                                <select name="user_id" class="form-control">
                                    <option value=""></option>
                                    @foreach($employees as $item_user)
                                        <option value="{{ $item_user->id }}" {!! (isset($params['user_id']) && $item_user->id == $params['user_id']) ? 'selected' : '' !!}>{{ $item_user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <label class="col-form-label col-md-1">Month</label>
                            <div class="col-md-2">
                                <input type="text" name="month" class="form-control div-textfield--160 @error('month') is-invalid @enderror"  value="{!! isset($old->month) ? $old->month : '' !!}">
                                @error('month')
                                <div class="text text-danger text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <label class="col-form-label col-md-1">Year</label>
                            <div class="col-md-2">
                                <input type="text" name="year" class="form-control div-textfield--160 @error('year') is-invalid @enderror" value="{!! isset($old->year) ? $old->year : '' !!}">
                                @error('year')
                                <div class="text text-danger text-sm">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-primary btn_search">Search</button>
                                <a class="btn btn-info btn_export_month">Export All</a>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

            <table class="table table-bordered table-striped w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Working date</th>
                        <th class="px-4 py-2">Working time</th>
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
                                {{ $item->working_time }}
                                <input type="hidden" name="start_working_time" value="{{ $item->working_time }}">
                            </td>
                            <td class="border px-4 py-2">
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
                    {{ isset($lists) ? $lists->appends([
                    'user_id'=> Request::get('user_id'),
                    'month'=> Request::get('month'),
                    'year'=> Request::get('year'),
                    'sortfield'=> Request::get('sortfield'),
                    'sorttype'=> Request::get('sorttype')])->links() : ''
                    }}
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

