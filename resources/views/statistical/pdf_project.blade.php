<table class="table table-bordered table-striped w-full">
    <thead>
    <tr>
        <th class="px-4 py-2">User</th>
        <th class="px-4 py-2">Working date</th>
        <th class="px-4 py-2">Start working date</th>
        <th class="px-4 py-2">Start working time</th>
        <th class="px-4 py-2">End working date</th>
        <th class="px-4 py-2">End working time</th>
        <th class="px-4 py-2">Rest time</th>
    </tr>
    </thead>
    <tbody>
    @if(isset($lists) && count($lists) > 0)
        @foreach($lists as $item)
            <tr>
                <td class="border px-4 py-2">{{ $item->employee_name }}</td>
                <td class="border px-4 py-2">
                    {{ $item->working_date }}
                    <input type="hidden" name="working_date" value="{{ $item->working_date }}">
                </td>
                <td class="border px-4 py-2">
                    {{ $item->start_working_day }}
                    <input type="hidden" name="start_working_day" value="{{ $item->start_working_day }}">
                </td>
                <td class="border px-4 py-2">
                    {{ $item->start_working_time }}
                    <input type="hidden" name="start_working_time" value="{{ $item->start_working_time }}">
                </td>
                <td class="border px-4 py-2">
                    {{ $item->end_working_day }}
                    <input type="hidden" name="end_working_day" value="{{ $item->end_working_day }}">
                </td>
                <td class="border px-4 py-2">
                    {{ $item->end_working_time }}
                    <input type="hidden" name="end_working_time" value="{{ $item->end_working_time }}">
                </td>
                <td class="border px-4 py-2">
                    {{ $item->rest_time }}
                    <input type="hidden" name="rest_time" value="{{ $item->rest_time }}">
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
