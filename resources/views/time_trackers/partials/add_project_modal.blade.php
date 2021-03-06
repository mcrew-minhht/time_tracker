<div class="modal fade" id="modal_add_times" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-pop" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add time</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body modal-body-custom">
                {!! Form::open(['method' => 'POST', 'id' => 'frm_add_project', 'class' => 'needs-validation']) !!}
                <input type="hidden" name="id" value="">
                <div id="msg_modal"></div>
                <div class="form-group row">
                    <label class="col-form-label col-md-3">Employee</label>
                    <div class="col-md-9">
                        <select name="user_id" class="form-control">
                            @foreach($employees as $item_user)
                                <option value="{{ $item_user->id }}" {{ Auth::user()->id == $item_user->id ? 'selected' : '' }}>{{ $item_user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-md-3">Project</label>
                    <div class="col-md-9">
                        <select name="id_project" class="form-control">
                            @foreach($projects as $item_project)
                                <option value="{{ $item_project->id }}">{{ $item_project->name_project }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-form-label col-md-6">Start Working Date</label>
                            <div class="col-md-6">
                                <input name="start_working_day" class="form-control div-textfield--160 datepicker">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 gr_end_working_day">
                        <div class="form-group row">
                            <label class="col-form-label col-md-6">End Working Date</label>
                            <div class="col-md-6">
                                <input name="end_working_day" class="form-control div-textfield--160 datepicker">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-md-3">Working Time</label>
                    <div class="col-md-9">
                        <input name="working_time" class="form-control div-textfield--160" value="8">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-md-3">Memo</label>
                    <div class="col-md-9">
                        <textarea name="memo" class="form-control  div-textfield--160" cols="3"></textarea>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer modal-footer-custom">
                <button type="button" class="btn btn-default" id="btn_reload" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add_project">Save</button>
            </div>

        </div>
    </div>
</div>


