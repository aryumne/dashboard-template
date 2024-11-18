<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class CustomHandleException extends Exception
{
    public function __construct($message = "Default warning Error!")
    {
        parent::__construct($message);
        Log::warning("CustomHandleException: {$message}");
    }
}
