<?php

namespace Coders;

class Coders_CPT
{
    public static array $custom_post_types = [
        // 'services',
        'news',
        'works',
        'testimonials',
        'clients',
        'members',
    ];
    public static function register(): void
    {
        add_action('init', [Coders_CPT::class, 'initiate_cpt']);
    }
    public static function initiate_cpt(): void
    {
        $supports = ['title', 'editor', 'thumbnail', 'excerpt', 'author'];

        foreach (Coders_CPT::$custom_post_types as $custom_post_type) {
            $labels = [
                'name' => _x(ucfirst($custom_post_type), 'plural'),
                'singular_name' => _x($custom_post_type, 'singular'),
                'menu_name' => _x(ucfirst($custom_post_type), 'admin menu'),
                'name_admin_bar' => _x(ucfirst($custom_post_type), 'admin bar'),
                'add_new' => _x('Add New', 'add new'),
                'add_new_item' => __("Add New $custom_post_type"),
                'new_item' => __("New $custom_post_type"),
                'edit_item' => __("Edit $custom_post_type"),
                'view_item' => __("View $custom_post_type"),
                'all_items' => __("All $custom_post_type"),
                'search_items' => __("Search $custom_post_type"),
                'not_found' => __("No $custom_post_type found."),
            ];

            $args = [
                'supports' => $supports,
                'labels' => $labels,
                'public' => true,
                'query_var' => true,
                'rewrite' => ['slug' => rtrim($custom_post_type, 's')],
                'has_archive' => true,
                'hierarchical' => false,
            ];
            register_post_type($custom_post_type, $args);
        }
    }
}
