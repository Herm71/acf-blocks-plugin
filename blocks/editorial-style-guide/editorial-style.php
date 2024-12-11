<?php
/**
 * Editorial Styles Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'editorial-style-block';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}

// Load values and assign defaults.
// $azPost = get_post();
// $azTitle = isset ($azPost->post_title) ? $azPost-> $azPost->post_title: '';
// $azRow = (if $azPost ( have_rows('style_definitions') )):while( have_rows('style_definitions') ): the_row();


 echo '<article class="post type-post status-publish entry">';
    echo '<div class="entry-content" itemprop="text">';
      
    if( have_rows('style_definitions') ):while( have_rows('style_definitions') ): the_row();
    // vars
    $azItem = get_sub_field('editorial_style_item');
    $azDef = get_sub_field('editorial_style_definition');
    

    echo '<p><b>'.$azItem.':</b></p>'.$azDef.'<hr>';
  endwhile;
endif;
  
   echo '</div>';
   echo '</article>'; 
?>
<div <?php echo $anchor; ?>class="<?php echo esc_attr( $class_name ); ?>" style="<?php echo esc_attr( $style ); ?>">
    <p>This is the front-end of the block</p>
</div>