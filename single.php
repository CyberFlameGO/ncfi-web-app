<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
 
get_header(); ?>
    
<section id="read" class="post">

    <?php the_post(); ?>
    <article id="post-<?php the_ID(); ?>" class="p">

        <h1 class="post-title">
            <a href="<?php the_permalink() ?>#read" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
            <?php the_title(); ?>
            </a>
        </h1>
        <time class="circle">
            <div class="top"><?php echo get_the_date('M'); ?></div>
            <div class="bottom"><?php echo  get_the_date('d'); ?></div>
        </time>

        <time class="line"><?php echo get_the_date('F j, Y'); ?></time>
        
        <hr class="fleuron indent">
        <?php if(has_post_thumbnail()){
            ?>
            <figure><?php the_post_thumbnail(); ?></figure>
            <?php
        }
        ?>
        <?php the_content(); ?>

        <hr class="fleuron">

    </article>

</section>
 
<?php get_footer(); ?>