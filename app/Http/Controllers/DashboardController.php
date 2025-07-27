<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Client;
use App\Models\Command;
use App\Models\CommandVariant;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Variant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // total earnings
            $commandsvariants = CommandVariant::all();
            $totalEarnings =  number_format($commandsvariants->sum('salePrice'), 0, '.', ' ');
            // total earnings of the last 7 days
            $sevenDaysAgo = Carbon::now()->subDays(7);
            $last7daysSells = CommandVariant::where('created_at', '>=', $sevenDaysAgo)->get();
            $last7daysEarnings = $last7daysSells->sum('salePrice');
            function formatCurrency($number)
            {
                if ($number >= 1000000) {
                    return round($number / 1000000, 1) . 'M';
                }
                return $number;
            }
            $total7daysEarnings = formatCurrency($last7daysEarnings);

            // today's earning
            $todayEarning = CommandVariant::where('created_at', Carbon::today());
            $totalTodayEarning = number_format($todayEarning->sum('salePrice'), 0, '.', ' ');
            // total customers
            $clients = Client::all()->count();
            // total of last 30 days orders
            $thirtyDaysAgo = Carbon::now()->subDays(30);
            $last30Orders = Command::where('created_at', '>=', $thirtyDaysAgo)->count();
            // all commands & command-variants & variants & categories
            $commands = Command::all();
            $storeCommands = Command::where('livraison', 'livraison')->get();
            $inPresentCommands = Command::where('livraison', 'in_present')->get();
            $commandVariants = CommandVariant::all();
            $variants = Variant::all();
            $categories = Category::all()->count();
            // sales of this month :
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $ordersThisMonth = CommandVariant::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
            $totalEarningThisMonth = number_format($ordersThisMonth->sum('salePrice'), 0,  '.', ' ');

            // the most selling products
            $products = CommandVariant::whereIn('variant_id', $variants->pluck('id'))
                ->with('variant')
                ->get()
                ->groupBy(fn($item) => $item->variant->color)
                ->sortByDesc(fn($group) => $group->count());

            $topcategories = [];
            foreach ($products as $color => $productGroup) {
                $firstProduct = $productGroup->first();
                if ($firstProduct && isset($firstProduct->variant->inventory->product->subcategory->category->name)) {
                    $topcategories[] = $firstProduct->variant->inventory->product->subcategory->category->name;
                }
            }
            $topcategories = array_unique($topcategories);
            $topcategories = array_values($topcategories);
            $totalCategorie = [];
            $categories = Category::with([
                'subcategories.products.inventories.variants.commands'
            ])->get();
            foreach ($categories as $key => $category) {
                $catSum = CommandVariant::whereHas('variant.inventory.product.subcategory.category', function ($query) use ($category) {
                    $query->where('name', $category->name);
                })->sum('salePrice');
                $totalCategorie[] = $catSum;
            }
            rsort($totalCategorie);

            $startDate = Carbon::today()->subDays(29);
            $endDate = Carbon::today();

            // Generate all days with default sales = 0
            $days = collect();
            for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                $days->put($date->timestamp * 1000, 0); // Store Unix timestamp in milliseconds
            }
            // Get sales data from the database
            $salesData = CommandVariant::where('created_at', '>=', $startDate)
                ->get()
                ->groupBy(fn($order) => Carbon::parse($order->created_at)->startOfDay()->timestamp * 1000)
                ->map(fn($orders) => $orders->sum('salePrice'));

            // Merge with default days to ensure all days exist
            $last30daysSells = $days->map(fn($sales, $timestamp) => [$timestamp, $salesData->get($timestamp, 0)])->values();

            $messages = Contact::take(8)->where('is_read', false)->get();

            return view('dashboard', compact(['variants', 'commands', 'last30Orders', 'total7daysEarnings', 'totalEarnings', 'storeCommands', 'inPresentCommands', 'totalTodayEarning', 'clients', 'categories', 'totalEarningThisMonth', 'products', 'topcategories', 'totalCategorie', 'last30daysSells', 'messages']));
        } catch (\Exception $e) {
            Log::error('Dashboard index error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'An error occurred while loading the dashboard. Please try again.');
        }
    }
}
