<?php

namespace App\Http\Controllers;

use App\Models\arrivalproduct;
use App\Models\Size;
use Illuminate\Http\Request;

class ArrivalproductController extends Controller
{
    //
    public function index(){
        $arrivals = arrivalproduct::with('size.variant')->get();
        
        
        return view('arrivalproducts.index',compact('arrivals'));
    }
    // public function edit($id){
    //     $arrival = arrivalproduct::findOrFail($id);


    //     return view();
    // }
    public function edit($id)
    {
        $arrival = arrivalproduct::with('size')->findOrFail($id);
        $sizes = Size::all(); // Get all available sizes

        return view('arrivalproducts.edit', compact('arrival', 'sizes'));
    }

    // Update arrival product
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'arrivalDate' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'size_id' => 'required|exists:sizes,id',
        ]);

        $arrival = ArrivalProduct::findOrFail($id);
        $arrival->update($validated);

        return redirect()->route('arrival.index')->with('success', 'Arrival product updated successfully!');
    }
}
