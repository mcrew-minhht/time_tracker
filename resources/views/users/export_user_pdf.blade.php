<link href="{{ public_path('css/pdf.css?version='.config('setting.version')) }}" rel="stylesheet">
<table class="content">
    <thead>
        <tr>
            <th class="px-2 py-2" style="width: 160px;">{!! __('Name') !!}</th>
            <th class="px-2 py-2" style="width: 120px;">{!!  __('Email') !!}</th>
            <th class="px-2 py-2" style="width: 70px;">{!! __('Birthdate') !!}</th>
            <th class="px-2 py-2" >{!! __('Address') !!}</th>
            <th class="px-2 py-2" style="width: 100px;">{!! __('Region') !!}</th>
            <th class="px-2 py-2" style="width: 70px;">{!! __('Part-time') !!}</th>
            <th class="px-2 py-2" style="width: 60px;">{!! __('Level') !!}</th>
        </tr>
    </thead>
    <tbody>
    @if(isset($lists) && count($lists) > 0)
        @foreach($lists as $item)
            <tr class="row">
                <td class="px-2 py-2 font-vi">{{ $item->name ?? '' }}</td>
                <td class="px-2 py-2">{{ $item->email ?? '' }}</td>
                {{--<td class="px-2 py-2">{{ $item->employee_code ?? '' }}</td>--}}
                <td class="px-2 py-2">{{ format_date("$item->birthdate") }}</td>
                <td class="px-2 py-2">{{ $item->address ?? '' }}dashd ashdkahsd kahshdajsd asdjagsd akhgsdkgas asjgdjsa</td>
                <td class="px-2 py-2">{{ listRegion(true,$item->region ?? null) }}</td>
                <td class="px-2 py-2">{{ listPartTime(true,$item->part_time ?? null) }}</td>
                <td class="px-2 py-2">{{ listLevel(true,$item->level ?? null) }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="7" class="text-center">No result!</td>
        </tr>
    @endif
    </tbody>
</table>

