<?php
/**
 * Theme Colors and Images Settings Functions file
 * 
 * The /theme-options/colors-and-images.php file defines
 * the colors and images options for the Theme.
 * 
 * How to use this file:
 * 1) Save this template to the 'theme-options' folder in the Theme root
 * 2) Add this line to the top of your functions.php file: 
 *    require_once('theme-options/colors-and-images.php');
 *
 * 3) Add options to the $options array in the same format as shown below.
 * 4) BOOM!
 * 
 * To add additional options, add arrays to the $options
 * array, with each new array containing the following
 * array keys:
 * - key 	name	string	(required)	option name
 * - key	desc	string	(required)	option description
 * - key	id		string	(required)	option slug
 * - key	type	string	(required)	option type; one of: text, color, image, select, multiple, textarea, page, pages, category, categories
 * - key	value	string	(required)	default option value, replaced when custom value is entered (text, color, select, textarea, page, category)
 * - key	options	array	(optional)	associative array of valid options for select-type options, in the form of "Name" => "slug"
 * - key	attr	array	(optional)	form-field attributes
 * - keys	url		string	(optional)	default-image URL, for image-type options
 * 
 * @package 	Micro
 * @copyright	Copyright (c) 2011, UpThemes
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU General Public License, v2 (or newer)
 *
 * @since 		Micro 1.0
 */

$thistab = array(
	"name" => "colors_and_images",
	"title" => __("Colors and Images","upfw"),
	'sections' => array(
		'color_scheme' => array(
			'name' => 'color_scheme',
			'title' => __( 'Color Scheme', 'upfw' ),
			'description' => __( 'Select your color scheme.','upfw' )
		)
	)
);

$options = array(
	'theme_color_scheme' => array(
		'tab' => $thistab['name'],
		"name" => "theme_color_scheme",
		"title" => "Theme Color Scheme",
		'description' => __( 'Display header navigation menu above or below the site title/description?', 'storefrontal' ),
		'section' => 'color_scheme',
		'since' => '1.0',
	    "id" => "color_scheme",
	    "type" => "select",
	    "default" => "light",
	    "valid_options" => array(
	    	'light' => array(
	    		"name" => "light",
	    		"title" => __( 'Light', 'storefrontal' )
	    	),
	    	'dark' => array(
	    		"name" => "dark",
	    		"title" => __( 'Dark', 'storefrontal' )
	    	)
	    )
	),
	'custom_footer_logo' => array(
		'tab' => $thistab['name'],
		"name" => "custom_footer_logo",
		"title" => "Custom Footer Logo",
		'description' => __( 'A custom footer logo for your theme.', 'storefrontal' ),
		'section' => 'color_scheme',
		'since' => '1.0',
	    "id" => "color_scheme",
	    "type" => "image"
	)
);

register_theme_options($options);
register_theme_option_tab($thistab);

?>