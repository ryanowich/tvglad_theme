<?php
/* Supply logo based on parent */

function tvglad_header($parent) {
		
	switch($parent) {
		case 'medier':
			//return array('parent' => $parent, 'bodyID' => $body_id);
			$headerTxt = 'Glad Medier';
			return tvglad_buildHeader($headerTxt);
			break;
		case 'tv':
			$headerTxt = 'TV Glad';
			return tvglad_buildHeader($headerTxt);
			break;
		case 'radio':
			$headerTxt = 'Glad Radio';
			return tvglad_buildHeader($headerTxt);
			break;
		case 'animation':
			$headerTxt = 'Glad Animation';
			return tvglad_buildHeader($headerTxt);
			break;
		case 'production':
			$headerTxt = 'Glad Production';
			return tvglad_buildHeader($headerTxt);
			break;
		/*
		default:
			$headerTxt = 'TV Glad';
			return tvglad_buildHeader($headerTxt);
			break;
		*/
	}
}

function tvglad_buildHeader($headerTxt) {
	//$titleClass = "title";
	$titleClass = "headerbox";
	return '<h1 class="'.$titleClass.'">'.$headerTxt.'</h1>';
}

// Testing
//echo tvglad_header('animation');
