<!doctype html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="{{ public_path('css/pdf.css?version='.config('setting.version')) }}" rel="stylesheet">
    </head>
    <body>
        <table style="width: 50%; margin-bottom: 20px">
            <tr>
                <td class="font-20" style="margin-left: 50px">{{ $request['year'].'/'.$request['month'] }}</td>
            </tr>
            <tr>
                <td class="text_underline">Company: <span class="text_uppercase">MCRew - Tech</span></td>
            </tr>
            <tr>
                <td class="text_underline">Name: {{ $info->employee_name }}</td>
            </tr>
        </table>
        <table class="content">
            <thead>
                <tr>
                    <th class="px-4 py-2">Day</th>
                    <th class="px-4 py-2">Day of the week</th>
                    <th class="px-4 py-2">Time of work(h)</th>
                    <th class="px-4 py-2">Memo</th>
                </tr>
            </thead>
            <tbody>
            @php
                $total_work = $total_over = $total_off = 0;
            @endphp
            @foreach($period as $i=>$date)
                @php
                    $bg = '#cccdd0';
                    $param = [
                        'user_id' => 1,
                        'working_date' => $date->format('Y-m-d'),
                    ];
                    $time_trackers_item = $time_trackers->CheckDateByParams($param);
                @endphp
                <tr>
                    <td class="border px-4 py-2">
                        {{ $date->format('d/m/Y') }}
                    </td>
                    <td style="background: {{ in_array($date->dayOfWeek,[0,6]) ? $bg : '' }}">{{ $weekMap[$date->dayOfWeek] }}</td>
                    <td class="text-center">{{ isset($time_trackers_item) ? $time_trackers_item->working_time : '' }}</td>
                    <td></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </body>
</html>
