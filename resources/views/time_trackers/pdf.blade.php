<table class="table table-bordered table-striped w-full">
    <thead>
    <tr>
        <th class="px-4 py-2">Project</th>
        <th class="px-4 py-2">User</th>
        <th class="px-4 py-2">Working date</th>
        <th class="px-4 py-2">Working time</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($lists) && count($lists) > 0)
        @foreach($lists as $item)
            <tr>
                <td class="border px-4 py-2">{{ $item->name_project }}</td>
                <td class="border px-4 py-2">{{ $item->employee_name }}</td>
                <td class="border px-4 py-2">
                    {{ $item->working_date }}
                    <input type="hidden" name="working_date" value="{{ $item->working_date }}">
                </td>
                <td class="border px-4 py-2">
                    {{ $item->working_time }}
                    <input type="hidden" name="start_working_time" value="{{ $item->working_time }}">
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" class="text-center">No result!</td>
        </tr>
    @endif
    </tbody>
</table>
