<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $messageByPage = 15;
    public function index()
    {
        //
        $service_id = request()->service;
        $chats = Chat::select(["autor_id", Chat::raw("max(client_id) as client_id")])
            ->join("users", "users.id", "=", "client_id")
            ->groupBy(["client_id", "autor_id"])
            ->where([["service_id", "=", $service_id]]);

        $query = User::select(["users.id", "users.name", "chats.*"])->joinSub($chats, "chats", function ($join) {
            $join->on('users.id', '=', 'chats.client_id');
        })->get();
        //return $chats->get();
        return view("pages.chats", [
            "chats" => $query,
            "service_id" => $service_id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $service = Services::find($request->service_id);

        if(!empty($request->client_id)){
            $chat = Chat::where([
                ["autor_id", '=', $service->user_id], 
                ['client_id', '=', $request->client_id]
            ])->first();
            $client = empty($chat) ? $request->client_id : $chat->client_id;
        }
        
       
        //return $newChat->id;
        $id = $this->insertMessage($request);
        if($path = $this->validateFile($request, $id)){
            $newChat2 = new Chat();
            $newChat2->service_id = $request->service_id;
            $newChat2->autor_id = $service->user_id;
            $newChat2->client_id = $client;
            $newChat2->message = $path[0];
            $newChat2->status = 'SENDING';
            $newChat2->partner =  $newChat->id;
            $newChat2->type = ($path[1] == "jpg") ? "IMAGE" : "AUDIO";
            $newChat2->write_by = auth()->user()->id;
            $newChat2->save();
        }
        return redirect()->back();
    }
    private function validateFile(Request $request, $id){
        $file = $request->file('message_file');
        if(empty($file)){
            return false;
        }
        $ext = $file->extension();
        $path = $file->storeAs('message_imgs', 'message_'.$id.'.jpg');
        return [$path, $ext];
    }
    private function insertMessage(Request $request){
        if(empty($request->message)){
            return null;
        }
        $newChat = new Chat();
        $newChat->service_id = $request->service_id;
        $newChat->autor_id = $service->user_id;
        $newChat->client_id = $client;
        $newChat->message = $request->message;
        $newChat->status = 'SENDING';
        $newChat->type = 'TEXT';
        $newChat->write_by = auth()->user()->id;
        $newChat->save();
        return  $newChat->id;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $client_id = auth()->user()->id;
        if(!empty(request()->client)){
            $client_id = request()->client;
        }
        $services = Services::find($id);

        //pagination
        $page = empty(request()->pag) ? 0 : request()->pag;
        $limit = $this->messageByPage;
        $count = $chat = Chat::where([
                ["autor_id", '=', $services->user_id], 
                ['client_id', '=', $client_id ]
            ])->count();
        $chat = Chat::where([
                ["autor_id", '=', $services->user_id], 
                ['client_id', '=', $client_id ]
            ])
        ->orderBy("created_at", "DESC")
        //->orderBy("created_at", "ASC")
        ->limit($limit)
        ->offset($limit*$page);
        //return $chat;
        $data = [
            "total" => ceil($count/$limit),
            "items_by_page" => $limit,
            "page" => $page,
            "chat"=>$chat->get()->reverse(),
            "autor_id" => $services->user_id,
            "service_id" => $services->id,
            'client_id' => $client_id
         ];
         $chat->where([["write_by", "!=", auth()->user()->id]])->update(["status" => "READING"]);
         if(auth()->user()->id == $services->user_id){

         }
        return view("pages.chat", $data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
