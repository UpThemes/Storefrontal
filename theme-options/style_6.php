<?php

$options = array (

    array(  "name" => "Theme style",
        "desc" => "Please select the style for your site.",
        "id" => "style_global",
        "type" => "styles",
        "value" => "light"),
        
    array(  "name" => "Theme style for Archives",
        "desc" => "Please select the style for your archives.",
        "id" => "style_archive",
        "type" => "styles",
        "context" => "archive",
        "value" => "light"),
    
    array(  "name" => "Theme style for Categories",
        "desc" => "Please select the style for your categories.",
        "id" => "style_category",
        "type" => "styles",
        "context" => "category",
        "value" => "light"),
    
    
    array(  "name" => "Theme style for Pages",
        "desc" => "Please select the style for your pages.",
        "id" => "style_page",
        "type" => "styles",
        "context" => "page",
        "value" => "light"),

    array(  "name" => "Theme style for Posts",
        "desc" => "Please select the style for your posts.",
        "id" => "style_post",
        "type" => "styles",
        "context" => "single",
        "value" => "light"),
        
    array(  "name" => "Theme style for Author Archives",
        "desc" => "Please select the style for your author archives.",
        "id" => "style_author",
        "type" => "styles",
        "context" => "author",
        "value" => "light"),
        
    array(  "name" => "Theme style for Search",
        "desc" => "Please select the style for your search page.",
        "id" => "style_search",
        "type" => "styles",
        "context" => "search",
        "value" => "light"),
        
    array(  "name" => "Theme style for Tag Archives",
        "desc" => "Please select the style for your tag archives.",
        "id" => "style_tag",
        "type" => "styles",
        "context" => "tag",
        "value" => "light")
        

);

render_options($options);
?>