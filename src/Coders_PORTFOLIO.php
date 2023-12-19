<?php

namespace Coders;

class Coders_PORTFOLIO
{
    public static function handleRequest(\WP_REST_Request $request): \WP_REST_Response
    {
        $args = array(
            'post_type'      => 'works',
            'posts_per_page' => -1,
        );

        $portfoliosQuery = new \WP_Query($args);

        $portfolios = array();

        if ($portfoliosQuery->have_posts()) {
            while ($portfoliosQuery->have_posts()) {
                $portfoliosQuery->the_post();

                // Get custom fields or post data as needed
                $member_data = array(
                    'id'       => get_the_ID(),
                    'title'     => get_the_title(),
                    'link' => get_the_excerpt(),
                    'photo'    => get_the_post_thumbnail_url(),
                    'content'   => get_the_content(),
                    'categories'     => self::get_post_terms_names('work-categories'),
                );

                $portfolios[] = $member_data;
            }

            // Reset post data
            wp_reset_postdata();
        }

        // Create and return JSON response
        $response = new \WP_REST_Response($portfolios, 200);
        $response->set_headers(['Cache-Control' => 'no-cache']);
        $response->set_headers(['Content-Type' => 'application/json']);
        return $response;
    }

    public static function getWorkCategoryTaxonomies(\WP_REST_Request $request): \WP_REST_Response
    {
        $workCategories = get_terms([
            'taxonomy'   => 'work-categories',
            'hide_empty' => false,
        ]);
        $response = new \WP_REST_Response($workCategories, 200);
        $response->set_headers(['Cache-Control' => 'no-cache']);
        $response->set_headers(['Content-Type' => 'application/json']);
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
            return $terms;
        }

        return array();
    }
}
