<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Service') }}
        </h2>
    </x-slot>
    <x-customs.service>
        <x-slot name="left">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <img src="{{asset($service->image_url)}}">
        </x-slot>
        <x-slot name="right">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{$service->title}}
            </h2>
            <p>
                {{$service->description}}
            </p>
            <div>
                
                <a href="{{route('services.show', $service->id)}}">
                    <x-button>
                     {{ __('chat') }}
                    </x-button>
                </a>

            </div>
        </x-slot>
    </x-customs.service>
</x-app-layout>
