<div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Add project</p>
                <div class="modal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>
            <div id="msg_modal"></div>
{{--            {!! Form::open(['url' => route('time_trackers.store'),'method' => 'POST', 'id' => 'add_project']) !!}--}}
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Employee
                    </label>
                    <select name="employee_code" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($employees as $item_user)
                            <option value="{{ $item_user->employee_code }}">{{ $item_user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Project
                    </label>
                    <select name="id_project" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($projects as $item_project)
                            <option value="{{ $item_project->id }}">{{ $item_project->name_project }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="button" id="add_project" class="px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">Save</button>
                <button type="button" class="modal-close px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400">Close</button>
            </div>
{{--            {!! Form::close() !!}--}}
        </div>
    </div>
</div>
