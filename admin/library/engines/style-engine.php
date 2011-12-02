<?php
function register_theme_style($args){
    global $up_styles;
    extract($args);
    if( !isset($context) )
		$context = 'global';
    if(isset($id) && isset($name) && isset($style) && isset($image)):
        $up_styles[$id] = $args;
        return true;
    endif;
}

function default_theme_styles(){
    $args = array(
        array(
            'id' => 'light',
            'name' => 'Light',
            'image' => get_template_directory_uri() . '/images/style/light.jpg'),
        array(
            'id' => 'dark',
            'name' => 'Dark',
            'image' => get_template_directory_uri() . '/images/style/dark.jpg')
            
		);
    
    foreach($args as $arg):
        register_theme_style($arg);
    endforeach;
}

function deregister_theme_style($id){
    global $up_styles;
    if(is_array($up_styles[$id])):
        unset($up_styles[$id]);
        return true;
    endif;
}

/* Enqueue The Style */
function upfw_filter_body_class($classes,$class){
    global $up_styles,$wp_query;
    $contexts = get_option('up_themes_'.UPTHEMES_SHORT_NAME.'_styles');
    if(is_array($contexts)):
        foreach($contexts as $context => $style):
            if($context != 'global'):
                if(function_exists('is_'.$context)):
                    if(call_user_func('is_'.$context))
                        $classes[] = $style['id'];
                endif;
            endif;
        endforeach;
    endif;
    
    return $classes;

}
add_filter('body_class', 'enqueue_theme_style',9999);
?>