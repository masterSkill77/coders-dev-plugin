<?php

namespace Coders;

class Coders_TAXONOMIES
{
    public static function register(): void
    {
        add_action('after_setup_theme', [self::class, 'register_taxonomies_team']);
        add_action('after_setup_theme', [self::class, 'register_taxonomies_work']);
    }
    public static function register_taxonomies_team(): void
    {
        register_taxonomy(
            'team-post', // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
            'members', // post type name
            [
                'hierarchical' => true,
                'label' => 'Poste de la personne', // display name
            ]
        );
    }

    public static function register_taxonomies_work(): void
    {
        register_taxonomy(
            'work-categories', // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
            'works', // post type name
            [
                'hierarchical' => true,
                'label' => 'Classification du projet', // display name
            ]
        );
    }
}
