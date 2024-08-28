<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Endpoints') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 container-fluid">
                    <div class="row">
                        <div class="col-2">
                            Name
                        </div>
                        <div class="col-1">
                            Method
                        </div>
                        <div class="col-5">
                            Data
                        </div>
                        <div class="col-1">
                            Link
                        </div>
                        <div class="col-3">
                            Actions
                        </div>
                    </div>
                </div>
                <hr>
                @foreach(\Auth::user()->endpoints as $endpoint)
                    <livewire:endpoint-component :endpoint="$endpoint" />
                @endforeach
                <hr>
                <a class="btn btn-success h-100 w-100" href="{{route('endpoints.create')}}">Add new endpoint</a>
            </div>
        </div>
    </div>

</x-app-layout>
