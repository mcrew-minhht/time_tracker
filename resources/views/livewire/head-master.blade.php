<div class="max-w-7xl mx-auto py-6">
    @if ($errors->any())
        <div class="bg-red-600">
            <button type="button" class="close right-0" data-dismiss="alert" aria-hidden="true">×</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-white">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @php
            \Session::flush('errors');
        @endphp
    @endif
</div>
