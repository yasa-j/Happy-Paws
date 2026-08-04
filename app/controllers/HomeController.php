<?php
/**
 * Home Controller
 * Default Controller for Happy Paws Landing Page
 */
class HomeController extends Controller {

    public function index() {
        $data = [
            'title' => 'Welcome to Happy Paws',
            'description' => 'Pet Care & Veterinary Appointment Management System'
        ];

        $this->view('home/index', $data);
    }
}
