

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Input Your Times
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-6">
           {!! Form::open(['url' => route('time_trackers.update',$id), 'id' => 'tbl_input_time']) !!}
               <input type="hidden" name="_method" value="PUT">
               <input type="hidden" name="employee_code" value="{{ $employee_code }}">
               <input type="hidden" name="id_project" value="{{ $id_project }}">
               <table class="table-fixed w-full" >
                   <thead>
                        <tr>
                            <th class="border">Day</th>
                            <th class="border">Day of the week</th>
                            <th class="border" style="width: 150px">Time of work(h)</th>
                            <th class="border" style="width: 150px">Overtime(h)</th>
                            <th class="border" style="width: 150px">Time of(h)</th>
                            <th class="border">Memo</th>
                        </tr>
                   </thead>
                   <tbody>
                        @php
                            $total_work = $total_over = $total_off = 0;
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
                            $total_work = isset($time_trackers_item) ? $total_work + $time_trackers_item->working_time : $total_work;
                            $total_over = isset($time_trackers_item) ? $total_over + $time_trackers_item->time_overtime : $total_over;
                            $total_off = isset($time_trackers_item) ? $total_off + $time_trackers_item->time_off : $total_off;
                            @endphp
                            <tr>
                                <td class="border px-4 py-2">
                                    <input type="hidden" name="working_day[]" value="{{ $date->format('Y/m/d') }}">
                                    {{ $date->format('d/m/Y') }}
                                </td>
                                <td class="border px-4 py-2 text-center" style="background: {{ in_array($date->dayOfWeek,[0,6]) ? $bg : '' }}">{{ $weekMap[$date->dayOfWeek] }}</td>
                                <td class="border p-0">
                                    <input class="input_time work_time" type="text" autocomplete="off" data-col="working_time" name="working_time[]" value="{!! isset($time_trackers_item) ? $time_trackers_item->working_time : '' !!}">
                                </td>
                                <td class="border p-0">
                                    <input class="input_time over_time" type="text" autocomplete="off" data-col="time_overtime" name="time_overtime[]" value="{!! isset($time_trackers_item) ? $time_trackers_item->time_overtime : '' !!}">
                                </td>
                                <td class="border p-0">
                                    <input class="input_time off_time" type="text" autocomplete="off" data-col="time_off" name="time_off[]" value="{!! isset($time_trackers_item) ? $time_trackers_item->time_off : '' !!}">
                                </td>
                                <td class="border">
                                    <input class="w-full h-full" type="text" name="memo[]" value="{!! isset($time_trackers_item) ? $time_trackers_item->memo : '' !!}">
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-right">Total:</td>
                            <td class="px-4 py-2 text-right"><span class="sum_time">{{ (!empty($total_work)) ? $total_work : 0 }}</span> (h)</td>
                            <td class="px-4 py-2 text-right"><span class="sum_over">{{ (!empty($total_over)) ? $total_over : 0 }}</span> (h)</td>
                            <td class="px-4 py-2 text-right"><span class="sum_off">{{ (!empty($total_off)) ? $total_off : 0 }}</span> (h)</td>
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
    @section('javascript')
        <script type="text/javascript" src="{{ asset('js/app_times.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/time_trackers.js') }}"></script>
    @stop
</x-app-layout>
