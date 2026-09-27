<?php

/**
 * Application Router
 *
 * URL format:
 * /controller/method/parameter
 *
 * Examples:
 * /dashboard/index
 * /products/index
 * /manageproducts/index
 * /products/edit/10
 */
class Router
{
    /**
     * Prevent the router from running twice.
     */
    private $hasRun = false;

    /**
     * Start routing automatically when the object is created.
     */
    public function __construct()
    {
        $this->run();
    }

    /**
     * Read the URL and call the requested controller method.
     */
    public function run()
    {
        if ($this->hasRun) {
            return;
        }

        $this->hasRun = true;

        $segments = $this->getUrlSegments();

        /*
         * Use DashboardController when no controller
         * is included in the URL.
         */
        $controllerSegment = isset($segments[0])
            ? $segments[0]
            : 'dashboard';

        $controllerName =
            $this->createControllerName($controllerSegment);

        $controllerFile =
            $this->findControllerFile($controllerName);

        if ($controllerFile === null) {
            $this->showError(
                'Controller not found: ' . $controllerName,
                404
            );

            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            $this->showError(
                'Controller class not found: ' .
                $controllerName,
                500
            );

            return;
        }

        $controller = new $controllerName();

        /*
         * Use the index method when no method
         * is included in the URL.
         */
        $method = isset($segments[1])
            ? $segments[1]
            : 'index';

        if (
            strpos($method, '__') === 0 ||
            !method_exists($controller, $method)
        ) {
            $this->showError(
                'Controller method not found: ' . $method,
                404
            );

            return;
        }

        $reflection = new ReflectionMethod(
            $controller,
            $method
        );

        if (!$reflection->isPublic()) {
            $this->showError(
                'The requested controller method is not public.',
                404
            );

            return;
        }

        /*
         * Everything after the controller and method
         * is passed to the method as a parameter.
         */
        $parameters = array_slice($segments, 2);

        call_user_func_array(
            [$controller, $method],
            $parameters
        );
    }

    /**
     * Read and separate the requested application URL.
     */
    private function getUrlSegments()
    {
        if (
            !isset($_GET['url']) ||
            trim($_GET['url']) === ''
        ) {
            return [];
        }

        $url = filter_var(
            rtrim($_GET['url'], '/'),
            FILTER_SANITIZE_URL
        );

        $segments = explode(
            '/',
            trim($url, '/')
        );

        return array_values(
            array_filter(
                $segments,
                function ($segment) {
                    return $segment !== '';
                }
            )
        );
    }

    /**
     * Convert a URL controller name into a class name.
     *
     * Examples:
     * dashboard         -> DashboardController
     * manage-products   -> ManageProductsController
     * low-stock-alerts  -> LowStockAlertsController
     */
    private function createControllerName($segment)
    {
        $segment = str_replace(
            ['-', '_'],
            ' ',
            strtolower($segment)
        );

        $segment = str_replace(
            ' ',
            '',
            ucwords($segment)
        );

        return $segment . 'Controller';
    }

    /**
     * Find a controller file without depending on
     * uppercase and lowercase filename differences.
     */
    private function findControllerFile($controllerName)
    {
        $controllerDirectory =
            APPROOT . '/controllers/';

        $expectedFilename =
            $controllerName . '.php';

        $exactFile =
            $controllerDirectory . $expectedFilename;

        if (file_exists($exactFile)) {
            return $exactFile;
        }

        $controllerFiles = glob(
            $controllerDirectory . '*Controller.php'
        );

        if ($controllerFiles === false) {
            return null;
        }

        foreach ($controllerFiles as $file) {
            if (
                strcasecmp(
                    basename($file),
                    $expectedFilename
                ) === 0
            ) {
                return $file;
            }
        }

        return null;
    }

    /**
     * Display a simple application error.
     */
    private function showError($message, $statusCode)
    {
        http_response_code($statusCode);

        echo '<!DOCTYPE html>';
        echo '<html lang="en">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" ';
        echo 'content="width=device-width, initial-scale=1.0">';
        echo '<title>HappyPaws Error</title>';
        echo '</head>';
        echo '<body style="font-family: Arial, sans-serif;';
        echo 'padding: 40px; background: #f8fafc;">';
        echo '<h1 style="color: #0f766e;">';
        echo $statusCode . ' Error';
        echo '</h1>';
        echo '<p>';
        echo htmlspecialchars($message);
        echo '</p>';
        echo '</body>';
        echo '</html>';
    }
}