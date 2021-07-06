<div class="container">
    <div class="tab-pane">
        <div class="row">
            <div class="col-sm-12">
                {!! Form::hidden('id', $users->id, array('id' => 'id')) !!}
                <div class="form-group">
                    <label class="required @error('name') text-danger @enderror" for="name">{{__('Name')}}</label>
                    {!! Form::text('name', ($errors->has('name') ? old('name') : $users->name) , array('class' => 'form-control'.($errors->has('name') ? ' is-invalid':''), 'id' => 'name', 'maxlength' => 255)) !!}
                    @error('name')
                        <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="required @error('email') text-danger @enderror" for="email">{{__('Email')}}</label>
                    {!! Form::text('email', ($errors->has('email') ? old('email') : $users->email) , array('class' => 'form-control'.($errors->has('email') ? ' is-invalid':''), 'id' => 'email', 'maxlength' => 255)) !!}
                    @error('email')
                        <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            {{--<div class="col-sm-6">
                <div class="form-group">
                    <label class="required @error('employee_code') text-danger @enderror" for="employee_code">{{__('Employee code')}}</label>
                    {!! Form::text('employee_code', ($errors->has('employee_code') ? old('employee_code') : $users->employee_code) , array('class' => 'form-control'.($errors->has('employee_code') ? ' is-invalid':''), 'id' => 'employee_code', 'maxlength' => 255)) !!}
                    @error('employee_code')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>--}}
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="@error('address') text-danger @enderror" for="address">{{__('Address')}}</label>
                    {!! Form::text('address', ($errors->has('address') ? old('address') : $users->address) , array('class' => 'form-control'.($errors->has('address') ? ' is-invalid':''), 'id' => 'address', 'maxlength' => 255)) !!}
                    @error('address')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="@error('birthdate') text-danger @enderror" for="end_date">{{__('Birthdate')}}</label>
                    {!! Form::text('birthdate', format_date($users->birthdate) , array('class' => 'form-control datepicker'.($errors->has('birthdate') ? ' is-invalid':''), 'maxlength' => 10, 'id' => 'birthdate', 'autocomplete'=>'off')) !!}
                    @error('birthdate')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="required @error('password') text-danger @enderror" for="password">{{__('Password')}}</label>
                    {!! Form::password('password' , array('class' => 'form-control'.($errors->has('password') ? ' is-invalid':''), 'id' => 'password', 'maxlength' => 255)) !!}
                    @error('password')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="required @error('region') text-danger @enderror" for="region">{{__('Region')}}</label>
                    {!! Form::select('region',listRegion() , ($errors->has('region') ? old('region') : $users->region) , array('class' => 'form-control'.($errors->has('region') ? ' is-invalid':''), 'id' => 'region')) !!}
                    @error('region')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="required @error('password_confirmation') text-danger @enderror" for="password_confirmation">{{__('Confirm Password')}}</label>
                    {!! Form::password('password_confirmation' , array('class' => 'form-control'.($errors->has('password_confirmation') ? ' is-invalid':''), 'id' => 'repassword', 'maxlength' => 255, 'value'=>($errors->has('password_confirmation') ? old('password_confirmation') : $users->password_confirmation))) !!}
                    @error('password_confirmation')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="required @error('part_time') text-danger @enderror" for="region">{{__('Part-time')}}</label>
                    {!! Form::select('part_time',$userType , ($errors->has('part_time') ? old('part_time') : $users->part_time) , array('class' => 'form-control'.($errors->has('part_time') ? ' is-invalid':''), 'id' => 'part_time')) !!}
                    @error('part_time')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="required @error('level') text-danger @enderror" for="level">{{__('Level')}}</label>
                    {!! Form::select('level',listLevel() , ($errors->has('level') ? old('level') : $users->level) , array('class' => 'form-control'.($errors->has('level') ? ' is-invalid':''), 'id' => 'level')) !!}
                    @error('level')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @if(!empty($users->id))
            <div class="col-sm-6">
                <div class="form-group">
                    <a href="{{url('devices') . '?user_id='.$users->id}}">List Devices</a>
                </div>
            </div>
            @endif
            <div class="col-sm-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Save')}}</button>
                    <a href="{{url('users')}}" class="btn btn-default"><i class="fa fa-reply"></i> {{__('Back')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@section('javascript')
    <script>
        $('.datepicker').datetimepicker({
            showClose: true,
            format: 'DD/MM/YYYY'
        });
    </script>
@stop
