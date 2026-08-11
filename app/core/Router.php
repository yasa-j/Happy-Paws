<?php
/**
 * Core Router (App Class)
 * Creates URL & loads core controller
 * URL FORMAT - /controller/method/params
 */
class Router {
    //when URL doesn't provide anything default is the views/home/index.php
    protected $currentController = 'HomeController';
    protected $currentMethod = 'index';
    protected $params = [];

    //runs automatically when new Router(); is done
    public function __construct() {
        $url = $this->getUrl();

        // 1. Check for Controller file in app/controllers/
        if (!empty($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            if (file_exists(APPROOT . '/controllers/' . $controllerName . '.php')) {
                $this->currentController = $controllerName;
                unset($url[0]);
            }
            else{
                require_once APPROOT . '/controllers/ErrorController.php';

                $controller = new ErrorController();
                $controller->notFound();
                return;
            }
        }

        // Require the controller class file
        require_once APPROOT . '/controllers/' . $this->currentController . '.php';

        // Instantiate controller class - creates controller objects
        $this->currentController = new $this->currentController;

        // 2. Check for Method (action)
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
            else{
                require_once APPROOT . '/controllers/ErrorController.php';

                $controller = new ErrorController();
                $controller->notFound();
                return;
            }
        }

        // 3. Get Params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getUrl() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [];
    }
}
