<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Project Lists
        </h2>
    </x-slot>
    <div class="bg-white shadow max-w-7xl mx-auto py-10 mt-2 px-1">
        <div class="box-search-table overflow-hidden mb-2">
            <div class="float-left">
                <a href="javascript:;" id="btn-delete-all" data-routes="#" class="btn btn-danger"><i class="fas fa-trash-alt"></i> {{__("Delete")}}</a>
            </div>
            <div class="float-right">
                {!! Form::open(array('url' => url("./project_managers"), 'id' => 'form-search', 'method' => 'GET','class'=>'overflow-hidden')) !!}
                <button class="btn btn-primary float-right" type="submit"><i class="fa fa-search"></i> {{__('search')}}</button>
                {!! Form::text('search', Request::get('search'), array('class' => 'form-control form-inline float-left', 'maxlength' => 50, 'id' => 'input_source', 'placeholder' => __('Enter keyword'), 'style'=>'width:200px;')) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <table class="table table-bordered table-striped w-full">
            <thead class="thead-light">
            <tr>
                <th class="px-4 py-2">{!! sort_title('name_project', __('Project Name')) !!}</th>
                <th class="px-4 py-2">{!! sort_title('start_date', __('Start date')) !!}</th>
                <th class="px-4 py-2">{!! sort_title('end_date', __('End date')) !!}</th>
                <th class="px-4 py-2">{!! sort_title('created_at', __('Created date')) !!}</th>
                <th class="px-4 py-2">{!! sort_title('created_user', __('Created user')) !!}</th>
                <th class="px-4 py-2">{!! sort_title('updated_at', __('Updated date')) !!}</th>
                <th class="px-4 py-2">{!! sort_title('updated_user', __('Updated user')) !!}</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($data['lists']) && count($data['lists'])>0)
                @foreach($data['lists'] as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->name_project ?? '' }}</td>
                        <td class="px-4 py-2">{{ format_date("$item->start_date") }}</td>
                        <td class="px-4 py-2">{{ format_date("$item->end_date") }}</td>
                        <td class="px-4 py-2">{{ format_date("$item->created_at") }}</td>
                        <td class="px-4 py-2">{{ $item->created_user ?? '' }}</td>
                        <td class="px-4 py-2">{{ format_date("$item->updated_at") }}</td>
                        <td class="px-4 py-2">{{ $item->updated_user ?? '' }}</td>
                    </tr>
                @endforeach
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
