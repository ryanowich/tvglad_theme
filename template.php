<?php

// Provide < PHP 5.3 support for the __DIR__ constant.
if (!defined('__DIR__')) {
  define('__DIR__', dirname(__FILE__));
}
/*
require_once __DIR__ . '/includes/bootstrap.inc';
require_once __DIR__ . '/includes/theme.inc';
require_once __DIR__ . '/includes/pager.inc';
require_once __DIR__ . '/includes/form.inc';
require_once __DIR__ . '/includes/admin.inc';
require_once __DIR__ . '/includes/menu.inc';
*/

// Logo change
require_once __DIR__ . '/includes/logo.php';
require_once __DIR__ . '/includes/header.php';

/* My custom stuff */
function tvglad_parentVar(&$vars, $varname) {
	//$vars = &drupal_static(__FUNCTION__, array());
	
	switch($varname) {
		case 'parent':
			global $base_path;
			list(,$path) = explode($base_path, $_SERVER['REQUEST_URI'], 2);
			list($path,) = explode('?', $path, 2);
			$path = rtrim($path, '/');
			// Construct the id name from the path, replacing slashes with dashes.
			$body_id = str_replace('/', '-', $path);
			// Construct the class name from the first part of the path only.
			list($parent,) = explode('/', $path, 2);
			//$parent = $body_class;
			
			//return isset($vars[$varname]) ? $vars[$varname] : NULL;
			//return $parent;
			return array('parent' => $parent, 'bodyID' => $body_id);
			break;
			
		case 'other':
			// page only vars set here;
			
			return 'Testing other...';
			
			break;
	}
	
	
}



/*
 * Here we override the default HTML output of drupal.
 * refer to http://drupal.org/node/550722
 */

// Auto-rebuild the theme registry during theme development.
if (theme_get_setting('clear_registry')) {
	// Rebuild .info data.
	system_rebuild_theme_data();
	// Rebuild theme registry.
	drupal_theme_rebuild();
}
// Add Zen Tabs styles
if (theme_get_setting('tvglad_tabs')) {
	drupal_add_css( drupal_get_path('theme', 'tvglad') . '/css/tabs.css');
}

/* Remove system CSS 
From http://earthviaradio.wordpress.com/2011/05/13/overriding-drupal-7-system-module-css-gracefully/
*/
function tvglad_css_alter(&$css) {
	// Turn off some styles from the system module
	unset($css[drupal_get_path('module', 'system') . '/system.messages.css']);
	unset($css[drupal_get_path('module', 'system') . '/system.menus.css']);
}

/**
 * Preprocesses the wrapping HTML.
 *
 * @param array &$variables
 *	 Template variables.
 */
