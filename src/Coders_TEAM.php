<?php

namespace Coders;

class Coders_TEAM
{
    public static function handleRequest(\WP_REST_Request $request): \WP_REST_Response
    {
        $args = array(
            'post_type'      => 'members',
            'posts_per_page' => -1,
        );

        $membersQuery = new \WP_Query($args);

        $members = array();

        if ($membersQuery->have_posts()) {
            while ($membersQuery->have_posts()) {
                $membersQuery->the_post();

                // Get custom fields or post data as needed
                $member_data = array(
                    'id'       => get_the_ID(),
                    'name'     => get_the_title(),
                    'function' => get_the_excerpt(),
                    'photo'    => get_the_post_thumbnail_url(),
                    'editor'   => get_the_content(),
                    'post'     => self::get_post_terms_names('team-post'),
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

    /**
     * Get the term names for a specific post and taxonomy.
     *
     * @param string $taxonomy The taxonomy name.
     *
     * @return array
     */
    private static function get_post_terms_names($taxonomy): array
    {
        $terms = get_the_terms(get_the_ID(), $taxonomy);

        if (!empty($terms) && !is_wp_error($terms)) {
            return wp_list_pluck($terms, 'name');
        }

        return array();
    }
}
