<!doctype html>
<html lang="ja">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <link href="{{ public_path('css/pdf.css?version='.config('setting.version')) }}" rel="stylesheet">
        <style>
            @font-face{
                font-family: ipag;
                font-style: normal;
                font-weight: normal;
                src:url('{{ storage_path('fonts/ipag.ttf')}}');

            }

            @font-face{
                font-family: ipag;
                font-style: bold;
                font-weight: bold;
                src:url('{{ storage_path('fonts/ipag.ttf')}}');

            }
        </style>
    </head>
    <body>

        <table width="100%">
            <tr>
                <td class="font-20" style="height: 60px; vertical-align: top; text-align: center; width: 40%">{{ $request['year'].'/'.$request['month'] }}</td>
                <td colspan="2" style="vertical-align: top; font-family: ipag" class="font-20">勤&nbsp;&nbsp;務&nbsp;&nbsp;報&nbsp;&nbsp;告&nbsp;&nbsp;書</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div class="text_underline">Company: <span class="text_uppercase">MCRew - Tech</span></div>
                    <div class="text_underline">Name: <span class="font-vi">{{ $info->employee_name }}</span></div>
                </td>
                <td style="width: 30%">
                </td>
                <td>
                    <table class="table">
                        <tr>
                            <td class="text-center" style="font-size: 12px;">責任者</td>
                            <td class="text-center" style="font-size: 12px;">担当者</td>
                            <td class="text-center" style="font-size: 12px;">報告者</td>
                        </tr>
                        <tr>
                            <td class="text-center" style="height: 55px;">
                                <img src="{{ public_path('images/dau.png') }}" style="width: 50px">
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
                    <td class="text-center" style="background: {{ in_array($date->dayOfWeek,[0,6]) ? $bg : '' }}; font-family: ipag">{{ $weekMap[$date->dayOfWeek] }}</td>
                    <td class="text-center">{{ isset($time_trackers_item) ? $time_trackers_item->working_time : '' }}</td>
                    <td style="font-family: ipag">{{ isset($time_trackers_item) ? $time_trackers_item->memo : '' }}</td>
                </tr>
            @endforeach
            <tr>
                <td class="text-center" colspan="2" style="font-family: ipag">合計</td>
                <td class="text-center">{{ $total_work }}</td>
                <td></td>
            </tr>
            <tr><td colspan="4" style="height: 100px;vertical-align: top; font-family: ipag">補足</td></tr>
            </tbody>
        </table>
    </body>
</html>
