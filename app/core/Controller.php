<?php

/**
 * Base Controller
 *
 * Every application controller extends this class.
 * It provides methods for loading models, loading views,
 * and redirecting users to another application page.
 */
class Controller
{
    /**
     * Load a model and return a new model object.
     *
     * Example:
     * $productModel = $this->model('Product');
     */
    public function model($model)
    {
        $modelFile = APPROOT . '/models/' . $model . '.php';

        if (!file_exists($modelFile)) {
            throw new Exception(
                'Model file not found: ' . $modelFile
            );
        }

        require_once $modelFile;

        if (!class_exists($model)) {
            throw new Exception(
                'Model class not found: ' . $model
            );
        }

        return new $model();
    }

    /**
     * Load a PHP view and pass data to it.
     *
     * Example:
     * $this->view('products/index', $data);
     */
    public function view($view, $data = [])
    {
        $viewFile = APPROOT . '/views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);

            die(
                'View file not found: ' .
                htmlspecialchars($viewFile)
            );
        }

        require $viewFile;
    }

    /**
     * Redirect the user to another application route.
     *
     * Example:
     * $this->redirect('products/index');
     */
    public function redirect($route = '')
    {
        $route = ltrim($route, '/');

        header('Location: ' . URLROOT . '/' . $route);
        exit;
    }
}