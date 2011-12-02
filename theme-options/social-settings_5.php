<?php
/**
 * Theme Social Settings Functions file
 * 
 * The /theme-options/social-settings_3.php file defines
 * the social-profile options for the Theme.
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

array(  "name" => "Amazon Storefront URL",
        "desc" => "Enter your Amazon storefront URL for the footer.",
        "id" => "amazon",
        "type" => "text"),
        
array(  "name" => "Yahoo! Storefront URL",
        "desc" => "Enter your Yahoo! storefront URL for the footer.",
        "id" => "yahoo",
        "type" => "text"),
        
array(  "name" => "Facebook Page URL",
        "desc" => "Enter your Facebook page URL for the footer.",
        "id" => "facebook",
        "type" => "text"),
        
array(  "name" => "Twitter Handle",
        "desc" => "Enter your twitter handle for the footer.",
        "id" => "twitter",
        "type" => "text")
        
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