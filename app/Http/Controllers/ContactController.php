<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
   
    public function index()
    {
        try {
            $messages = Contact::all();
            return view('contact.index', compact('messages'));
        } catch (\Exception $e) {
            Log::error('ContactController index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading messages. Please try again.');
        }
    }

    public function store(Request $request)
    {

        $token = $request->header('Token');

        if ($token !== 'achrafshouldgotokenitra') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // Assuming you want to log or process the data:
        // Log the data or save to the database (optional)
        \Log::info('Contact Form Data:', $request->all());
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Store the data in the database
        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
        ]);
        // Optionally, respond with a success message:
        return response()->json(['message' => 'Form data received successfully']);
    }

    public function destroy($id)
    {
        try {
            Contact::findOrFail($id)->delete();
            return redirect()->route('contacts.index')->with('success', 'Message deleted successfully.');
        } catch (\Exception $e) {
            Log::error('ContactController destroy error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'contact_id' => $id
            ]);

            return redirect()->back()->with('error', 'An error occurred while deleting the message. Please try again.');
        }
    }



}
