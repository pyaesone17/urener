<?php 

namespace App\Exceptions;

use Exception;

class UrlNotFoundException extends Exception
{
    /**
     * Render the exception.
     *
     * @return void
     */
    public function render($request)
    {
        return view("errors.url_not_found");
    }
}
