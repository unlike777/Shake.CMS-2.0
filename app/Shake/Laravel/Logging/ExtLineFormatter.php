<?php

namespace App\Shake\Laravel\Logging;

use Monolog\Formatter\LineFormatter;

class ExtLineFormatter extends LineFormatter
{
    public function setFormat($format)
    {
        $this->format = $format;
    }
}
