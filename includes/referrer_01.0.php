<?php
// First check if slideshow should be shown on this page
if (request_uri() == "animation/aktuelt") {
	
}

// Check if user came from local page and already saw the slideshow
if (isset($_SERVER['HTTP_REFERER'])) {
	// Use parse_url() to create array
	$uri = parse_url($_SERVER['HTTP_REFERER']);
	if (isset($uri['host'])) {
		$referrer = $uri['host'];
		
		if ($referrer == "tv-glad.dev" || $referrer == "tv-glad.dk" || $referrer == "gladmedier.dk") {
			return false;
		} else {
			return true;
		}
		
	} else {
		// No referrer
		return true;
	}
}
?>