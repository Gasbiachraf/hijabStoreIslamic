<?php

namespace App\Http\Controllers;

use App\Models\CommandVariant;
use App\Models\Size;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommandVariantController extends Controller
{
    //
    public function edit($id)
    {
        try {
            $commandVariant = CommandVariant::findOrFail($id);

            // Get the product ID from the selected variant
            $productId = $commandVariant->variant->inventory->product_id;

            // Fetch only variants that belong to the same product
            $variants = Variant::whereHas('inventory', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })->get();

            // Get sizes for the selected variant
            $sizes = Size::where('variant_id', $commandVariant->variant_id)->get();

            return view('command.edit', compact('commandVariant', 'variants', 'sizes'));
        } catch (\Exception $e) {
            Log::error('CommandVariantController edit error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'command_variant_id' => $id
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading the command variant. Please try again.');
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'variant_id' => 'required|exists:variants,id',
                'quantity' => 'required|integer|min:1',
                'size' => 'nullable|string|max:255',
            ]);

            $commandVariant = CommandVariant::findOrFail($id);

            $previousVariant = Variant::findOrFail($commandVariant->variant_id);
            $previousSize = Size::where('variant_id', $previousVariant->id)
                ->where('size', $commandVariant->size)
                ->first();

            $newVariant = Variant::findOrFail($request->variant_id);
            $newSize = Size::where('variant_id', $newVariant->id)
                ->where('size', $request->size)
                ->first();

            //Restore the previous quantity back to stock
            if ($previousSize) {
                $previousSize->quantity += $commandVariant->quantity;
                $previousSize->save();
            }

            //Deduct the new quantity from the new stock
            if ($newSize) {
                if ($newSize->quantity < $request->quantity) {
                    return redirect()->back()->with('error', 'Not enough stock available for the selected size.');
                }
                $newSize->quantity -= $request->quantity;
                $newSize->save();
            }

            //Update the command with new product and quantity
            $commandVariant->update([
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
                'size' => $request->size,
            ]);

            return redirect()->route('command.index')->with('success', 'Command updated successfully!');
        } catch (\Exception $e) {
            Log::error('CommandVariantController update error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'command_variant_id' => $id
            ]);

            return redirect()->back()->with('error', 'An error occurred while updating the command variant. Please try again.');
        }
    }

    public function getSizes($variantId)
    {
        try {
            $sizes = Size::where('variant_id', $variantId)->get(['size']);
            return response()->json(['sizes' => $sizes]);
        } catch (\Exception $e) {
            Log::error('CommandVariantController getSizes error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
                'variant_id' => $variantId
            ]);

            return response()->json(['error' => 'An error occurred while fetching sizes'], 500);
        }
    }



}
