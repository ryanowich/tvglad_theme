<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>">
	<div class="node-inner">
		<header>			
	
			<?php print $user_picture; ?>
			
			<span class="content_type">Audio Master</span>
				
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
				hide($content['field_titel']);
				hide($content['field_undertitel']);
				hide($content['title']);
				hide($content['comments']);
				hide($content['links']);
			?>
				<h2><?php print render($content['field_titel']); ?></h2>
				<h3><?php print render($content['field_undertitel']); ?></h3>
				
			<?php	
				print render($content);
								
				//print render($content['field_previewimg']);
				//print render($content['field_audio_url_mp3']);
				//print render($content['field_audio_url_ogg']);
				
				//print_r($content);
				
				//echo '<audio src="';
				//print render($content['field_audiourl_mp3']);
				//echo '" preload="auto" />';
				
				if (isset($node->field_audiourl_mp3['und']['0']['value'])) {
					$field_audiourl_mp3 = $node->field_audiourl_mp3['und']['0']['value'];
				}
				if (isset($content['field_audiourl_mp3']['#items']['0']['value'])) {
					$field_audiourl_mp3 = $content['field_audiourl_mp3']['#items']['0']['value'];
				}
				
				if ($page) {
					$preload = 'metadata';
					$autoplay = 'autoplay="autoplay"';
				} else {
					$preload = 'true';
					$autoplay = '';
				}
				
			 ?>
				
				<audio id="" preload="<?php echo $preload; ?>" <?php echo $autoplay; ?>" controls="">
					<?php if (!empty($field_audiourl_mp3)): ?>
						<source type="audio/mpeg" src="<?php echo $field_audiourl_mp3; ?>">
					<? endif;?>
					<?php if (!empty($field_audiourl_ogg)): ?>
						<source type="audio/ogg" src="<?php echo $field_audiourl_ogg; ?>">
					<? endif;?>
					Your browser does not support HTML5 audio.
				</audio>
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