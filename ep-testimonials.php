<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Ep_Testimonials extends Widget_Base {

    public function get_name() {
        return 'ep-testimonials';
    }

    public function get_title() {
        return 'Testimonial Widget by Epsimec';
    }

    public function get_icon() {
        return 'fa fa-quote-right';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_box',
            [
                'label' => __('Testimonials', 'epsimec'),
            ]
        );

        $this->add_control(
            'ep_testimonial_main_title', [
                'label' => esc_html__('Title', 'epsimec'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'ep_testimonial_gallery',
            [
                'label' => esc_html__('Add Badges', 'epsimec'),
                'type' => \Elementor\Controls_Manager::GALLERY,
                'show_label' => false,
                'default' => [],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'ep_testimonial_title', [
                'label' => esc_html__('Title', 'epsimec'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'ep_testimonial_sub_title', [
                'label' => esc_html__('Subtitle', 'epsimec'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'ep_testimonial_content', [
                'label' => esc_html__('Content', 'epsimec'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'ep_testimonial_rating',
            [
                'label' => esc_html__('Rating', 'epsimec'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    '1' => esc_html__('1', 'epsimec'),
                    '1-1/2' => esc_html__('1 1/2', 'epsimec'),
                    '2' => esc_html__('2', 'epsimec'),
                    '2-1/2' => esc_html__('2 1/2', 'epsimec'),
                    '3' => esc_html__('3', 'epsimec'),
                    '3-1/2' => esc_html__('3 1/2', 'epsimec'),
                    '4' => esc_html__('4', 'epsimec'),
                    '4-1/2' => esc_html__('4 1/2', 'epsimec'),
                    '5' => esc_html__('5', 'epsimec'),
                ],
            ]
        );

        $this->add_control(
            'ep_testimonial_list',
            [
                'label' => esc_html__('Testimonial List', 'epsimec'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ ep_testimonial_title }}}',
                'prevent_empty' => false
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();


        $items = '';
        if (!empty($settings['ep_testimonial_list'])) {
            $items .= '<div class="testimonial-items-wrapper">';
            foreach ($settings['ep_testimonial_list'] as $list) {
                $data = [
                    'title' => $list['ep_testimonial_title'] ?? '',
                    'sub_title' => $list['ep_testimonial_sub_title'] ?? '',
                    'text' => $list['ep_testimonial_content'] ?? '',
                    'rating' => $list['ep_testimonial_rating'] ?? '',
                ];
                $items .= $this->list_content($data);
            }
            $items .= '</div>';
        }

        $title = '';
        if ($settings['ep_testimonial_main_title']) {
            $title = '
                    <div class="testimonial-title-wrapper">
                           <div class="icon">
                                ' . file_get_contents(get_stylesheet_directory() . '/assets/images/logo.svg') . '
                            </div>
                           <h2>' . $settings['ep_testimonial_main_title'] . '</h2>
                    </div>
                ';
        }

        $gallery = '';
        if ($settings['ep_testimonial_gallery']) {
            $gallery .= '<div class="testimonial-badges-wrapper">';
            $gallery .= '<div class="container-inner">';
            foreach ($settings['ep_testimonial_gallery'] as $image) {
                $gallery .= '<div class="badge"><img src="' . esc_attr($image['url']) . '"></div>';
            }
            $gallery .= '</div>';
            $gallery .= '</div>';
        }

        echo '
                <div class="ep-elementor-item ep-testimonials">
                    <div class="container-inner">
                        ' . $title . '
                    </div>
                        ' . $gallery . '
                    <div class="container-inner">
                        ' . $items . '
                    </div>
                </div>
            ';


    }

    protected function content_template() {
        ?>

        <?php
    }

    private function list_content($data = null) {

        $title = '';
        if (!empty($data['title'])) {
            $title .= '<h3>' . $data['title'] . '</h3>';
        }

        $sub_title = '';
        if (!empty($data['sub_title'])) {
            $title .= '<div class="sub-title">' . $data['sub_title'] . '</div>';
        }

        $content = '';
        if (!empty($data['text'])) {
            $content .= $data['text'];
        }

        $rating = '';
        if (!empty($data['rating'])) {
            switch ($data['rating']) {
                case '1':
                    $rating = '<i class="fa-sharp fa-star-sharp"></i>';
                    $rating = '<i class="fa-sharp fa-star-sharp"></i>';
                    break;
                case '1-1/2':
                    $rating = '<i class="fa-sharp fa-star-sharp"></i><i class="fa-duotone fa-star-sharp-half"></i>';
                    break;
                case '2':
                    $rating = '<i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i>';
                    break;
                case '2-1/2':
                    $rating = '<i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-duotone fa-star-sharp-half"></i>';
                    break;
                case '3':
                    $rating = '<i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i>';
                    break;
                case '3-1/2':
                    $rating = '<i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-duotone fa-star-sharp-half"></i>';
                    break;
                case '4':
                    $rating = '<i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i>';
                    break;
                case '4-1/2':
                    $rating = '<i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-duotone fa-star-sharp-half"></i>';
                    break;
                case '5':
                    $rating = '<i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i><i class="fa-sharp fa-star-sharp"></i>';
                    break;
            }
        }

        return '
            <div class="testimonial">
                <div class="position-wrapper">
                    <div class="title">
                        ' . $title . '
                        ' . $sub_title . '
                    </div>
                    <div class="text-wrapper">
                        ' . $content . '
                    </div>
                    <div class="stars-wrapper">
                        ' . $rating . '
                    </div>
                </div>
            </div>
        ';
    }

}
