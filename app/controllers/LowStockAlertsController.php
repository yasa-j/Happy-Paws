<?php

/**
 * Controls the Product Manager low-stock alert screen.
 * Replace the temporary arrays with model calls after the inventory tables are created.
 */
class LowStockAlertsController extends Controller
{
    /**
     * Display the low-stock alert dashboard.
     */
    public function index()
    {
        // Temporary records used to render the interface without an inventory table.
        $items = [
            [
                'sku' => 'HPRD-102',
                'name' => 'Puppy Milk Formula',
                'details' => '400g Powder Tin • NutriPup',
                'category' => 'Nutrition & Food',
                'current_stock' => 4,
                'unit' => 'tins',
                'threshold' => 10,
                'reorder_target' => 24,
                'status' => 'low',
            ],
            [
                'sku' => 'HPRD-104',
                'name' => 'Dental Chews',
                'details' => 'Pack of 30 Tartar Control • Canine Care',
                'category' => 'Dental Care',
                'current_stock' => 2,
                'unit' => 'packs',
                'threshold' => 15,
                'reorder_target' => 40,
                'status' => 'low',
            ],
            [
                'sku' => 'HPRD-109',
                'name' => 'Cat Food Adult',
                'details' => 'Salmon & Rice 5kg dry kibble',
                'category' => 'Nutrition & Food',
                'current_stock' => 1,
                'unit' => 'bag',
                'threshold' => 12,
                'reorder_target' => 30,
                'status' => 'low',
            ],
            [
                'sku' => 'HPRD-105',
                'name' => 'Antiseptic Spray',
                'details' => '150ml Clinical Wound Care • Chlorhexidine',
                'category' => 'Consumables',
                'current_stock' => 0,
                'unit' => 'bottles',
                'threshold' => 20,
                'reorder_target' => 0,
                'status' => 'out',
            ],
            [
                'sku' => 'HPRD-106',
                'name' => 'Deworming Tablet',
                'details' => 'Praziquantel Blister 10s • Rx Controlled',
                'category' => 'Pharmaceuticals',
                'current_stock' => 3,
                'unit' => 'boxes',
                'threshold' => 15,
                'reorder_target' => 50,
                'status' => 'low',
            ],
            [
                'sku' => 'HPRD-107',
                'name' => 'Ear Drops',
                'details' => 'Gentamicin Otic Sol. 15ml • Ophthalmic Grade',
                'category' => 'Otic & Eye Care',
                'current_stock' => 0,
                'unit' => 'vials',
                'threshold' => 25,
                'reorder_target' => 0,
                'status' => 'out',
            ],
        ];

        // Summary cards can later be calculated by an Inventory model.
        $data = [
            'pageTitle' => 'Low Stock Alerts',
            'items' => $items,
            'summary' => [
                'critical' => 7,
                'depleted' => 2,
                'pending_orders' => 3,
                'restock_cost' => 38400,
            ],
        ];

        $this->view('low-stock-alerts/index', $data);
    }
}

