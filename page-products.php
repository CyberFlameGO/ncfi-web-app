<?php
/*
Template Name: Products Page
*/
?>

<?php get_header(); ?>
<div class="hero">
	<div class="text">
		<h1>America’s foam<br>for over 50 years</h1>
		<h2>Building America with high-performance materials,<br>constant innovation, and legendary customer care.</h2>
	</div>
</div>
<main>
	<div class="text-wrap">
		<h2>NCFI Construction Foam</h2>
		<p>Since 1967, NCFI has been manufacturing spray foam insulation products for residential, agricultural, commercial, institutional, and industrial industries. All of our spray foam insulation systems create extremely energy-efficient, comfortable, and safe environments for home and building owners.</p>
	</div>
	<?php echo do_shortcode('[products category="Construction Foam"]'); ?>
</main>
    

<?php get_footer(); ?>
