<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //

    public function index(){
        $clients = Client::all();
        return view('clients.index',compact('clients'));
    }
    public function create(){

        return view('clients.create');
    }
    public function store(Request $request){
        $validated = $request->validate([
            'name'=>'required',
            'GSM'=>'required',
            'adress'=>'nullable',
            'email'=>'nullable'
        ]);
        $client = Client::create($validated);
        return redirect()->route('clients.index');
    }
    public function edit($id){
        $client = Client::findOrFail($id);

        return view('clients.edit',compact('client'));
    }
    public function update(Request $request, $id){
        $validated = $request->validate([
            'name'=>'required',
            'GSM'=>'required',
            'adress'=>'nullable',
            'email'=>'nullable'
        ]);
        $client = Client::findOrFail($id);
        $client->update($validated);
        return redirect()->route('clients.index');
    }
    public function destroy($id){
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->back();
    }
}
