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
    .page-break {
        page-break-after: always;
    }
</style>
<body>
    @foreach($users as $item)
        <table class="content">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Working date</th>
                    <th>Working time</th>
                </tr>
            </thead>
            <tbody>
            @php
                $data['params'] = [
                    'user_id' => $item->id,
                    'id_project' => isset($request['id_project']) ? $request['id_project'] : '',
                ];
                $lists = $time_trackers->getAllByIdEmployee($data['params'])->get();
            @endphp
                @if(isset($lists) && count($lists) > 0)
                    @foreach($lists as $item)
                        <tr>
                            <td>{{ $item->employee_name }}</td>
                            <td>
                                {{ $item->working_date }}
                            </td>
                            <td class="text-center">
                                {{ $item->working_time }}
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
    <div class="page-break"></div>
    @endforeach
</body>
</html>

