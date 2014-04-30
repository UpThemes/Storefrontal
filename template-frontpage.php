<?php
/*
Template Name: Homepage
*/
?>
<?php get_header(); ?>

    <?php echo do_shortcode('[slideshow]'); ?>

  <?php if( have_posts() ): while( have_posts() ): the_post(); ?>

    <?php the_content(); ?>

  <?php endwhile; endif; ?>

  <?php get_template_part('woocommerce','loop'); ?>

  <div class="widgets">
    <div class="block-holder">
    	<?php get_sidebar('home-1'); ?>
    </div>
    <div class="block-holder">
    	<?php get_sidebar('home-2'); ?>
    </div>
    <div class="block-holder">
    	<?php get_sidebar('home-3'); ?>
    </div>
  </div>

<?php get_footer(); ?>
