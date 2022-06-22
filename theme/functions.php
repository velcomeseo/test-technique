<?php add_theme_support('custom-logo');
include('theme_options.php');

function themename_custom_logo_setup(){
    $defaults = array(
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'airdecom', 'site-airdecom'),
    );
    add_theme_support( 'custom-logo', $defaults );
}

add_theme_support( 'post-thumbnails' );

add_action( 'after_setup_theme', 'themename_custom_logo_setup');

register_nav_menus(array(
    'header' => 'Header',
    'footer' => 'Footer',
));

function mail_alert($type, $args){
	$postData = array();
	$mess = "";
	foreach ($args as $key => $value) {
	  $postData[htmlentities($key)] = htmlentities($value);
	  $mess .= '<p>'.htmlentities($key)." : ".$postData[htmlentities($key)]."\r\n</p>";
	}
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/html; charset=utf-8';
	$headers[] = 'From: '.get_bloginfo('name').' <noreply@illico-demenagements.fr>';
	mail(
	  get_option('email'),
	  "Nouvelle demande de ". $type ." sur le site ".get_bloginfo('name')." de ". $args["prenom"] . " " . $args["nom"],
	  $mess,
	  implode("\r\n", $headers)
	);
}

function bread_crumb() {
	//génère le fil d'Ariane
	if (!is_front_page()) :
		$o = 1;
		ob_start(); //c'est parti wouhou
		?>
		<ol itemscope itemtype="http://schema.org/BreadcrumbList" class="pelote">
				<li  itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<a itemscope itemtype="http://schema.org/WebPage" itemprop="item" href="/" itemid="<?php echo bloginfo('url');?>">
					<span itemprop="name"><?php echo bloginfo('name');?></span> </a>
					<meta itemprop="position" content="<?php echo $o; $o++; ?>" />
				</li>

			<?php

			//si la page a des parents
			if (get_post_ancestors(get_the_ID())) {
				for($i=count(get_post_ancestors(get_the_ID()))-1; $i>=0; $i--) {
					$ancetre = get_post_ancestors(get_the_ID())[$i];
					?>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<span class="ib"> / </span>
					<a itemprop="item" href="<?php echo get_permalink($ancetre);?>" itemtype="http://schema.org/WebPage" itemid="<?php echo get_permalink($ancetre);?>">
					<span itemprop="name"> <?php echo get_the_title($ancetre);?> </span>
					<meta itemprop="position" content="<?php echo $o; $o++;?>" /> </a>
					</li>

						<?php
				}
			}

			/*
			Si la page n'a pas de parent, mais que l'on veut rajouter une étape
			Il faut rajouter un array dans $types et y renseigner :
				name: 		le type du post

				condition:	une fonction qui permet de changer l'affichage si
							nécessaire, par exemple lorsqu'on veut afficher
							deux étapes différentes pour un même type (en
							fonction d'ACF notamment)

				slug:		slug de l'étape

				span:		nom de l'étape
			*/
			$types = array(
				// array(
				// 	'name' => 'centre',
				// 	'condition' => function($id) {return true;},
				// 	'slug' => '/notre-ecole',
				// 	'span' => ' Notre école '
				// ),
			);

			//récupère le type du post et son id
			$current_type = get_post_type();
			$current_id = get_the_ID();

			foreach ($types as $type) {

				//vérifie si c'est le bon type de post, et que la condition est valide
				if ($current_type === $type['name'] && $type['condition']($current_id)) { ?>
					<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					<span class="ib"> / </span>
					<a itemprop="item" href="<?php echo $type['slug'] ?>" itemtype="http://schema.org/WebPage" itemid="<?php echo $type['slug'] ?>">
					<span itemprop="name"><?php echo $type['span'] ?></span>
					<meta itemprop="position" content="<?php echo $o; $o++;?>">
					</li>

				<?php break;}
			}

			//Ajout du lien actuel

			?>
			<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
            <span class="ib"> / </span>
			<a itemscope itemtype="http://schema.org/WebPage" itemprop="item" href="<?php the_permalink(); ?>">
				<span itemprop="name"><?php the_title() ?></span></a>
				<meta itemprop="position" content="<?php echo $o; $o++; ?>" />

			</li>

		</ol>

		<?php
			echo ob_get_clean();
	endif;
	}

	add_filter('xmlrpc_enabled', '__return_false');

	// Sanitizing content render
	function sanitizeContent($content) {    
		$text = preg_replace("/\r|\n/", "", $content);
		$text = str_replace(array('&nbsp;'), ' ', $text);
		return $text;
	}

	add_filter ('the_content', 'sanitizeContent');

	add_theme_support('align-wide');

?>