function tvglad_preprocess_html(&$vars) {

	// From in conjunction with https://gist.github.com/1417914
	// Move JS files "$scripts" to page bottom for perfs/logic.
	// Add JS files that *needs* to be loaded in the head in a new "$head_scripts" scope.
	// For instance the Modernizr lib.
	$path = drupal_get_path('theme', 'tvglad');
	drupal_add_js($path . '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', array('scope' => 'head_scripts', 'weight' => -1, 'preprocess' => FALSE));

	/*
	// From http://bxcollective.com/drupal-7-add-page-and-section-body-classes/ 
	global $base_path;
	list(,$path) = explode($base_path, $_SERVER['REQUEST_URI'], 2);
	list($path,) = explode('?', $path, 2);
	$path = rtrim($path, '/');
	// Construct the id name from the path, replacing slashes with dashes.
	$body_id = str_replace('/', '-', $path);
	// Construct the class name from the first part of the path only.
	list($body_class,) = explode('/', $path, 2);
	// $body_class = $body_class . ' not-front';
	//$body_id = 'page-'. $body_id;
	//$body_id = $body_id;
	//$body_class = 'section-'. $body_class;
	*/
	
	//$parent = $body_class;
	//global $parent;
	
	//$vars['parent'] = tvglad_parentVar($varname, 'parent'); // Set the value and retrieve it
	//$vars['parent'] = tvglad_parentVar($vars, 'parent'); // Get the value
	
	//$body_class = 'childof-'. $body_class;
	//$body_class = 'childof-'. tvglad_parentVar($vars, 'parent');
	
	$parentVars = tvglad_parentVar($vars, 'parent');
	//echo $parentVar[0];  // parent
	//echo $parentVar[1];  // bodyID
	$body_id = $parentVars['bodyID'];
	$body_class = 'childof-'. $parentVars['parent'];
	
	$vars['classes_array'][] = ' ' . $body_id . ' ' . $body_class;

	if (!module_exists('conditional_styles')) {
		tvglad_add_conditional_styles();
	}
	// Setup IE meta tag to force IE rendering mode
	$meta_ie_render_engine = array(
		'#type' => 'html_tag',
		'#tag' => 'meta',
		'#attributes' => array(
			'content' =>	'IE=edge,chrome=1',
			'http-equiv' => 'X-UA-Compatible',
		)
	);
	//	Mobile viewport optimized: h5bp.com/viewport
	$meta_viewport = array(
		'#type' => 'html_tag',
		'#tag' => 'meta',
		'#attributes' => array(
			'content' =>	'width=device-width',
			'name' => 'viewport',
		)
	);

	// Add header meta tag for IE to head
	drupal_add_html_head($meta_ie_render_engine, 'meta_ie_render_engine');
	drupal_add_html_head($meta_viewport, 'meta_viewport');
}

// From in conjunction with https://gist.github.com/1417914
function tvglad_process_html(&$vars) {
	$vars['head_scripts'] = drupal_get_js('head_scripts');
}

function tvglad_preprocess_page(&$vars, $hook) {
	if (isset($vars['node_title'])) {
		$vars['title'] = $vars['node_title'];
	}
	// Adding a class to #page in wireframe mode
	if (theme_get_setting('wireframe_mode')) {
		$vars['classes_array'][] = 'wireframe-mode';
	}
	// Adding classes wether #navigation is here or not
	if (!empty($vars['main_menu']) or !empty($vars['sub_menu'])) {
		$vars['classes_array'][] = 'with-navigation';
	}
	if (!empty($vars['secondary_menu'])) {
		$vars['classes_array'][] = 'with-subnav';
	}

	// From http://highrockmedia.com/blog/theming-multi-level-responsive-menu-drupal-7
	// Primary nav
	$vars['primary_nav'] = FALSE;
	if ($vars['main_menu']) {
		// Build links
		//$vars['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
		$vars['primary_nav'] = menu_tree(variable_get('menu_main_links_source', 'main-menu'));
		//print_r($vars['primary_nav']);
		// Provide default theme wrapper function
		$vars['primary_nav']['#theme_wrappers'] = array('menu_tree__primary');
		//$vars['primary_nav']['#theme_wrappers'] = '';
	}
	
	$parentVars = tvglad_parentVar($vars, 'parent');
	
	$vars['parent'] = $parentVars['parent'];
	$vars['logo'] = tvglad_logo($parentVars['parent']);
	$vars['header'] = tvglad_header($parentVars['parent']);
	
	if (isset($_SERVER['HTTP_REFERER'])) {
		// Use parse_url() to create array
		$uri = parse_url($_SERVER['HTTP_REFERER']);
		//echo '<p>Referrer: ' . $uri['host'] . '</p>';
		if (isset($uri['host'])) {
			$referrer = $uri['host'];
			$vars['referrer'] = $referrer;
			
			if ($referrer == "tv-glad.dev" || $referrer == "tv-glad.dk" || $referrer == "gladmedier.dk") {
				$vars['showslideshow'] = true;
			} else {
				$vars['showslideshow'] = false;
			}
			
		} else {
			// No referrer
		}
	}
}

