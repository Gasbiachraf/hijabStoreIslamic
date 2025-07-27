<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    //

    public function index(){
        try {
            $clients = Client::all();
            return view('clients.index',compact('clients'));
        } catch (\Exception $e) {
            Log::error('ClientController index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading clients. Please try again.');
        }
    }

    public function create(){
        try {
            return view('clients.create');
        } catch (\Exception $e) {
            Log::error('ClientController create error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading the create client page. Please try again.');
        }
    }

    public function store(Request $request){
        try {
            $validated = $request->validate([
                'name'=>'required',
                'GSM'=>'required',
                'adress'=>'nullable',
                'email'=>'nullable'
            ]);
            $client = Client::create($validated);
            return redirect()->route('clients.index')->with('success', 'Client created successfully.');
        } catch (\Exception $e) {
            Log::error('ClientController store error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while creating the client. Please try again.');
        }
    }

    public function edit($id){
        try {
            $client = Client::findOrFail($id);
            return view('clients.edit',compact('client'));
        } catch (\Exception $e) {
            Log::error('ClientController edit error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'client_id' => $id
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading the client. Please try again.');
        }
    }

    public function update(Request $request, $id){
        try {
            $validated = $request->validate([
                'name'=>'required',
                'GSM'=>'required',
                'adress'=>'nullable',
                'email'=>'nullable'
            ]);
            $client = Client::findOrFail($id);
            $client->update($validated);
            return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
        } catch (\Exception $e) {
            Log::error('ClientController update error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'client_id' => $id
            ]);

            return redirect()->back()->with('error', 'An error occurred while updating the client. Please try again.');
        }
    }

    public function destroy($id){
        try {
            $client = Client::findOrFail($id);
            $client->delete();
            return redirect()->back()->with('success', 'Client deleted successfully.');
        } catch (\Exception $e) {
            Log::error('ClientController destroy error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'client_id' => $id
            ]);

            return redirect()->back()->with('error', 'An error occurred while deleting the client. Please try again.');
        }
    }

    public function historique($id)
    {
        try {
            $client = Client::with('commands')->findOrFail($id);  // Assuming you have a relation "commands"
            return view('clients.historique', compact('client'));
        } catch (\Exception $e) {
            Log::error('ClientController historique error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'client_id' => $id
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading client history. Please try again.');
        }
    }

}
