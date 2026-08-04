<?php
/**
 * Base Controller
 * Loads the models and views
 */
class Controller {

    // Load Model
    public function model($model) {
        // Require model file
        $modelFile = APPROOT . '/models/' . $model . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            // Instantiate model
            return new $model();
        } else {
            die('Model "' . $model . '" does not exist.');
        }
    }

    // Load View
    public function view($view, $data = []) {
        // Check for view file
        $viewFile = APPROOT . '/views/' . $view . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die('View "' . $view . '" does not exist.');
        }
    }

    // Redirect utility helper
    public function redirect($url) {
        header('Location: ' . URLROOT . '/' . ltrim($url, '/'));
        exit();
    }
}
