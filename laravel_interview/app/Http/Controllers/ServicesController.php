<?php

namespace App\Http\Controllers;

use App\Models\Services;
use App\Models\Chat;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $services = Services::where('user_id', auth()->user()->id);
        return view("pages.services", ["services"=>$services->get()]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("pages.services.create", []);


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
        //dd($request);
        $file = $request->file('file-upload-image');
        $fields = $request->only(['title', 'description']);
        $fields["user_id"] = auth()->user()->id;
        //dd($fields);
        $service = Services::firstOrNew($fields);
        $service->save();
        $path = $file->storeAs('images', 'service_'.$service->id.'.jpg');
        $service->image_url = $path;
        $service->save();
        
        return redirect("services");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //$service = Services::find($id); 

        //dd($id);
        if(!empty(request()->chat)){
            
            return redirect("chats/".$id);
        }
        return view("pages.service", ["service"=>Services::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(Services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Services $services)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(Services $services)
    {
        //
    }
}
