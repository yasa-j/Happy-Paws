<?php

class ErrorController extends controller{

    public function notFound(){

        http_response_code(404);
        $this->view('errors/404');
    }
}