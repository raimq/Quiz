<?php
/**
 * Created by PhpStorm.
 * User: raimo
 * Date: 8/17/2018
 * Time: 9:30 AM
 */

namespace Quiz\Controllers;

abstract class BaseController
{

    protected $post;

    protected $get;

    protected $action;

    public function handleCall(string $action)
    {
        $this->action = $action;
        $this->post = $_POST;
        $this->get = $_GET;
        $this->callAction($action);

    }

    protected function callAction($action)
    {
        echo static::$action();
    }

    protected function render(string $view, array $variables = []): string
    {
        $viewFile = $this->resolveViewFile($view);

        if (file_exists($viewFile)) {
            extract($variables);
            ob_start();
            include "$viewFile";
            $output = ob_get_clean();

            return $output;
        }

        return 'View Not Found';
    }

    protected function resolveViewFile(string $view)
    {
        return VIEW_DIR . "/$view.php";
    }


}