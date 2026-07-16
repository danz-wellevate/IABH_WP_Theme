<?php 
/**
 * ACF Blocks Registry
 *
 */
    function register_acf_blocks() {
        $block_dirs = glob(__DIR__ . '/*', GLOB_ONLYDIR);

        foreach ($block_dirs as $dir) {
            if (file_exists($dir . '/block.json')) {
                register_block_type($dir);
            }
        }
    }

    function register_layout_category( $categories ) {
        
        array_unshift($categories, [
            'slug'  => 'custom-layout',
            'title' => 'Custom Layout'
        ]);

        return $categories;
    }

    
    if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
        add_filter( 'block_categories_all', 'register_layout_category' );
    } else {
        add_filter( 'block_categories', 'register_layout_category' );
    }

    add_action( 'init', 'register_acf_blocks' );