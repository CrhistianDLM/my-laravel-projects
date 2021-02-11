<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat') }}
        </h2>
    </x-slot>
    <div class="flex flex-col w-3/5 m-auto px-3 py-2 border-l-2 border-r-2">
        
        <ul class="my-1">
            @php
                $leftStyles = 'rounded rounded-r-2xl bg-blue-200 text-left mr-4';
                $rightStyle = 'rounded rounded-l-2xl bg-blue-300 text-right ml-4';
            @endphp
            @if($page<($total - 1))
                <li class="p-2 text-center">
                    <a href="{{route("chats.show", $service_id)}}?pag={{$page+1}}&{{!empty($client_id) ? 'client='.$client_id : ""}}" class="bg-green-100 p-2 rounded font-bold text-cente self-center">
                        Ver más
                    </a>
                </li>
            @endif
            @foreach($chat as $message)
                @if($message->type == "IMAGE")
                    <li class="px-2 pb-2  {{!empty($message->partner) ? 'pt-2':''}}">
                       <div class="flex {{$message->write_by == $autor_id ? 'justify-start':'justify-end'}}">
                           <div class="w-40">
                                <img src="{{asset($message->message)}}" class="w-full">
                           </div>
                       </div>
                    </li>
                @else
                <li class="p-2 mt-2 {{$message->write_by == $autor_id ? $leftStyles:$rightStyle}}">
                    <span class="font-bold">
                        {{$message->write_by == $autor_id ? 'A':'B'}}                        
                    </span>
                     - {{$message->message}}
                 </li>
                 @endif
            @endforeach
            
        </ul>
        <form method="POST" action="{{route('chats.store')}}" class="grid grid-cols-3 gap-4" enctype="multipart/form-data">
            @csrf
            <input type="text" name="message" id="message" class="col-span-2 rounded">
            <input type="hidden" name="service_id" value='{{$service_id}}'>
            <input type="hidden" name="client_id" value='{{$client_id}}'>
            <div>
                <label for="message_file" class="px-2 bg-blue-500 rounded text-indigo-50">
                    Subir Archivo
                </label>
                <input type="file" name="message_file" id="message_file" class="hidden">
                <x-button class="justify-center">
                 {{ __('Enviar') }}
                </x-button>
            </div>
        </form>
    </div>

</x-app-layout>
