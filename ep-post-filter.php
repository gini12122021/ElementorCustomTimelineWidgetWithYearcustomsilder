<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Ep_Post_Category_Filter extends Widget_Base {

    public function get_script_depends() {
        wp_register_script('elementor-ep-post-categories-filter-widget', get_stylesheet_directory_uri() . '/assets/js/elementor-ep-post-categories-filter-widget.js', ['jquery'], '1.0.0', true);
        return ['elementor-ep-post-categories-filter-widget'];
    }

    public function get_name() {
        return 'ep-post-category-filter';
    }

    public function get_title() {
        return 'Post Kategorie Filter by Epsimec';
    }

    public function get_icon() {
        return 'fa fa-filter';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_box',
            [
                'label' => __('Info', 'epsimec'),
            ]
        );

        $this->add_control(
            'message',
            [
                'label' => esc_html__( 'Nachricht', 'epsimec' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'show_label' => false,
                'default' => 'Hier gibt es nichts zum konfigurieren!'
            ]
        );


        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();
        $cat_html  = '<a href="#all" class="category active" data-filter="*">' . __('All', 'epsimec') . '</a>';
        $categories = get_categories( array(
            'orderby' => 'name',
            'order'   => 'ASC'
        ));

        foreach ($categories as $category) {
            $cat_html .= '<a href="#' . $category->slug . '" class="category" data-filter="' . $category->slug . '">' . $category->name . '</a>';
        }

        echo '
            <div class="ep-elementor-item ep-post-categories-filter-wrapper">
                    <div class="category-filter">
                        ' . $cat_html . '
                    </div> 
            </div>
        ';
    }

    protected function content_template() {
        ?>


        <?php
    }
}
