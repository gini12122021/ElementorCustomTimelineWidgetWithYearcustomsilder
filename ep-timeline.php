<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class IC_Timeline extends Widget_Base
{

    public function get_name()
    {
        return 'ic-timeline-widget';
    }

    public function get_title()
    {
        return 'Timeline by IC';
    }

    public function get_icon()
    {
        return 'eicon-time-line';
    }

    public function get_categories()
    {
        return ['basic'];
    }

    public function get_style_depends()
    {
        return array('timeline-slick-bundle', 'timeline-slick-theme', 'timeline-widgets');
    }
    public function get_script_depends()
    {
        return ['timeline-slick-bundle-js', 'timeline-widgets-js'];
    }

    protected function _register_controls()
    {


        $repeater_inner = new \Elementor\Repeater();

        $repeater_inner->add_control(
            'ic_timeline_title',
            [
                'label' => esc_html__('Title', 'ic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater_inner->add_control(
            'ep_timeline_sub_title',
            [
                'label' => esc_html__('Subtitle', 'ic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater_inner->add_control(
            'ep_timeline_list_image',
            [
                'label' => __('Choose Image', 'ic'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'ic_year',
            [
                'label' => __('Year', 'ic'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Year', 'ic'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'inner_list',
            [
                'label' => __('Timeline List', 'ic'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater_inner->get_controls(),
                'default' => [],
                'title_field' => '{{{ ic_timeline_title }}}',
            ]
        );

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('TimeLine', 'ic'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'timelinelist',
            [
                'label' => __('TimeLine List', 'ic'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ ic_year }}}',
            ]
        );

        $this->end_controls_section(); // Ensure this is called to close the section
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if ($settings['timelinelist']) {
            echo '<div class="ic-double-slider">';

            echo '<div class="custom-prev" id="custom-prev"> <svg width="25" height="21" viewBox="0 0 25 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.4335 1.125L22.6259 10.3174M22.6259 10.3174L13.4335 19.5098M22.6259 10.3174L-0.00195312 10.3169"
                stroke="white" stroke-width="2" /> </svg></div>';

            echo '<div class="custom-next" id="custom-next"> <svg width="25" height="21" viewBox="0 0 25 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.4335 1.125L22.6259 10.3174M22.6259 10.3174L13.4335 19.5098M22.6259 10.3174L-0.00195312 10.3169"
                stroke="white" stroke-width="2" /></svg></div>';
            echo '<div class="slider-container">';
            echo '<div class="slider-one" id="slider1">';
            foreach ($settings['timelinelist'] as $item) {
                echo '<div class="slide">';
                echo '<p>' . esc_html($item['ic_year']) . '</p>';
                if (!empty($item['inner_list'])) {
                    echo '<div class="four-column-content">';
                    foreach ($item['inner_list'] as $inner_item) {
                        echo '<div class="column-content"><div class="orange-dot"><span></span></div>';
                        echo '<div class="slider-data">';
                        if (!empty($inner_item['ep_timeline_list_image']['url'])) {
                            echo '<div class="col-img"><img src="' . $inner_item['ep_timeline_list_image']['url'] . '" alt="' . $inner_item['ic_timeline_title'] . '"></div>';
                        }
                        echo '<p>' . esc_html($inner_item['ic_timeline_title']) . '</p> <span>' . esc_html($inner_item['ep_timeline_sub_title']) . '</span></div></div>';
                    }
                    echo '</div>';
                }
                echo '</div>';
            }
            echo '</div><div class="progress-bar"><div class="progress"></div> <!-- Progress Bar --></div>';

            echo '<div class="slider-two" id="slider2">';

            foreach ($settings['timelinelist'] as $item) {

                if (!empty($item['inner_list'])) {
                    echo ' <div class="slider-four-columns"><div class="four-column-content">';
                    foreach ($item['inner_list'] as $inner_item) {

                        echo '<div class="column-content"><div class="orange-dot"><span></span></div>';
                        echo '<div class="slider-data">';

                        if (!empty($inner_item['ep_timeline_list_image']['url'])) {

                            echo '<div class="col-img"><img src="' . $inner_item['ep_timeline_list_image']['url'] . '" alt="' . $inner_item['ic_timeline_title'] . '"></div>';
                        }

                        echo '<p>' . esc_html($inner_item['ic_timeline_title']) . '</p> <span>' . esc_html($inner_item['ep_timeline_sub_title']) . '</span>';
                        echo '</div></div>';
                    }
                    echo '</div></div>';
                }
            }
            echo '</div>';

            echo '</div></div>';
        }
    }

    protected function content_template()
    {
    }
}
