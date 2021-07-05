<div class="container">
    <div class="tab-pane">
        <div class="row">
            <div class="col-sm-6">
                {!! Form::hidden('id', $devices->id, array('id' => 'id')) !!}
                <div class="form-group">
                    <label class="col-form-label required @error('name') text-danger @enderror" for="input_name">{{__('Name device')}}</label>
                    {!! Form::text('name', ($errors->has('name') ? old('name') : $devices->name) , array('class' => 'form-control'.($errors->has('name') ? ' is-invalid':''), 'id' => 'name', 'maxlength' => 255)) !!}
                    @error('name')
                        <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <label class="col-form-label">Employees</label>
                <select name="user_id" class="form-control">
                    <option value="0"></option>
                    @foreach($employees as $item_user)
                        <option value="{{ $item_user->id }}" {!! (isset($devices->user_id) && $item_user->id == $devices->user_id) ? 'selected' : '' !!}>{{ $item_user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="col-form-label @error('description') text-danger @enderror" for="input_name">{{__('Description')}}</label>
                    {!! Form::textarea('description', ($errors->has('description') ? old('description') : $devices->description) , array('class' => 'form-control'.($errors->has('description') ? ' is-invalid':''), 'id' => 'description', 'rows' => 4, 'maxlength' => 255)) !!}
                    @error('description')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="col-form-label @error('invoice') text-danger @enderror" for="input_name">{{__('Invoice')}}&ensp;
                        @if(!empty($devices->invoice))
                        <a href="{{url('devices/invoice/'.$devices->id)}}"><i class="fas fa-download"></i></a>
                        @endif
                    </label>
                    <input type="file" class="form-control" name="invoice" id="customFile" />
                    @error('invoice')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Save')}}</button>
                    <a href="{{url('devices')}}" class="btn btn-default"><i class="fa fa-reply"></i> {{__('Back')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@section('javascript')
@stop
