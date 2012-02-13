<?php
function register_theme_style($args){
    global $up_styles;
    extract($args);
<<<<<<< HEAD
    $context = $context ? $context : 'global';
    if($id && $name && $style && $image):
=======
    if( !isset($context) )
		$context = 'global';
    if(isset($id) && isset($name) && isset($style) && isset($image)):
>>>>>>> e27f2f23c197aebf8f7d797d070ffcc5b23d5a7a
        $up_styles[$id] = $args;
        return true;
    endif;
}

function default_theme_styles(){
    $args = array(
        array(
            'id' => 'light',
            'name' => 'Light',
<<<<<<< HEAD
            'style' => get_bloginfo("template_directory")."/library/styles/light.css",
            'image' => get_bloginfo("template_directory")."/library/styles/light.jpg"),
        array(
            'id' => 'dark',
            'name' => 'Dark',
            'style' => get_bloginfo("template_directory")."/library/styles/dark.css",
            'image' => get_bloginfo("template_directory")."/library/styles/dark.jpg")
    );
=======
            'image' => get_template_directory_uri() . '/images/style/light.jpg'),
        array(
            'id' => 'dark',
            'name' => 'Dark',
            'image' => get_template_directory_uri() . '/images/style/dark.jpg')
            
		);
>>>>>>> e27f2f23c197aebf8f7d797d070ffcc5b23d5a7a
    
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
<<<<<<< HEAD
function enqueue_theme_style(){
    global $up_styles;
    $contexts = get_option('up_themes_'.UPTHEMES_SHORT_NAME.'_styles');
    if(is_array($contexts)):
        $queued = FALSE;
        $global = FALSE;
        foreach($contexts as $context => $style):
            if($context != 'global'):
                if(function_exists('is_'.$context)):
                    if(call_user_func('is_'.$context)):
                        wp_enqueue_style('up-layout-'.$context, $up_styles[$style['id']]['style']);
                        $queued = TRUE;
                    endif;
                endif;
            else:
                $global = TRUE;
            endif;
        endforeach;
        if(!$queued && $global)wp_enqueue_style('up-style-global', $up_styles[$contexts['global']['id']]['style']);
    endif;
}
add_action('wp_print_styles', 'enqueue_theme_style');
=======
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
>>>>>>> e27f2f23c197aebf8f7d797d070ffcc5b23d5a7a
?>