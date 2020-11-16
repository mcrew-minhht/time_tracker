<div class="container">
    <div class="tab-pane">
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="required @error('current_password') text-danger @enderror" for="current_password">{{__('Current Password')}}</label>
                    {!! Form::password('current_password' , array('class' => 'form-control'.($errors->has('current_password') ? ' is-invalid':''), 'id' => 'current_password', 'maxlength' => 255)) !!}
                    @error('current_password')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="required @error('password') text-danger @enderror" for="password">{{__('New Password')}}</label>
                    {!! Form::password('password' , array('class' => 'form-control'.($errors->has('password') ? ' is-invalid':''), 'id' => 'password', 'maxlength' => 255)) !!}
                    @error('password')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror

                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="required @error('password_confirmation') text-danger @enderror" for="password_confirmation">{{__('Confirm Password')}}</label>
                    {!! Form::password('password_confirmation' , array('class' => 'form-control'.($errors->has('password_confirmation') ? ' is-invalid':''), 'id' => 'repassword', 'maxlength' => 255, 'value'=>($errors->has('password_confirmation') ? old('password_confirmation') : ""))) !!}
                    @error('password_confirmation')
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