/* Theme wrapper function for the primary menu links */
function tvglad_menu_tree__primary(&$vars) {
	//return '<ul class="flexnav" data-breakpoint="769">' . $vars['tree'] . '</ul>';
	return '<ul class="navmain">' . $vars['tree'] . '</ul>';
}

function processShortCode($matches){
	//global $uid;
	// parse out the arguments
	$dat= explode(" ", $matches[2]);
	$params = array();
	foreach ($dat as $d){
		list($opt, $val) = explode("=", $d);
		$params[$opt] = trim($val, '"');
	}
	
	switch($matches[1]){
		case "sublimevideo":
			// here is where you would want to return the resultant markup from the shorttag call.
			//return print_r($params, true);
			
			// Calculate new width and height
			if (isset($params['width'])) {
				$oldWidth = $params['width'];
				$oldHeight = $params['height'];
				$videoRatio = $oldHeight/$oldWidth;
				$newWidth = 870;
				$newHeight = $newWidth * $videoRatio;
				$params['width'] = $newWidth;
				$params['height'] = $newHeight;
			}
			
			//$src1='http://video.host.com/_video/H.264/LO/sbx-60025-00-da-ANA.m4v';
			$srcParts = pathinfo($params['src1']);
			$sublimeUID = $srcParts['filename'];
			
			$sublimeHTML5code = '
			<video id="'.$sublimeUID.'" 
				class="sublime" 
				poster="'.$params['poster'].'" 
				width="'.$params['width'].'" height="'.$params['height'].'" 
				title="'.$sublimeUID.'" 
				data-uid="'.$sublimeUID.'" 
				data-autoresize="fit" 
				preload="none">
				
				<source src="'.$params['src1'].'" />
				<source src="'.str_replace("(hd)", "", $params['src2']).'" data-quality="hd" />';
			
			/*
			$sublimeHTML5code .= '
				<source src="'.$params['webm1'].'" />
				<source src="'.str_replace("(hd)", "", $params['webm2']).'" data-quality="hd" />';
			*/
			$sublimeHTML5code .= '
			</video>';
			
			return $sublimeHTML5code;

	}

}
//$sublime_data = preg_replace_callback("/\[(\w+) (.+?)]/", "processShortCode", $sublime_data);
//echo $sublime_data;

function tvglad_preprocess_node(&$vars) {
	// Add a striping class.
	$vars['classes_array'][] = 'node-' . $vars['zebra'];
	
	// Look for [sublimevideo...] shortcode
	$pattern = '/\[sublimevideo(.*?)\]/';
	if (isset($vars['content']['body'][0]['#markup'])) {
		$old_body = $vars['content']['body'][0]['#markup'];
	} else $old_body = NULL;
	if (preg_match_all($pattern, $old_body, $matches)) {
		//echo 'Match was found.';
		//print_r($matches);
		
		// Collect / create / adjust new body content
		$old_body = $vars['content']['body'][0]['#markup'];
		//global $old_body;
		$new_body = preg_replace_callback("/\[(\w+) (.+?)]/", "processShortCode", $old_body);

		// Assign to output
		$vars['content']['body'][0]['#markup'] = $new_body;
		
	} else {
		//echo 'No matches.';
	}
}

function tvglad_preprocess_block(&$vars, $hook) {
	// Add a striping class.
	$vars['classes_array'][] = 'block-' . $vars['zebra'];
}

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *	 An array containing the breadcrumb links.
 * @return
 *	 A string containing the breadcrumb output.
 */
