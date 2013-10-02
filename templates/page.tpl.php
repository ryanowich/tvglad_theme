<script type="text/javascript" id="gladsharedtopbarscript" src="http://www.gladfonden.dk/topbar/js/gladsharedtopbar.min.js"></script>

<div id="wrapper" class="<?php print $classes; ?> wrapper clearfix"<?php print $attributes; ?>>
	<div class="nav_container">
		<div id="logo">
			<a class="logolink" href="/">Glad medier</a>
			<?php print $logo; ?>
		</div>
		
		<?php if ($main_menu): ?>
		<nav id="nav_toplevel">
			<?php print theme('links', array('links' => $main_menu, 'attributes' => array('id' => 'primary', 'class' => array('links', 'clearfix', 'main-menu')))); ?>
		</nav>
		<?php endif; ?>		
		
		<?php if (!empty($primary_nav)): ?>
		<nav id="nav_full">
			<?php print render($primary_nav); ?>
		</nav>
		<?php endif; ?>

	</div>
	
	
	
	
	
	<div id="main" role="main">
		<div id="content">
												
			<?php if ($page['page_header']): ?>
				<header class="header">
				<?php print render($page['page_header']); ?>
				
				<?php
					if ($is_front) {
					// Custom afd. text
					} elseif (!empty($header)) {
						// Get afd. text from inc script
						print $header;
					}					
				?>
				</header>
			<?php endif; ?>
					
			
			
			
			<?php if ($page['content_top']): ?>
			<div id="content_top"><?php print render($page['content_top']) ?></div>
			<?php endif; ?>
			<?php if ($title || $messages || $tabs || $action_links): ?>
			<div id="content-header">

				<?php if (isset($node)): ?>
					<?php
					//print_r(node_type_get_name($node));
					if (node_type_get_name($node) != "Video Master" && node_type_get_name($node) != "Radio Master") { ?>
						<?php if ($title): ?>
							<h1 class="title"><?php print $title; ?></h1>
						<?php endif; 
					}
					?>

					
				<?php endif; ?>
				
				
				<?php print $messages; ?> <?php print render($page['help']); ?>
				<?php if ($tabs): ?>
				<div class="tabs"><?php print render($tabs); ?></div>
				<?php endif; ?>
				<?php if ($action_links): ?>
				<ul class="action-links">
					<?php print render($action_links); ?>
				</ul>
				<?php endif; ?>
				
				<?php if ($page['highlight']): ?>
				<div id="highlight"><?php print render($page['highlight']) ?></div>
				<?php endif; ?>
			</div>
			<!-- /#content-header -->
			<?php endif; ?>
			
			<?php
			if ($page && isset($node) && node_type_get_name($node) == "Video Master") {
				// Page full width + don't show sidebar
				$fullwidthClass = ' columnfullwidth';
			} else {
				$fullwidthClass = '';
			}
			?>
			
			<div id="content-inner" class="inner column center<?php echo $fullwidthClass; ?>">
				<div id="content-area"> <?php print render($page['content']) ?> </div>
				<?php print $feed_icons; ?>
				<?php if ($page['content_bottom']): ?>
				<div id="content_bottom"><?php print render($page['content_bottom']) ?></div>
				<?php endif; ?>
			</div>
			
			
			<aside id="sidebar" class="column sidebar">
				<div id="sidebar-inner" class="inner">
					<?php
					/*
					if (isset($referrer)) {
						//echo 'validURL: ' . request_uri() . '<br />';
						echo '<p>Referrer: ';
						print $referrer;
						//echo $_SERVER['HTTP_REFERER'];
						echo '</p>';
					}
					*/
					?>
					<h2 class="block-title visuallyhidden">Undermenu</h2>
					
					<nav id="subnav">
						<h2>Test:</h2>
						<pre style="font-size:50%;">
						<?php
						print_r($secondary_menu);
						?>
						</pre>
					</nav>
					
					<?php if ($secondary_menu): ?>						
						<nav id="subnav">
							<?php print theme('links', array('links' => $secondary_menu, 'attributes' => array('id' => 'secondary', 'class' => array('links', 'clearfix', 'sub-menu')))); ?>
						</nav>
					<?php endif; ?>
				
					<?php if ($page['sidebar']): ?>
					<?php print render($page['sidebar']); ?>
					<?php endif; ?> <!-- /sidebar -->
				
				</div>
			</aside>
			
		</div>
		<!-- /content-inner /content -->
				
	</div>
	<!-- /main -->
	
</div> <!-- /wrapper -->

<!-- ______________________ FOOTER _______________________ -->
<?php if ($page['footer']): ?>
<div class="footer_container clearfix">
	<footer id="footer"> <?php print render($page['footer']); ?> </footer>
</div>
<!-- /footer -->
<?php endif; ?>
