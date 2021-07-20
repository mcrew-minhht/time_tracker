<x-app-layout>
    <x-slot name="header">
        <div class="box-header with-border overflow-hidden row">
            <div class="col-6">
                <h3 class="box-title">
                    <span>Devices Lists</span>
                </h3>
            </div>
            <div class="col-6">
                <div class="box-action float-right">
                    <ul class="header-action overflow-hidden">
                        <li class="float-left"><a href="{{url('devices/create')}}" class="btn btn-success" onclick="loading();"><i class="fas fa-plus-square"></i> {{__('Add')}}</a></li>
                        <li class="float-right"><a href="{{url('devices')}}" class="btn btn-light" onclick="loading();"><i class="fas fa-sync-alt"></i> {{__('Reset')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="bg-white shadow container-fluid mx-auto py-10 mt-2">

        <div class="box-search-table overflow-hidden mb-2">
            <div class="box-search-table overflow-hidden mb-2 pl-4">
                {!! Form::open(array('url' => url("./devices"), 'id' => 'form-search', 'method' => 'GET','class'=>'overflow-hidden')) !!}
                <div id="hidden_form" style="display: none;"></div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-4">Name device</label>
                            <div class="col-md-6">
                                {!! Form::text('name', Request::get('name'), array('class' => 'form-control', 'maxlength' => 255, 'id' => 'input_source', 'placeholder' => __('Enter Name'))) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-4">Employees</label>
                            <div class="col-md-6">
                                <select name="user_id" class="form-control">
                                    <option value="0"></option>
                                    @foreach($data['employees'] as $item_user)
                                        <option value="{{ $item_user->id }}" {!! ($item_user->id == Request::get('user_id')) ? 'selected' : '' !!}>{{ $item_user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="float-right">
                    <button class="btn btn-primary float-right" type="submit" onclick="loading();"><i class="fa fa-search"></i> {{__('search')}}</button>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="float-left">
                <a href="javascript:;" id="btn-delete-all" data-routes="{{url('devices/destroy')}}" class="btn btn-danger disabled"><i class="fas fa-trash-alt"></i> {{__("Delete")}}</a>
            </div>
        </div>
        <table class="table table-bordered table-striped w-full" id="table-main">
            <thead class="thead-light">
            <tr>
                <th class="px-4 py-2" style="width: 30px;"><input type="checkbox" id="checkAll" /></th>
                <th class="px-4 py-2" style="width: 130px;">{!! sort_title('id', __('Device ID')) !!}</th>
                <th class="px-4 py-2" style="width: 250px;">{!! sort_title('name', __('Device Name')) !!}</th>
                <th class="px-4 py-2"  style="width: calc(100% - 610px)!important;">{!! sort_title('description', __('Description')) !!}</th>
                <th class="px-4 py-2 text-center" style="width: 200px;">{!! sort_title('invoice', __('Invoice')) !!}</th>
                <th class="px-4 py-2" style="width: 200px;">{!! sort_title('employees', __('Employees')) !!}</th>
                <th style="width: 100px;"></th>
            </tr>
            </thead>
            <tbody>
            @if(isset($data['lists']) && count($data['lists'])>0)
                @foreach($data['lists'] as $item)
                    <tr>
                        <td class="px-4 py-2"><input type="checkbox" class="checkItem" value="{{$item->id}}" /></td>
                        <td class="px-4 py-2">{{ $item->id ?? '' }}</td>
                        <td class="px-4 py-2">{{ $item->name ?? '' }}</td>
                        <td class="px-4 py-2">{{ $item->description }}</td>
                        <td class="px-4 py-2 text-center">
                            @if(!empty($item->invoice))
                            <a href="{{url('devices/invoice/'.$item->id)}}" class="text-center"><i class="fas fa-download"></i></a>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $item->employees }}</td>
                        <td class="px-4 py-2 overflow-hidden">
                            <a href="{{url('devices/edit/'.$item->id)}}" class="float-left text-primary" onclick="loading();"><i class="fas fa-edit"></i></a>
                            <a href="javascript:;" class="float-right text-danger btn-delete" data-routes="{{url('devices/destroy')}}" data-id="{{$item->id}}" ><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center">{{__('No data')}}</td>
                </tr>
            @endif

            </tbody>
        </table>
        <div class="row">
            <div class="col-sm-12">
                {{ $data['lists']->appends(['search'=> Request::get('search'), 'user_id'=> Request::get('user_id') ,'sortfield'=> Request::get('sortfield'), 'sorttype'=> Request::get('sorttype')])->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
