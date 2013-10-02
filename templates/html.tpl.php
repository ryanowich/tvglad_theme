<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>> <!--<![endif]-->
  <head>
    <?php print $head; ?>
    <title><?php print $head_title; ?></title>
	
	<link rel="apple-touch-icon" href="/img/favicon/apple-touch-icon.png">
	<link rel="icon" href="/img/favicon/favicon.png">
	<!--[if IE]><link rel="shortcut icon" href="/img/favicon/favicon.ico"><![endif]-->
	
    <?php print $styles; ?>
	
	<script type="text/javascript" src="//cdn.sublimevideo.net/js/mb9dfwz2.js"></script>
	
	<!--<script src="http://www.tvglad.dk/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
	
	<?php print $head_scripts; ?>
  </head>
  <body class="<?php print $classes; ?>" <?php print $attributes;?>>
    <!--[if lt IE 7]>
      <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
    <div id="skip">
		<a href="#main-menu"><?php print t('Jump to Navigation'); ?></a>
    </div>
	
    <?php print $page_top; ?>
    <?php print $page; ?>
    <?php print $page_bottom; ?>
	
	<?php print $scripts; ?>
	
  </body>
</html>