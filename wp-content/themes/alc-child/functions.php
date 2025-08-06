<?php
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('alc-child-style', get_stylesheet_uri());
}, 20);

add_action('after_setup_theme', function () {
    register_nav_menus([
        'primary' => 'Primary Menu',
    ]);
});

add_action('init', function () {
    register_block_type(__DIR__ . '/block-cta');
});

add_action('enqueue_block_editor_assets', function () {
    wp_enqueue_script(
        'alc-block-editor',
        get_stylesheet_directory_uri() . '/block-cta/edit.js',
        ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components'],
        null,
        true
    );
});
