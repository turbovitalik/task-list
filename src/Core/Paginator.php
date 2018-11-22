<?php

namespace App\Core;

class Paginator
{
    public function view()
    {
        $html = file_get_contents(APP_ROOT . 'views/pagination.php');

        return $html;
    }
}