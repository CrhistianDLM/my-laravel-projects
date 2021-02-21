<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Services') }}
        </h2>
        @empty($noBar)

        <a href="{{ route('services.create') }}" class="text-sm text-gray-700 underline">Agregar</a>
        @endempty

    </x-slot>
    <div class="w-4/5 m-auto my-2">
        <ul>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @foreach($services as $service)

                <li class="bg-purple-100 px-3 py-2 mb-2 rounded shadow-lg">
                    <a href="{{route('services.show', $service->id)}}" class="font-bold">
                        {{$service->title}}
                    </a>
                    <a href="{{route('services.show', $service->id)}}">{{$service->description}}</a>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
