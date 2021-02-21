<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chats') }}
        </h2>
        <a href="{{ route('chats.create') }}" class="text-sm text-gray-700 underline">Agregar</a>
    </x-slot>

    <ul>
        @foreach($chats as $chat)
            <li class="bg-blue-200 px-3 py-2 mb-2 rounded shadow-lg">
                <a href="{{route('chats.show', $service_id)."?client=".$chat->client_id}}">with {{$chat->name}}</a>
            </li>
        @endforeach
    </ul>
</x-app-layout>
