<?php

namespace MyPlugin\Api;

class Routes
{
    public function register_routes()
    {
        register_rest_route('my-plugin/v1', '/status', [
            'methods' => 'GET',
            'callback' => [$this, 'get_status'],
            'permission_callback' => '__return_true',
        ]);
    }

    public function get_status($request)
    {
        return rest_ensure_response([
            'status' => 'ok',
            'time'   => current_time('mysql')
        ]);
    }
}
