<?php

namespace Coders;

class Coders_TESTIMONIALS
{
    public static function handleRequest(\WP_REST_Request $request)
    {
        $args = array(
            'post_type'      => 'testimonials',
            'posts_per_page' => -1,
        );

        $testimonialsQuery = new \WP_Query($args);

        $testimonials = array();

        if ($testimonialsQuery->have_posts()) {
            while ($testimonialsQuery->have_posts()) {
                $testimonialsQuery->the_post();

                // Get custom fields or post data as needed
                $member_data = array(
                    'id'       => get_the_ID(),
                    'client'     => get_the_title(),
                    'content' => get_the_excerpt(),
                    'photo'    => get_the_post_thumbnail_url(),
                );

                $testimonials[] = $member_data;
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
