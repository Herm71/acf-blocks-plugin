<?php
/**
 * USC Communications & Marketing: Block Patterns
 *
 * @package ucsc-comm
 */

add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {
    register_block_type( __DIR__ . '/blocks/editorial-style-guide' );
}