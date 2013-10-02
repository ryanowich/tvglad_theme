<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>">
	<div class="node-inner">
		<header>
			<?php if (!$page): ?>
			<h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
			<?php endif; ?>
	
			<?php print $user_picture; ?>
					
			<span class="content_type">Aktuelt</span>

			<?php if ($display_submitted): ?>
			<div class="date">
				<span class="day"><?php	echo date("j.", $node->created); ?></span>
				<span class="month"><?php echo date("M.", $node->created); ?></span>
				<span class="year"><?php echo date("Y", $node->created); ?></span>
			</div>
			<?php endif; ?>
		</header>
		<div class="content">
			<?php 
				// We hide the comments and links now so that we can render them later.
				hide($content['article_relevance']);
				hide($content['comments']);
				hide($content['links']);
				print render($content);

				//print hide($content['body']);
				//print render($content);
				//print $newbody;
		
				//print_r($content);
		
			 ?>
		</div>
		<?php if (!empty($content['links']['terms']) || !empty($content['links'])): ?>
			<footer>
			<?php if (!empty($content['links']['terms'])): ?>
				<div class="terms"><?php print render($content['links']['terms']); ?></div>
			<?php endif;?>
			
			<?php if (!empty($content['links'])): ?>
				<div class="links"><?php print render($content['links']); ?></div>
			<?php endif; ?>
			</footer>
		<?php endif; ?>
	</div> <!-- /node-inner -->
</article> <!-- /node-->
<?php print render($content['comments']); ?>