<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Project Lists
        </h2>
    </x-slot>
    <div class="bg-white shadow max-w-7xl mx-auto py-10 mt-2 px-1">
        <table class="table table-bordered table-striped w-full">
            <thead class="thead-light">
            <tr>
                <th class="px-4 py-2">{{ __('Project Name') }}</th>
                <th class="px-4 py-2">{{ __('Start date') }}</th>
                <th class="px-4 py-2">{{ __('End date') }}</th>
                <th class="px-4 py-2">{{ __('Created date') }}</th>
                <th class="px-4 py-2">{{ __('Created user') }}</th>
                <th class="px-4 py-2">{{ __('Updated date') }}</th>
                <th class="px-4 py-2">{{ __('Updated user') }}</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($data['lists']) && count($data['lists'])>0)
                @foreach($data['lists'] as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $item->name_project ?? '' }}</td>
                        <td class="px-4 py-2">{{ date_format(date_create("$item->start_date"), 'Y/m/d') }}</td>
                        <td class="px-4 py-2">{{  date_format(date_create("$item->end_date"), 'Y/m/d') }}</td>
                        <td class="px-4 py-2">{{  date_format(date_create("$item->created_at"), 'Y/m/d') }}</td>
                        <td class="px-4 py-2">{{ $item->created_user ?? '' }}</td>
                        <td class="px-4 py-2">{{  date_format(date_create("$item->updated_at"), 'Y/m/d') }}</td>
                        <td class="px-4 py-2">{{ $item->updated_user ?? '' }}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</x-app-layout>
