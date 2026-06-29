<?php

declare(strict_types=1);

/*
 * Here you can define your own helper functions.
 * Make sure to use the `function_exists` check to not declare the function twice.
 */

if (! function_exists('app_date_format')) {
    function app_date_format()
    {
        return config('app.format.date');
    }
}

if (! function_exists('app_date_time_format')) {
    function app_date_time_format()
    {
        return config('app.format.date_time');
    }
}
