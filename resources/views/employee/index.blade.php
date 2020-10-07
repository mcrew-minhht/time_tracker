<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employee') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <table class="table">
            <thead>
                <th>Code</th>
                <th>Name</th>
                <th>Birthday</th>
                <th>Address</th>
                <th>Created Date</th>
                <th>Created User</th>
                <th></th>
            </thead>
            <tbody>
            @if(!empty($list))
                @foreach($list as $item)
                <tr>
                    <td>{!! $item->employee_code !!}</td>
                    <td>{!! $item->name !!}</td>
                    <td>{!! $item->birthdate !!}</td>
                    <td>{!! $item->address !!}</td>
                    <td>{!! $item->created_date !!}</td>
                    <td>{!! $item->created_user !!}</td>
                    <td></td>
                </tr>
                @endforeach
            @else
                <tr><td colspan="7">No result</td></tr>
            @endif
            </tbody>
        </table>
    </div>
</x-app-layout>