function tvglad_breadcrumb($variables) {
	$breadcrumb = $variables['breadcrumb'];	// Determine if we are to display the breadcrumb.
	$show_breadcrumb = theme_get_setting('tvglad_breadcrumb');
	if ($show_breadcrumb == 'yes' || ($show_breadcrumb == 'admin' && arg(0) == 'admin')) {



		// Optionally get rid of the homepage link.
		$show_breadcrumb_home = theme_get_setting('tvglad_breadcrumb_home');
		if (!$show_breadcrumb_home) {
			array_shift($breadcrumb);
		}
		// Return the breadcrumb with separators.
		if (!empty($breadcrumb)) {
			$breadcrumb_separator = theme_get_setting('tvglad_breadcrumb_separator');
			$trailing_separator = $title = '';
			if (theme_get_setting('tvglad_breadcrumb_title')) {
				$item = menu_get_item();
				if (!empty($item['tab_parent'])) {
					// If we are on a non-default tab, use the tab's title.
					$title = check_plain($item['title']);
				}
				else {
					$title = drupal_get_title();
				}
				if ($title) {
					$trailing_separator = $breadcrumb_separator;
				}
			}
			elseif (theme_get_setting('tvglad_breadcrumb_trailing')) {
				$trailing_separator = $breadcrumb_separator;
			}
			// Provide a navigational heading to give context for breadcrumb links to
			// screen-reader users. Make the heading invisible with .element-invisible.
			$heading = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

			return $heading . '<div class="breadcrumb">' . implode($breadcrumb_separator, $breadcrumb) . $trailing_separator . $title . '</div>';
		}
	}
	// Otherwise, return an empty string.
	return '';
}

/*
 *	 Converts a string to a suitable html ID attribute.
 *
 *		http://www.w3.org/TR/html4/struct/global.html#h-7.5.2 specifies what makes a
 *		valid ID attribute in HTML. This function:
 *
 *	 - Ensure an ID starts with an alpha character by optionally adding an 'n'.
 *	 - Replaces any character except A-Z, numbers, and underscores with dashes.
 *	 - Converts entire string to lowercase.
 *
 *	 @param $string
 *		 The string
 *	 @return
 *		 The converted string
 */


function tvglad_id_safe($string) {
	// Replace with dashes anything that isn't A-Z, numbers, dashes, or underscores.
	$string = strtolower(preg_replace('/[^a-zA-Z0-9_-]+/', '-', $string));
	// If the first character is not a-z, add 'n' in front.
	if (!ctype_lower($string{0})) { // Don't use ctype_alpha since its locale aware.
		$string = 'id' . $string;
	}
	return $string;
}

/**
 * Adds conditional CSS from the .info file.
 *
 * Copy of conditional_styles_preprocess_html().
 */
function tvglad_add_conditional_styles() {
	// Make a list of base themes and the current theme.
	$themes = $GLOBALS['base_theme_info'];
	$themes[] = $GLOBALS['theme_info'];
	foreach (array_keys($themes) as $key) {
		$theme_path = dirname($themes[$key]->filename) . '/';
		if (isset($themes[$key]->info['stylesheets-conditional'])) {
			foreach (array_keys($themes[$key]->info['stylesheets-conditional']) as $condition) {
				foreach (array_keys($themes[$key]->info['stylesheets-conditional'][$condition]) as $media) {
					foreach ($themes[$key]->info['stylesheets-conditional'][$condition][$media] as $stylesheet) {
						// Add each conditional stylesheet.
						drupal_add_css(
							$theme_path . $stylesheet,
							array(
								'group' => CSS_THEME,
								'browsers' => array(
									'IE' => $condition,
									'!IE' => FALSE,
								),
								'every_page' => TRUE,
							)
						);
					}
				}
			}
		}
	}
}


/**
 * Generate the HTML output for a menu link and submenu.
 *
 * @param $variables
 *	 An associative array containing:
 *	 - element: Structured array data for a menu link.
 *
 * @return
 *	 A themed HTML string.
 *
 * @ingroup themeable
 */

