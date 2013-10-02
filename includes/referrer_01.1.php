<?php
$validUrlPath = "animation/aktuelt";

// First check if slideshow should be shown on this page
if (request_uri() == $validUrlPath) {
	//echo checkReferrer();
	return checkReferrer();
}

function checkReferrer() {
	//$_SERVER['HTTP_REFERER'] = "http://tv-glad.dev/animation/om-glad-animation";
	
	// Check if user came from local page and already saw the slideshow
	if (isset($_SERVER['HTTP_REFERER'])) {
		// Use parse_url() to create array
		$uri = parse_url($_SERVER['HTTP_REFERER']);
		if (isset($uri['host'])) {
			$referrer = preg_replace('#^www\.(.+\.)#i', '$1', $uri['host']);
			//echo $referrer . ' ';
		
			if ($referrer == "tv-glad.dev" || $referrer == "tv-glad.dk" || $referrer == "gladmedier.dk") {
				//return 'is local domain';
				return false;
			} else {
				//return 'is not local domain';
				return true;
			}
		
		} else {
			//return 'cant find index in array';
			return true;
		}
	} else {
		// No referrer
		//return 'No HTTP_REFERER';
		return true;
	}
}


function request_uri() {
	return "animation/aktuelt";
}

?>