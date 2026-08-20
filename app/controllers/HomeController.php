<?php

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Happy Paws - Pet Healthcare',
            'clinicName' => 'Happy Paws'
        ];

        $this->view('home/index', $data);
    }
}