<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public function report(){

    }

    public function render($request)
    {
        return response()->view(
                'error.custom',
                array(
                    'exception' => $this
                ),
        );
    }
}
