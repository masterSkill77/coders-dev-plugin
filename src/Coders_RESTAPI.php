<?php

namespace Coders;

use Coders\Coders_TEAM;

class Coders_RESTAPI
{
    public static function register()
    {
        add_action('rest_api_init',  function () {
            register_rest_route('api/v1/', '/teams', [
                'methods' => 'GET',
                'callback' => fn (\WP_REST_Request $request)  =>
                Coders_TEAM::handleRoute($request)

            ]);
        });
    }
}