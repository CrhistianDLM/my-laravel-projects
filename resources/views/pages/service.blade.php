
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Service') }}
            </h2>
            @php
                $route = route('chats.index').'?service='.$service->id;
            @endphp
            <x-dropdown-link :href="$route">
                            Chats
                         </x-dropdown-link>
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
                @if($service->user_id != auth()->user()->id)
                 <div>
                    <a href="{{route('services.show', $service->id)}}?chat=true">
                        <x-button>
                         {{ __('chat') }}
                        </x-button>
                    </a>
                </div>
                @endif
            </x-slot>
        </x-customs.service>
    </x-app-layout>
