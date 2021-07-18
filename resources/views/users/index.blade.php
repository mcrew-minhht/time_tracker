<x-app-layout>
    <x-slot name="header">
        <div class="box-header with-border overflow-hidden row">
            <div class="col-6">
                <h3 class="box-title">
                    <span>User Lists</span>
                </h3>
            </div>
            <div class="col-6">
                <div class="box-action float-right">
                    <ul class="header-action overflow-hidden">
                        <li class="float-left"><a href="{{url('users/create')}}" class="btn btn-success"><i class="fas fa-plus-square"></i> {{__('Add')}}</a></li>
                        <li class="float-right"><a href="{{url('users')}}" class="btn btn-light" ><i class="fas fa-sync-alt"></i> {{__('Reset')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>
    <div class="bg-white shadow container-fluid py-3 mt-2">
        <div class="box-search-table overflow-hidden mb-2 pl-4">
            {!! Form::open(array('url' => url("./users"), 'id' => 'form-search', 'method' => 'GET','class'=>'overflow-hidden')) !!}
            <div id="hidden_form" style="display: none;"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4">Name</label>
                        <div class="col-md-6">
                            {!! Form::text('username', Request::get('username'), array('class' => 'form-control', 'maxlength' => 50, 'id' => 'input_source', 'placeholder' => __('Enter Name'))) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4">Region</label>
                        <div class="col-md-6">
                            {!! Form::select('region',listRegion(false,null, true) , ($errors->has('region') ? old('region') : Request::get('region')) , array('class' => 'form-control'.($errors->has('region') ? ' is-invalid':''), 'id' => 'region')) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <label class="col-form-label col-md-4">Part-time</label>
                        <div class="col-md-6">
                            {!! Form::select('part_time',listPartTime(false, null, true) , ($errors->has('part_time') ? old('part_time') : Request::get('part_time')) , array('class' => 'form-control'.($errors->has('part_time') ? ' is-invalid':''), 'id' => 'part_time')) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="float-right">
                <button class="btn btn-info float-left mr-1" type="button" id="import_users" data-toggle="modal" data-target="#importModal"><i class="fa fa-file-export"></i> {{__('Import')}}</button>
                <button class="btn btn-info float-left mr-1" type="button" id="export_users"><i class="fa fa-file-export"></i> {{__('Export')}}</button>
                <button class="btn btn-primary float-right" type="submit"><i class="fa fa-search"></i> {{__('search')}}</button>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="box-search-table overflow-hidden mb-2">
            <div class="float-left">
                <a href="javascript:;" id="btn-delete-all" data-routes="{{url('users/destroy')}}" class="btn btn-danger disabled"><i class="fas fa-trash-alt"></i> {{__("Delete")}}</a>
            </div>
        </div>
        <table class="table table-bordered table-striped w-full" id="table-main">
            <thead class="thead-light">
            <tr>
                <th class="px-2 py-2" style="width: 30px;"><input type="checkbox" id="checkAll" /></th>
                <th class="px-2 py-2" style="width: 50px;">{!! sort_title('no', __('No')) !!}</th>
                <th class="px-2 py-2" style="width: 250px;">{!! sort_title('name', __('Name')) !!}</th>
                <th class="px-2 py-2" style="width: 350px;">{!! sort_title('email', __('Email')) !!}</th>
                <th class="px-2 py-2" style="width: 150px;">{!! sort_title('birthdate', __('Birthdate')) !!}</th>
                <th class="px-2 py-2" >{!! sort_title('address', __('Address')) !!}</th>
                <th class="px-2 py-2" style="width: 150px;">{!! sort_title('region', __('Region')) !!}</th>
                <th class="px-2 py-2" style="width: 100px;">{!! sort_title('part_time', __('Part-time')) !!}</th>
                <th class="px-2 py-2" style="width: 60px;">{!! sort_title('level', __('Level')) !!}</th>
                <th style="width: 60px;"></th>
            </tr>
            </thead>
            <tbody>
            @if(isset($data['lists']) && count($data['lists'])>0)
                <?php $no=1 ?>
                @foreach($data['lists'] as $item)
                    <tr>
                        <td class="px-2 py-2"><input type="checkbox" class="checkItem" value="{{$item->id}}" /></td>
                        <td class="px-2 py-2">{{ $no }}</td>
                        <td class="px-2 py-2">{{ $item->name ?? '' }}</td>
                        <td class="px-2 py-2">{{ $item->email ?? '' }}</td>
                        <td class="px-2 py-2">{{ format_date("$item->birthdate") }}</td>
                        <td class="px-2 py-2">{{ $item->address ?? '' }}</td>
                        <td class="px-2 py-2">{{ listRegion(true,$item->region ?? null) }}</td>
                        <td class="px-2 py-2">{{ $item->type_name ?? null }}</td>
                        <td class="px-2 py-2">{{ listLevel(true,$item->level ?? null) }}</td>
                        <td class="px-2 py-2 overflow-hidden">
                            <a href="{{url('users/edit/'.$item->id)}}" class="float-left text-primary"><i class="fas fa-edit"></i></a>
                            <a href="javascript:;" class="float-right text-danger btn-delete" data-routes="{{url('users/destroy')}}" data-id="{{$item->id}}" ><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    <?php $no+=1 ?>
                @endforeach
            @else
                <tr>
                    <td colspan="10" class="text-center">{{__('No data')}}</td>
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
    <!-- Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                {!! Form::open(array('url' => url("./users/import_users"), 'id' => 'form-import', 'method' => 'POST','enctype'=>'multipart/form-data')) !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="file"  name="file" >
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                    <div class="text text-danger text-sm" id="file_error"></div>
                </div>
                <div class="modal-footer">
                    <a class="float-left  mr-auto" href="{{url('users/download')}}">Download file import</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import data</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    @section('javascript')
        <script type="text/javascript" src="{{ asset('js/users.js?version='.config('setting.version')) }}"></script>
        <script>
            $(".custom-file-input").on("change", function() {
                var fileName = $(this).val().split("\\").pop();
                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });
        </script>
    @stop
</x-app-layout>
