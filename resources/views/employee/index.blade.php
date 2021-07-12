<x-app-layout>
    <x-slot name="header">
        <div class="box-header with-border overflow-hidden row">
            <div class="col-6">
                <h3 class="box-title">
                    <span>Employee Project</span>
                </h3>
            </div>
            <div class="col-6">
                <div class="box-action float-right">
                    <ul class="header-action overflow-hidden">
                        <li class="float-left"><a href="{{url('project_managers/create')}}" class="btn btn-success"><i class="fas fa-plus-square"></i> {{__('Add')}}</a></li>
                        <li class="float-right"><a href="{{url('project_managers')}}" class="btn btn-light" ><i class="fas fa-sync-alt"></i> {{__('Reset')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="bg-white shadow container-fluid mx-auto py-10 mt-2">
        <div class="box-search-table overflow-hidden mb-2">
            <div class="">
                {!! Form::open(['method' => 'POST', 'id' => 'frm_search_times', 'class' => 'needs-validation']) !!}
                <input type="hidden" name="action" value="">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
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
                            <div class="col-md-3">
                             <button type="button" class="btn btn-primary btn_search">Search</button>
                            </div>
                            @if($errors->has('end_working_day'))
                                <div class="text text-danger text-sm px-3">{{ $errors->first('end_working_day')}}</div>
                            @endif
                        </div>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
            <table class="table table-bordered table-striped w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2" width="25%">{!! sort_title('user_id', __('Project')) !!}</th>
                        <th class="px-4 py-2" width="10%"></th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($lists) && count($lists) > 0)
                        @foreach($lists as $item)
                        <tr data-id="{{$item->id}}">
                            <td style="cursor: pointer" class="border px-4 py-2 first-td">
                                <span class="fas-icon" data-id="{{$item->id}}"><i class="fas fa-plus fas-{{$item->id}}"></i></span>
                                <span class="fas-name" data-id="{{$item->id}}">{{ $item->name_project }}</span>
                            </td>
                            <td class="border px-4 py-2">
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
            </div>
        </div>
    </div>
    @section('javascript')
        <script type="text/javascript" src="{{ asset('js/app_times.js?version='.config('setting.version')) }}"></script>
        <script type="text/javascript" src="{{ asset('js/time_trackers.js?version='.config('setting.version')) }}"></script>
        <script type="text/javascript" src="{{ asset('js/employee.js?version='.config('setting.version')) }}"></script>
    @stop
</x-app-layout>
