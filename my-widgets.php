<?php

class My_Elementor_Widgets
{

    protected static $instance = null;

    public static function get_instance()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    protected function __construct()
    {

        require_once('ep-timeline.php');

        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
    }

    public function register_widgets()
    {

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new \Elementor\IC_Timeline());
    }
}

add_action('init', 'my_elementor_init');
function my_elementor_init()
{
    My_Elementor_Widgets::get_instance();
}

add_action('wp_enqueue_scripts', 'my_elementor_timeline_cssjs');

function my_elementor_timeline_cssjs()
{

    wp_enqueue_style('timeline-slick-bundle', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', array(), rand(1, 100));
    wp_enqueue_style('timeline-slick-theme', 'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css', array(), rand(1, 100));
    wp_enqueue_style('timeline-widgets', trailingslashit(get_stylesheet_directory_uri()) . 'css/timeline-widgets.css', array(), rand(1, 100));

    wp_register_script('timeline-slick-bundle-js',  'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), rand(1, 100), TRUE);
    wp_register_script('timeline-widgets-js', trailingslashit(get_stylesheet_directory_uri()) . 'js/timeline-widgets.js', array('timeline-slick-bundle-js'), rand(1, 100), TRUE);
}
