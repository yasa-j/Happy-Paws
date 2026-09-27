<?php

/**
 * Displays analytics and reporting data for the Product Manager.
 * Replace the temporary arrays with model queries when the reporting tables are ready.
 */
class ReportsController extends Controller
{
    /** Render the main reports page. */
    public function index()
    {
        $data = [
            'pageTitle' => 'Reports',
            'dateRange' => 'Last 30 Days (Oct 1 - Oct 24, 2024)',
            'summary' => [
                'sales' => 24650,
                'orders' => 12,
                'products_sold' => 86,
                'low_stock' => 3,
            ],
            'salesTrend' => [
                'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'current' => [2200, 3400, 4600, 3500, 6100, 7400, 5200],
                'previous' => [1800, 2800, 3300, 4300, 5100, 6200, 4100],
            ],
            'categories' => [
                ['name' => 'Nutrition & Food', 'percentage' => 42, 'revenue' => 10353, 'color' => '#0f766e'],
                ['name' => 'Pharmaceuticals & Antibiotics', 'percentage' => 28, 'revenue' => 6902, 'color' => '#38bdf8'],
                ['name' => 'Dental & Hygiene', 'percentage' => 18, 'revenue' => 4437, 'color' => '#86efac'],
                ['name' => 'Surgical & Consumables', 'percentage' => 12, 'revenue' => 2958, 'color' => '#94a3b8'],
            ],
            'topProducts' => [
                ['name' => 'Adult Dog Kibble', 'category' => 'Nutrition & Food', 'units' => 34, 'price' => 4850, 'revenue' => 164900, 'status' => 'in'],
                ['name' => 'Flea & Tick Shampoo', 'category' => 'Shampoo & Grooming', 'units' => 22, 'price' => 890, 'revenue' => 19580, 'status' => 'in'],
                ['name' => 'Puppy Milk Formula', 'category' => 'Nutrition & Food', 'units' => 16, 'price' => 1650, 'revenue' => 24750, 'status' => 'low'],
                ['name' => 'Dental Chews', 'category' => 'Dental Care', 'units' => 10, 'price' => 1200, 'revenue' => 12000, 'status' => 'in'],
                ['name' => 'Ear Drops', 'category' => 'Otic & Eye Care', 'units' => 5, 'price' => 750, 'revenue' => 3750, 'status' => 'out'],
            ],
        ];

        $this->view('reports/index', $data);
    }
}

