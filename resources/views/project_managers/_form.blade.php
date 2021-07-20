<div class="container">
    <div class="tab-pane">
        <div class="row">
            <div class="col-sm-12">
                {!! Form::hidden('id', $projectManagers->id, array('id' => 'id')) !!}
                <div class="form-group">
                    <label class="required @error('name_project') text-danger @enderror" for="input_name">{{__('Name project')}}</label>
                    {!! Form::text('name_project', ($errors->has('name_project') ? old('name_project') : $projectManagers->name_project) , array('class' => 'form-control'.($errors->has('name_project') ? ' is-invalid':''), 'id' => 'name_project', 'maxlength' => 255)) !!}
                    @error('name_project')
                        <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="required @error('start_date') text-danger @enderror" for="start_date">{{__('Start date')}}</label>
                    {!! Form::text('start_date', ($errors->has('name_project') ? format_date(old('start_date')) : format_date($projectManagers->start_date)), array('class' => 'form-control datepicker'.($errors->has('start_date') ? ' is-invalid':''), 'maxlength' => 10, 'id' => 'start_date', 'autocomplete'=>'off')) !!}
                    @error('start_date')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="@error('end_date') text-danger @enderror" for="end_date">{{__('End date')}}</label>
                    {!! Form::text('end_date', format_date($projectManagers->end_date) , array('class' => 'form-control datepicker'.($errors->has('end_date') ? ' is-invalid':''), 'maxlength' => 10, 'id' => 'end_date', 'autocomplete'=>'off')) !!}
                    @error('end_date')
                    <div class="text text-danger text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Save')}}</button>
                    <a href="{{url('project_managers')}}" class="btn btn-default" onclick="loading();"><i class="fa fa-reply"></i> {{__('Back')}}</a>
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
