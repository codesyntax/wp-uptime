<?php
function get_option_or_value($key, $default_value)
{
    $response = get_option($key);
    if (!$response) {
        $response = $default_value;
    }
    return $response;
}
