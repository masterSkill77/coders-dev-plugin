<?php

namespace Coders;

class Coders_TEAM
{
    public static function handleRoute(\WP_REST_Request $request)
    {
        $args = array(
            'post_type' => 'members',
            'posts_per_page' => -1
            // Several more arguments could go here. Last one without a comma.
        );
        $obituary_query = new \WP_Query($args);

        $members = array();

        if ($obituary_query->have_posts()) {
            while ($obituary_query->have_posts()) {
                $obituary_query->the_post();

                // Get custom fields or post data as needed
                $member_data = array(
                    'id'   => get_the_ID(),
                    'name' => get_the_title(),
                    'function' => get_the_excerpt(),
                    'photo' => get_the_post_thumbnail_url(),
                    'editor' => get_the_content()
                );

                $members[] = $member_data;
            }

            // Reset post data
            wp_reset_postdata();
        }

        // Create and return JSON response
        $response = new \WP_REST_Response($members, 200);
        $response->set_headers(['Cache-Control' => 'no-cache']);
        return $response;
    }
}
