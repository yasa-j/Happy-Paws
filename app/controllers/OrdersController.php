<?php

/**
 * Orders Controller
 * Prepares order information for the Orders view.
 * URL: http://localhost/Happy-Paws/orders/index
 */
class OrdersController extends Controller
{
    /** Display the customer-orders page. */
    public function index()
    {
        // Temporary records are used until an orders table is added to the database.
        $orders = [
            ['id'=>'#ORD-9421','date'=>'Oct 24, 2024','time'=>'10:45 AM','customer'=>'Dilshan Perera','initials'=>'DP','pet'=>'Bruno','animal'=>'Golden Retriever','total'=>4200,'status'=>'Completed'],
            ['id'=>'#ORD-9420','date'=>'Oct 24, 2024','time'=>'09:12 AM','customer'=>'Nimalee Fernando','initials'=>'NF','pet'=>'Whiskers','animal'=>'Persian Cat','total'=>1850,'status'=>'Processing'],
            ['id'=>'#ORD-9419','date'=>'Oct 23, 2024','time'=>'04:30 PM','customer'=>'Kusal Mendis','initials'=>'KM','pet'=>'Shadow','animal'=>'German Shepherd','total'=>6400,'status'=>'Completed'],
            ['id'=>'#ORD-9418','date'=>'Oct 23, 2024','time'=>'02:15 PM','customer'=>'Anoma Jayasuriya','initials'=>'AJ','pet'=>'Bella','animal'=>'Beagle','total'=>3100,'status'=>'Pending'],
            ['id'=>'#ORD-9417','date'=>'Oct 22, 2024','time'=>'11:05 AM','customer'=>'Tharindu Silva','initials'=>'TS','pet'=>'Tommy','animal'=>'Domestic Shorthair','total'=>9100,'status'=>'Processing'],
        ];

        // Summary-card values displayed above the orders table.
        $summary = ['total'=>12,'completed'=>8,'processing'=>3,'pending'=>1];

        // Load app/views/orders/index.php and pass the prepared data.
        $this->view('orders/index', [
            'pageTitle' => 'Orders',
            'orders' => $orders,
            'summary' => $summary,
        ]);
    }
}
