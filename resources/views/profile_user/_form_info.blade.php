<div class="container">
    <div class="tab-pane">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="required @error('name') text-danger @enderror" for="name">{{__('Name')}}</label>
                    {!! Form::text('name', ($errors->has('name') ? old('name') : $user->name) , array('class' => 'form-control'.($errors->has('name') ? ' is-invalid':''), 'id' => 'name', 'maxlength' => 255)) !!}
                    @error('name')
                        <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="required @error('email') text-danger @enderror" for="email">{{__('Email')}}</label>
                    {!! Form::text('email', ($errors->has('email') ? old('email') : $user->email) , array('class' => 'form-control'.($errors->has('email') ? ' is-invalid':''), 'id' => 'email', 'maxlength' => 255)) !!}
                    @error('email')
                        <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="required @error('employee_code') text-danger @enderror" for="employee_code">{{__('Employee code')}}</label>
                    {!! Form::text('employee_code', ($errors->has('employee_code') ? old('employee_code') : $user->employee_code) , array('class' => 'form-control'.($errors->has('employee_code') ? ' is-invalid':''), 'id' => 'employee_code', 'maxlength' => 255, 'disabled'=>'disabled')) !!}
                    @error('employee_code')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="@error('address') text-danger @enderror" for="address">{{__('Address')}}</label>
                    {!! Form::text('address', ($errors->has('address') ? old('address') : $user->address) , array('class' => 'form-control'.($errors->has('address') ? ' is-invalid':''), 'id' => 'address', 'maxlength' => 255)) !!}
                    @error('address')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="@error('birthdate') text-danger @enderror" for="end_date">{{__('Birthdate')}}</label>
                    {!! Form::text('birthdate', format_date($user->birthdate) , array('class' => 'form-control datepicker'.($errors->has('birthdate') ? ' is-invalid':''), 'maxlength' => 10, 'id' => 'birthdate', 'autocomplete'=>'off')) !!}
                    @error('birthdate')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12 overflow-hidden">
                <div class="form-group float-right">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Save')}}</button>
                </div>
            </div>
        </div>
    </div>
</div>
