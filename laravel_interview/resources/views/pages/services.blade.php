<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Services') }}
        </h2>
        <a href="{{ route('services.create') }}" class="text-sm text-gray-700 underline">Agregar</a>
    </x-slot>

    <ul>
        @foreach($services as $service)

            <li>
                <a href="{{route('services.show', $service->id)}}">{{$service->title}}</a>
                {{$service->description}}
            </li>
        @endforeach
    </ul>
</x-app-layout>
