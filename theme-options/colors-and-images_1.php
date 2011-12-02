<?php
/**
 * Theme Colors and Images Settings Functions file
 * 
 * The /theme-options/colors-and-images_0.php file defines
 * the colors and images options for the Theme.
 * 
 * How to use this file:
 * 1) Save this template to the 'theme-options' folder in the Theme root
 * 2) Change the file name to this syntax (remember to add the .php 
 *    extension): tab-name_#.php, where:
 *    - tab-name = Name of the Tab as it will appear in the Admin menu
 *    - # = position tab will appear, relative to other tabs
 * 3) Add options to the $options array
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

$options = array (
            
    array(  "name" => "Theme Color Scheme",
            "desc" => "Select the desired color scheme for your site.",
            "id" => "color_scheme",
            "type" => "select",
            "default_text" => "Light",
            "options" => array(
            	"Dark" => "dark"
            )),
            
	array(  "name" => "Default Hyperlink Color",
            "desc" => "Enter a default hyperlink color here.",
            "id" => "default_link_color",
            "type" => "color"),
            
	array(  "name" => "Hover Hyperlink Color",
            "desc" => "Enter a hover hyperlink color here.",
            "id" => "hover_link_color",
            "type" => "color"),
            
	array(  "name" => "Active Hyperlink Color",
            "desc" => "Enter an active hyperlink color here.",
            "id" => "active_link_color",
            "type" => "color"),
            
	array(  "name" => "Visited Hyperlink Color",
            "desc" => "Enter a visited hyperlink color here.",
            "id" => "visited_link_color",
            "type" => "color"),
            
    array(  "name" => "Content Text Color",
            "desc" => "Enter a color here for the content text.",
            "id" => "content_text_color",
            "type" => "color"),
            
	array(  "name" => "Website Favicon",
            "desc" => "You should upload a small PNG with a size of 16x16.",
            "id" => "favicon",
            "value" => "Upload Favicon",
            "type" => "image")
            
);

/* ------------ Do not edit below this line ----------- */

//Check if theme options set
global $default_check;
global $default_options;

if(!$default_check):
    foreach($options as $option):
        if($option['type'] != 'image'):
            $default_options[$option['id']] = $option['value'];
        else:
            $default_options[$option['id']] = $option['url'];
        endif;
    endforeach;
    $update_option = get_option('up_themes_'.UPTHEMES_SHORT_NAME);
    if(is_array($update_option)):
        $update_option = array_merge($update_option, $default_options);
        update_option('up_themes_'.UPTHEMES_SHORT_NAME, $update_option);
    else:
        update_option('up_themes_'.UPTHEMES_SHORT_NAME, $default_options);
    endif;
endif;

render_options($options);

?>