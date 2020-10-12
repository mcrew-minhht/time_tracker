

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Input Your Times
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6">
           {!! Form::open(['url' => route('time_trackers.update',$id)]) !!}
               <input type="hidden" name="_method" value="PUT">
               <input type="hidden" name="employee_code" value="{{ $employee_code }}">
               <input type="hidden" name="id_project" value="{{ $id_project }}">
               <table class="table-fixed w-full">
                   <thead>
                        <tr>
                            <th class="border">Day</th>
                            <th class="border">Day of the week</th>
                            <th class="border" style="width: 150px">Time of work(h)</th>
                            <th class="border">Memo</th>
                        </tr>
                   </thead>
                   <tbody>
                        @php
                            $sum_time = 0;
                        @endphp
                        @foreach($period as $i=>$date)
                            @php
                            $bg = '#cccdd0';
                            $params = [
                                'employee_code' => $employee_code,
                                'id_project' => $id_project,
                                'working_day' => $date->format('Y-m-d'),
                            ];
                            $time_trackers_item = $time_trackers->CheckDateByParams($params);
                            $sum_time = isset($time_trackers_item) ? $sum_time + $time_trackers_item->working_time : $sum_time;
                            @endphp
                            <tr>
                                <td class="border px-4 py-2">
                                    <input type="hidden" name="working_day[]" value="{{ $date->format('Y/m/d') }}">
                                    {{ $date->format('d/m/Y') }}
                                </td>
                                <td class="border px-4 py-2 text-center" style="background: {{ in_array($date->dayOfWeek,[0,6]) ? $bg : '' }}">{{ $weekMap[$date->dayOfWeek] }}</td>
                                <td class="border p-0">
                                    <input class="w-full h-full text-center" type="text" autocomplete="off" name="working_time[]" value="{!! isset($time_trackers_item) ? $time_trackers_item->working_time : '' !!}">
                                </td>
                                <td class="border">
                                    <input class="w-full h-full" type="text" name="memo[]" value="{!! isset($time_trackers_item) ? $time_trackers_item->memo : '' !!}">
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-right">Total:</td>
                            <td class="px-4 py-2 text-right">{{ $sum_time }} (h)</td>
                            <td></td>
                        </tr>
                   </tbody>
               </table>
               <div class="text-right p-6">
                   <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150 ml-4">Save</button>
               </div>
           {!! Form::close() !!}
        </div>
    </div>
</x-app-layout>
