<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>">
	<div class="node-inner">
		<header>	
			<?php //print $user_picture; ?>
		</header>
		<div class="content">
			
			<?php 
				// We hide the comments and links now so that we can render them later.
				hide($content['comments']);
				hide($content['links']);
				
				//print render($content);
				//print_r($node);
			 ?>
			
			<?php
			if (!$page) {
				
				if (isset($node->field_previewurl['und']['0']['value'])) {
					$previewIMG = $node->field_previewurl['und']['0']['value'];
					//$backGroundImageStyle = 'style="background:url(' . $previewIMG . ') no-repeat 0 0;";';
				} else {
					$previewIMG = '/sites/default/files/videopreviews/no_preview.png';
				}
				?>
				<a href="<?php echo $node_url; ?>">
					<div class="video_container">
						<img class="fullwidth" src="<?php echo $previewIMG ?>">

							<div class="videoinfo bottom">
			
								<span class="field-label">Ny video:&nbsp;</span>
								<?php if ($display_submitted): ?>
									<div class="date">
										<span class="day"><?php	echo date("j.", $node->created); ?></span>
										<span class="month"><?php echo date("M.", $node->created); ?></span>
										<span class="year"><?php echo date("Y", $node->created); ?></span>
									</div>
								<?php endif; ?>
							
								<?php
								// Titel
								echo '<a href="' . $node_url . '">';
								if (isset($node->field_titel['und']['0']['value'])) {
									echo '<h2>' . $node->field_titel['und']['0']['value'] . '</h2>';
								}
								// Undertitel
								if (isset($node->field_undertitel['und']['0']['value'])) {
									echo '<h3>' . $node->field_undertitel['und']['0']['value'] . '</h3>';
								}
								echo '</a>';
			
								# Show video stuff
								/*
								if (isset($node->body['und']['0']['value'])) {
									echo '<p>' . $node->body['und']['0']['value'] . '</p>';
								}*/
								?>
								<p>
								<?php
								//print render($content['field_kategori']);
								/*
								if (!empty($content['field_tags'])) {
									print render($content['field_tags']);
								}*/
								//print render($content['field_afd_city']);
								?>
								</p>

								<!-- Hide Read more & Add new comment
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
								-->
							</div> <!-- /videoinfo_bottom -->
					</div> <!-- /video_container -->
				</a>
			<!--</div>--> <!-- /content -->
			<?php
			}
			
			if ($page) {
				# Build HTML5 video
				if (isset($content['field_previewurl']['#items']['0']['value'])) {
					$previewIMG = $content['field_previewurl']['#items']['0']['value'];
				} else {
					$previewIMG = '/sites/default/files/video_previews/no_preview.png';
				}
				
				$videoDisplay = '
				<video 
					id="' . $content['field_uid']['#items']['0']['value']. '" 
					class="sublime" 
					poster="' . $previewIMG . '" 
					width="870" height="490" 
					title="' . $content['field_titel_kombi']['#items']['0']['value']. '" 
					data-uid="' . $content['field_uid']['#items']['0']['value']. '" 
					data-autoresize="fit" preload="none">';
			
				// field_checkvideo_h264_lo
				if (isset($content['field_checkvideo_h264_lo']['#items']['0']['value']) && $content['field_checkvideo_h264_lo']['#items']['0']['value'] == 1) {
					$videoDisplay .= '<source src="' . $content['field_videourl_h264_lo']['#items']['0']['value']. '" />';
				}
			
				// field_checkvideo_h264_hi
				if (isset($content['field_checkvideo_h264_hi']['#items']['0']['value']) && $content['field_checkvideo_h264_hi']['#items']['0']['value'] == 1) {
					$videoDisplay .= '<source src="' . $content['field_videourl_h264_hi']['#items']['0']['value']. '" data-quality="hd" />';
				}
			
				// field_checkvideo_webm_lo
				if (isset($content['field_checkvideo_webm_lo']['#items']['0']['value']) && $content['field_checkvideo_webm_lo']['#items']['0']['value'] == 1) {
					$videoDisplay .= '<source src="' . $content['field_videourl_webm_lo']['#items']['0']['value']. '" />';
				}
			
				// field_checkvideo_webm_hi
				if (isset($content['field_checkvideo_webm_hi']['#items']['0']['value']) && $content['field_checkvideo_webm_hi']['#items']['0']['value'] == 1) {
					$videoDisplay .= '<source src="' . $content['field_videourl_webm_hi']['#items']['0']['value']. '" data-quality="hd" />';
				}
			
				$videoDisplay .= '</video>';
				
				echo $videoDisplay;
				
				echo '<br />';
				
				// Titel
				if (isset($content['field_titel']['#items']['0']['value'])) {
					echo '<h2>' . $content['field_titel']['#items']['0']['value'] . '</h2>';
				}
				// Undertitel
				if (isset($content['field_undertitel']['#items']['0']['value'])) {
					echo '<h3>' . $content['field_undertitel']['#items']['0']['value'] . '</h3>';
				}
				
				# Show video stuff
				//echo $content['body']['#items']['0']['value'];
				//echo $content['field_afdeling']['#items']['0']['value'];
				//echo $content['field_kategori']['#items']['0']['value'];
				//$content['field_tags']['#items']['0']['value'];
				//$content['field_duration']['#items']['0']['value'];
				
				print render($content['body']);
				echo '<br />';
				print render($content['field_duration']);
				//print render($content['field_afdeling']);
				print render($content['field_afd_city']);
				//print render($content['field_afdeling_full']);
				print render($content['field_kategori']);
				print render($content['field_tags']);
				
				//echo 'Testing:';
				//print_r($content['field_duration']);
				//dsm($node);
				//dsm($content);
				//print_r($node);
				
				//print render($content);
			?>
			
				
				<?php if ($display_submitted): ?>
					<div class="field">
						<div class="field-label">Dato:&nbsp;</div>
					</div>
					<div class="date">
						<span class="day"><?php	echo date("j.", $node->created); ?></span>
						<span class="month"><?php echo date("M.", $node->created); ?></span>
						<span class="year"><?php echo date("Y", $node->created); ?></span>
					</div>
				<?php endif; ?>
			
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
			<?php
			}
			?>

			<?php
			//echo '<hr />';
			//print render($content);
			?>
			
			<?php //echo '<pre>' . print_r($node) . '</pre>'; ?>
			
			</div>
		
	</div> <!-- /node-inner -->
</article> <!-- /node-->
<?php print render($content['comments']); ?>