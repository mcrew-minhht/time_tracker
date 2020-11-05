<x-app-layout>
    <x-slot name="header">
        <div class="box-header with-border overflow-hidden row">
            <div class="col-6">
                <h3 class="box-title">
                    <span class="ui-icon-bullet ">
                        <i class="fas fa-cubes "></i>
                    </span>
                    <span>Project Lists</span>
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
    <div class="bg-white shadow max-w-7xl mx-auto py-10 mt-2 px-1">

        <div class="box-search-table overflow-hidden mb-2">
            <div class="float-left">
                <a href="javascript:;" id="btn-delete-all" data-routes="{{url('project_managers/destroy')}}" class="btn btn-danger disabled"><i class="fas fa-trash-alt"></i> {{__("Delete")}}</a>
            </div>
            <div class="float-right">
                {!! Form::open(array('url' => url("./project_managers"), 'id' => 'form-search', 'method' => 'GET','class'=>'overflow-hidden')) !!}
                <button class="btn btn-primary float-right" type="submit"><i class="fa fa-search"></i> {{__('search')}}</button>
                {!! Form::text('search', Request::get('search'), array('class' => 'form-control form-inline float-left', 'maxlength' => 50, 'id' => 'input_source', 'placeholder' => __('Enter keyword'), 'style'=>'width:200px;')) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <table class="table table-bordered table-striped w-full" id="table-main">
            <thead class="thead-light">
            <tr>
                <th class="px-4 py-2" style="width: 30px;"><input type="checkbox" id="checkAll" /></th>
                <th class="px-4 py-2" style="width: calc(100% - 440px)!important;">{!! sort_title('name_project', __('Project Name')) !!}</th>
                <th class="px-4 py-2" style="width: 150px;">{!! sort_title('start_date', __('Start date')) !!}</th>
                <th class="px-4 py-2" style="width: 150px;">{!! sort_title('end_date', __('End date')) !!}</th>
                <th style="width: 100px;"></th>
            </tr>
            </thead>
            <tbody>
            @if(isset($data['lists']) && count($data['lists'])>0)
                @foreach($data['lists'] as $item)
                    <tr>
                        <td class="px-4 py-2"><input type="checkbox" class="checkItem" value="{{$item->id}}" /></td>
                        <td class="px-4 py-2" style="width: calc(100% - 440px)!important;overflow: hidden;">{{ $item->name_project ?? '' }}</td>
                        <td class="px-4 py-2">{{ format_date("$item->start_date") }}</td>
                        <td class="px-4 py-2">{{ format_date("$item->end_date") }}</td>
                        <td class="px-4 py-2 overflow-hidden">
                            <a href="{{url('project_managers/edit/'.$item->id)}}" class="float-left text-primary"><i class="fas fa-edit"></i></a>
                            <a href="javascript:;" id="btn-delete" class="float-right text-danger" data-routes="{{url('project_managers/destroy')}}" data-id="{{$item->id}}" ><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-center">{{__('No data')}}</td>
                </tr>
            @endif

            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-12">
                {{ $data['lists']->appends(['search'=> Request::get('search'), 'sortfield'=> Request::get('sortfield'), 'sorttype'=> Request::get('sorttype')])->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
