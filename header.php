<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset='<?php bloginfo('charset') ?>'>
	<?php if (is_search()) { ?>
		<meta name="robots" content="noindex, nofollow">
	<?php }?>
	<meta name="viewport" content="width=device-width">
	<meta property="og:url"           content="<?php echo get_the_permalink(); ?>" />
	<meta property="og:type"          content="website" />
	<meta property="og:title"         content="<?php echo the_title_attribute(); ?>" />
	<meta property="og:description"   content="NCFI Web App" />
	<meta property="og:image"         content="<?php bloginfo('template_url'); ?>/screenshot.png" />

	<title>NCFI Web App</title>

	<?php wp_head(); ?>
</head>

<body id="body" <?php body_class(); ?>>
	<header class="clear">
		<div class="wrapper">
			<a class="logo" href="<?php echo get_site_url() ?>/"><img src="/wp-content/themes/ncfi-v1/images/logo.png" /></a>
			<nav>
				<ul>
						<li><a href="<?php echo get_site_url() ?>/" class="menu-item">Products</a></li>
						<li><a href="<?php echo get_site_url() ?>/about" class="menu-item">About</a></li>
						<li><a href="<?php echo get_site_url() ?>/contact" class="menu-item">Contact</a></li>| 
						<?php
							if (is_user_logged_in()){ ?>
								<li><a href="<?php echo get_site_url() ?>/account" class="menu-item">My Account</a></li>
								<li><a href="<?php echo get_site_url() ?>/cart" class="menu-item">View Cart</a></li>
								<li><a href="<?php echo wp_logout_url(get_permalink()); ?>" class="menu-item">Logout</a></li>
								<?php
							} else{ ?>
								<li><a href="<?php echo wp_login_url( get_permalink() ); ?>" class="menu-item">Login</a></li>
								<?php
							}
						?>
				</ul>
			</nav>
		</div>
	</header>
