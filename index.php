<?php get_header(); ?>

</header>


<section class="articles">
  <div class="subsection">
    <?php 
      if ( have_posts() ) {
        while ( have_posts() ) {
          the_post(); ?>
          <article class="post-preview">
          	<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <time>Posted on <?php the_time('F jS, Y'); ?></time>
          </article>
        <?php } // end while
      } // end if
    ?>
  </div>
</section>

<?php get_footer(); ?>