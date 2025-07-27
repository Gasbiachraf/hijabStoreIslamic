<?php

namespace App\Http\Controllers;

use App\Models\arrivalproduct;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArrivalproductController extends Controller
{
    //
    public function index(){
        try {
            $arrivals = arrivalproduct::with('size.variant')->get();
            return view('arrivalproducts.index',compact('arrivals'));
        } catch (\Exception $e) {
            Log::error('ArrivalproductController index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading arrival products. Please try again.');
        }
    }

    public function edit($id)
    {
        try {
            $arrival = arrivalproduct::with('size')->findOrFail($id);
            $sizes = Size::all(); // Get all available sizes

            return view('arrivalproducts.edit', compact('arrival', 'sizes'));
        } catch (\Exception $e) {
            Log::error('ArrivalproductController edit error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'arrival_id' => $id
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading the arrival product. Please try again.');
        }
    }

    // Update arrival product
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'arrivalDate' => 'required|date',
                'quantity' => 'required|integer|min:1',
                'size_id' => 'required|exists:sizes,id',
            ]);

            $arrival = ArrivalProduct::findOrFail($id);
            $arrival->update($validated);

            return redirect()->route('arrival.index')->with('success', 'Arrival product updated successfully!');
        } catch (\Exception $e) {
            Log::error('ArrivalproductController update error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'arrival_id' => $id
            ]);

            return redirect()->back()->with('error', 'An error occurred while updating the arrival product. Please try again.');
        }
    }
}
