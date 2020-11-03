<div class="modal fade" id="modal_add_times" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-pop" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add project</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            {!! Form::open(['method' => 'POST', 'id' => 'frm_add_project', 'class' => 'form-horizontal']) !!}
            <input type="hidden" name="id" value="">
            <div class="modal-body modal-body-custom">
                <div id="msg_modal"></div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Employee
                    </label>
                    <select name="user_id" class="form-control">
                        @foreach($employees as $item_user)
                            <option value="{{ $item_user->id }}">{{ $item_user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Project
                    </label>
                    <select name="id_project" class="form-control">
                        @foreach($projects as $item_project)
                            <option value="{{ $item_project->id }}">{{ $item_project->name_project }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="u-flex">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="working_date">
                        Working Date
                    </label>
                    <input name="working_date" class="form-control datepicker">
                </div>
                <div class="u-flex">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="start_working_day">
                        Start Working
                    </label>
                    <input name="start_working_day" class="form-control datetimepicker">
                </div>
                <div class="u-flex">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="end_working_day">
                        End Working
                    </label>
                    <input name="end_working_day" class="form-control datetimepicker">
                </div>
                <div class="u-flex">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="rest_time">
                        Rest time
                    </label>
                    <input name="rest_time" class="form-control">
                </div>
            </div>
            <div class="modal-footer modal-footer-custom">
                <button type="button" class="btn btn-default" id="btn_reload" data-dismiss="modal">キャンセル</button>
                <button type="button" class="btn btn-primary" id="add_project">はい</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


