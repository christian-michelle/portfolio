<div class="fullwidth">
  <div class="posts">
    <?php
      $args = array( 
        'post_type' => 'portfolio',
      );

      $the_query = new WP_Query( $args );

      if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

      <div class="post">
        <div class="featured-image">
          <img src="<?php the_field('portfolio_piece_image', get_the_ID()); ?>">
        </div>
        <div class="content">
          <h1><?php the_title(); ?></h1>
          <p><?php the_content(); ?></p>
          <?php if (have_rows('languages_used', get_the_ID())): ?>
            <div class="languages"><b>Languages</b>:
              <?php while (have_rows('languages_used', get_the_ID())): the_row(); ?>
                <?php the_sub_field('language', get_the_ID()); ?>
              <?php endwhile; ?>
            </div>
          <?php endif; ?>
          <?php if (have_rows('tools_used', get_the_ID())): ?>
            <div class="tools"><b>Tools</b>:
              <?php while (have_rows('tools_used', get_the_ID())): the_row(); ?>
                <?php the_sub_field('tool', get_the_ID()); ?>
              <?php endwhile; ?>
            </div>
          <?php endif; ?>
          <?php if (have_rows('plugins_used', get_the_ID())): ?>
            <div class="plugins"><b>Plugins</b>:
              <?php while (have_rows('plugins_used', get_the_ID())): the_row(); ?>
                <?php the_sub_field('plugins', get_the_ID()); ?>
              <?php endwhile; ?>
            </div>
          <?php endif; ?>
          <div class="disclaimer">
            <?php the_field('disclaimer', get_the_ID()); ?>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
    <?php endif;?>
  </div>
</div>