function tvglad_menu_link(array $variables) {
	$element = $variables['element'];
	$sub_menu = '';

	//$element['#attributes']['class'][] = 'depth-' . $element['#original_link']['depth'];

	//print_r($element);
	//print_r(array_keys($element));
	//print_r($element['#theme']);
	//print_r($element['#original_link']['depth']);

	if ($element['#below']) {
	//$element['#below'][#attributes][class]
		$sub_menu = drupal_render($element['#below']);
		//$sub_menu = '<h7>' . drupal_render($element['#below']) . '</h7>';
	}
	$output = l($element['#title'], $element['#href'], $element['#localized_options']);
	//$output = l($element['#title'], $element['#localized_options']);
	// Adding a class depending on the TITLE of the link (not constant)
	$element['#attributes']['class'][] = tvglad_id_safe($element['#title']);
	// Adding a class depending on the ID of the link (constant)
	if (isset($element['#original_link']['mlid']) && !empty($element['#original_link']['mlid'])) {
		$element['#attributes']['class'][] = 'mid-' . $element['#original_link']['mlid'];
	}
return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>" . "\n";
	//return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>" . print_r($element['#original_link']['depth']) . "\n";
//return '<li' . drupal_attributes($element['#attributes']) . '>' . t($element['#original_link']['depth']) . $output . $sub_menu . "</li>" . "\n";
	//return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>" . print_r($element['#attributes']['class']) . "\n";
	//return '<li' . drupal_attributes($element['#attributes']) . '>' . '<h3>' . $output . '</h3>' . $sub_menu . "</li>\n";
}

/**
 * Override or insert variables into theme_menu_local_task().
 */

function tvglad_preprocess_menu_local_task(&$variables) {
	$link =& $variables['element']['#link'];
	//$link = '#';

	// If the link does not contain HTML already, check_plain() it now.
	// After we set 'html'=TRUE the link will not be sanitized by l().
	if (empty($link['localized_options']['html'])) {
		$link['title'] = check_plain($link['title']);
	}
	$link['localized_options']['html'] = TRUE;
	$link['title'] = '<span class="tab">' . $link['title'] . '</span>';
}

/*
 *	Duplicate of theme_menu_local_tasks() but adds clearfix to tabs.
 */

function tvglad_menu_local_tasks(&$variables) {
	$output = '';

	if (!empty($variables['primary'])) {
		$variables['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
		$variables['primary']['#prefix'] .= '<ul class="tabs primary clearfix">';
		$variables['primary']['#suffix'] = '</ul>';
		$output .= drupal_render($variables['primary']);
	}
	if (!empty($variables['secondary'])) {
		$variables['secondary']['#prefix'] = '<h2 class="element-invisible">' . t('Secondary tabs') . '</h2>';
		$variables['secondary']['#prefix'] .= '<ul class="tabs secondary clearfix">';
		$variables['secondary']['#suffix'] = '</ul>';
		$output .= drupal_render($variables['secondary']);
	}

	return $output;

}

//tvglad_menu_tree__menu_block__1() < tvglad_menu_tree__menu_block__main_menu() < tvglad_menu_tree__menu_block() < tvglad_menu_tree__main_menu() < tvglad_menu_tree()


function tvglad_menu_tree__main_menu($variables){
	//print_r($variables);
	//print_r($element);
	//print_r($variables['tree']);
	//$element['#attributes']['class'][] = 'depth-' . $element['#original_link']['depth'];
	//print_r($variables['tree']);
	//echo($variables['tree']);
	
//return '<ul class="nav_main">' . $variables['tree'] . '</ul>';
	//return '<ul class="' . $variables['#original_link']['depth'] . '">' . $variables['tree'] . '</ul>';
	//return '<ul class="' . $variables['tree'] . '">' . $variables['tree'] . '</ul>';
	//return '<ul class="' . print_r($variables['tree']) . '">' . $variables['tree'] . '</ul>';
	//return '<ul class="' . $variables[1] . '">' . $variables['tree'] . '</ul>';
	
	//return '<ul class="nav_main">' . $variables['tree'] . '</ul>';
	return '<ul class="nav_sub">' . $variables['tree'] . '</ul>';
	//return '<ul class="menu-"'.$variables["menu-name"].'">'. $variables['tree'] .'</ul>';
}
