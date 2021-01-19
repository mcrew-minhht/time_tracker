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
        <div class="font-20 mb-25">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $request['year'].'/'.$request['month'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            S E R V I C E &nbsp;&nbsp;  R E P O R T
        </div>
        <table width="100%">
            <tr>
                <td style="vertical-align: top;width: 50%">
                    <div class="text_underline">Company: <span class="text_uppercase">MCRew - Tech</span></div>
                    <div class="text_underline">Name: {{ $info->employee_name }}</div>
                </td>
                <td>
                    <table class="table">
                        <tr>
                            <td class="text-center">Responsible</td>
                            <td class="text-center">Person in charge</td>
                            <td class="text-center">Reporter</td>
                        </tr>
                        <tr>
                            <td class="text-center" style="height: 80px;">
                                <img src="{{ public_path('images/dau.png') }}" style="width: 70px">
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table class="content" style="margin-top: 20px">
            <thead>
                <tr>
                    <th style="width: 20%">Day</th>
                    <th style="width: 20%">Day of the week</th>
                    <th style="width: 20%">Time of work(h)</th>
                    <th style="width: 40%">Memo</th>
                </tr>
            </thead>
            <tbody>
            @php
                $total_work = 0;
            @endphp
            @foreach($period as $i=>$date)
                @php
                    $bg = '#cccdd0';
                    $param = [
                        'user_id' => $user_id,
                        'working_date' => $date->format('Y-m-d'),
                        'id_project' => $request['id_project']
                    ];
                    $time_trackers_item = $time_trackers->CheckDateByParams($param);
                    $total_work = isset($time_trackers_item) ? $total_work + $time_trackers_item->working_time : $total_work;
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
            <tr>
                <td colspan="2">Total</td>
                <td class="text-center">{{ $total_work }}</td>
                <td></td>
            </tr>
            <tr><td colspan="4" style="height: 100px;vertical-align: top">NOTE</td></tr>
            </tbody>
        </table>
    </body>
</html>
