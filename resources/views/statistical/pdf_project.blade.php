<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ public_path('css/pdf.css?version='.config('setting.version')) }}" rel="stylesheet">
</head>
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
    .page-break {
        page-break-after: always;
    }
</style>
<body>
    @foreach($users as $item)
        <table width="100%">
            <tr>
                <td class="font-20" style="height: 60px; vertical-align: top; text-align: center; width: 40%">2020/11</td>
                <td colspan="2" style="vertical-align: top; font-family: ipag" class="font-20">勤&nbsp;&nbsp;務&nbsp;&nbsp;報&nbsp;&nbsp;告&nbsp;&nbsp;書</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <div class="text_underline">Company: <span class="text_uppercase">MCRew - Tech</span></div>
                    <div class="text_underline">Name: {!! $item->name !!}</div>
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
                    $data['params'] = [
                        'user_id' => $item->id,
                        'id_project' => isset($request['id_project']) ? $request['id_project'] : '',
                    ];
                    $lists = $time_trackers->getAllByIdEmployee($data['params'])->get();
                    $total_work = 0;
                @endphp
                @if(isset($lists) && count($lists) > 0)
                    @foreach($lists as $item)
                        @php
                            $bg = '#cccdd0';
                            $dayOfTheWeek = new \Carbon\Carbon($item->working_date);
                            $total_work = $total_work + $item->working_time;
                        @endphp
                        <tr>
                            <td>{{ $item->working_date }}</td>
                            <td class="text-center" style="background: {{ in_array($dayOfTheWeek->dayOfWeek,[0,6]) ? $bg : '' }};font-family: ipag">{{ $weekMap[$dayOfTheWeek->dayOfWeek]}} </td>
                            <td class="text-center">
                                {{ $item->working_time }}
                            </td>
                            <td></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td class="text-center" colspan="2" style="font-family: ipag">合計</td>
                        <td class="text-center">{{ $total_work }}</td>
                        <td></td>
                    </tr>
                    <tr><td colspan="4" style="height: 100px;vertical-align: top; font-family: ipag">補足</td></tr>
                @else
                    <tr>
                        <td colspan="7" class="text-center">No result!</td>
                    </tr>
                @endif
            </tbody>
        </table>
    <div class="page-break"></div>
    @endforeach
</body>
</html>

