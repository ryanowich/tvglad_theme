<?php
/* Supply logo based on parent */

function tvglad_slideshow($parent) {
		
	switch($parent) {
		case 'front':
			$slideshowblock = module_invoke('views','block_view','slideshow_front-block');
			return tvglad_buildSlides($slideshowblock);
			break;
		case 'tv':
			$slideshowblock = module_invoke('views','block_view','slideshow_tv-block');
			return tvglad_buildSlides($slideshowblock);
			break;
		case 'radio':
			$slideshowblock = module_invoke('views','block_view','slideshow_radio-block');
			return tvglad_buildSlides($slideshowblock);
			break;
		case 'animation':
			$slideshowblock = module_invoke('views','block_view','slideshow_animation-block');
			return tvglad_buildSlides($slideshowblock);
			break;
		case 'production':
			$slideshowblock = module_invoke('views','block_view','slideshow_production-block');
			return tvglad_buildSlides($slideshowblock);
			break;
		default:
			$slideshowblock = NULL;
			return NULL;
			break;
	}
}

function tvglad_buildSlides($slideshowblock) {
	// To-do: Check if slideshow is empty or contains empty children
	return $slideshowblock;
}

// Testing
//echo tvglad_slideshow('animation');
