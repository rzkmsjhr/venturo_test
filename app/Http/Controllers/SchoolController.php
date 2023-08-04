<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class SchoolController extends Controller
{   
    public function fetchSchoolData(Request $request) {
        $response = Http::get('http://tes-web.landa.id/sekolah.json');
        $data = $response->json();

        $selectedType = $request->input('type'); // Get the selected type from the request

        // Filter schools based on the selected type
        $filteredSchools = collect($data)->filter(function ($school, $key) use ($selectedType) {
            return str_contains($key, $selectedType);
        });

        return view('school', [
            'schools' => $filteredSchools,
            'selectedType' => $selectedType,
        ]);
    }

    public function fetchSalesData(Request $request) {
        $year = $request->input('tahun'); // Get the selected year from the request

        $responseMenus = Http::get("https://tes-web.landa.id/intermediate/menu");
        $menus = $responseMenus->json();
    
        $responseSales = Http::get("https://tes-web.landa.id/intermediate/transaksi?tahun=$year");
        $salesData = $responseSales->json();
    
        // Initialize arrays for makanan and minuman sales data
        $makananSales = [];
        $minumanSales = [];
    
        // Group and calculate the total sales data by menu and month
        foreach ($salesData as $sale) {
            $menu = $sale['menu'];
            $month = substr($sale['tanggal'], 5, 2); // Extract month from the 'tanggal' field
            $total = $sale['total'];
    
            $menuItem = [
                'month' => $month,
                'total' => $total,
            ];
    
            if (in_array($menu, array_column($menus, 'menu'))) {
                $category = array_values(array_filter($menus, function ($item) use ($menu) {
                    return $item['menu'] === $menu;
                }))[0]['kategori'];
    
                if ($category === 'makanan') {
                    if (!isset($makananSales[$menu])) {
                        $makananSales[$menu] = [];
                    }
                    $makananSales[$menu][] = $menuItem;
                } elseif ($category === 'minuman') {
                    if (!isset($minumanSales[$menu])) {
                        $minumanSales[$menu] = [];
                    }
                    $minumanSales[$menu][] = $menuItem;
                }
            }
        }
    
        return view('sales', [
            'makananSales' => $makananSales,
            'minumanSales' => $minumanSales,
            'menus' => $menus, // Pass the menus array to the view
            'selectedYear' => $year,
        ]);
}
}