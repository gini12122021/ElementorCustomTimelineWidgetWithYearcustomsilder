<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Ep_Youtube_Header extends Widget_Base {

    public function get_script_depends() {
        wp_register_script('elementor-ep-video-header-widget', get_stylesheet_directory_uri() . '/assets/js/elementor-ep-video-header-widget.js', ['jquery'], '1.0.0', true);
        return ['elementor-ep-video-header-widget'];
    }

/*    public function get_style_depends() {
        wp_register_style('elementor-ep-video-header-widget', get_stylesheet_directory_uri() . '/assets/css/elementor-ep-video-header-widget.css', '', '1.0.0', 'all');
        return ['elementor-ep-video-header-widget'];
    }*/

    public function get_name() {
        return 'ep-video-header-widget';
    }

    public function get_title() {
        return 'Video Header Widget by Epsimec';
    }

    public function get_icon() {
        return 'fa fa-play';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_box',
            [
                'label' => __('Box', 'epsimec'),
            ]
        );

        $this->add_control(
            'ep_video_header_title',
            [
                'label' => __('Titel', 'epsimec'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Titel', 'epsimec'),
            ]
        );

        $this->add_control(
            'ep_video_header_title_type',
            [
                'label' => esc_html__('Titel Typ', 'epsimec'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'options' => [
                    'h1' => 'h1',
                    'h2' => 'h2',
                    'h3' => 'h3',
                    'h4' => 'h4',
                    'h5' => 'h5',
                    'h6' => 'h6',
                ],
                'default' => ['h1'],
            ]
        );

        $this->add_control(
            'ep_video_header_text',
            [
                'label' => esc_html__('Text', 'epsimec'),
                'type' => \Elementor\Controls_Manager::WYSIWYG
            ]
        );

        $this->add_control(
            'ep_video_header_link_title',
            [
                'label' => __('Link Titel', 'epsimec'),
                'description' => __('Default: Read more', 'epsimec'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Link Titel', 'epsimec'),
            ]
        );


        $this->add_control(
            'ep_video_header_link',
            [
                'label' => esc_html__('Link', 'epsimec'),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                    'custom_attributes' => '',
                ],
            ]
        );


        $this->end_controls_section();


        $this->start_controls_section(
            'section_video',
            [
                'label' => __('Video', 'epsimec'),
            ]
        );

        /*$this->add_control(
            'ep_video_header_video',
            [
                'label' => __('Video URL', 'epsimec'),
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => __('Video URL', 'epsimec'),
            ]
        );*/

        $this->add_control(
            'ep_video_header_video',
            [
                'label' => esc_html__('Video URL', 'epsimec'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'ep_video_header_image',
            [
                'label' => esc_html__('Startbild wählen', 'epsimec'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        if (!isset($settings['ep_video_header_video'])) {
            echo 'Es muss eine Youtube Video URL eingegeben werden!';
            return false;
        }

        if (!isset($settings['ep_video_header_image']) || empty($settings['ep_video_header_image']['url'])) {
            echo 'Es muss ein alternatives Header Bild eingefügt werden!';
            return false;
        }

        $image = $settings['ep_video_header_image']['id'];
        $size = 'full';
        $image = wp_get_attachment_image(
            $image,
            $size,
            false,
            [
                'srcset' => wp_get_attachment_image_srcset( $image, $size ),
            ]
        );

        $data = [
            'title' => $settings['ep_video_header_title'],
            'title_type' => $settings['ep_video_header_title_type'],
            'text' => $settings['ep_video_header_text'],
            'link' => $settings['ep_video_header_link'],
            'link_title' => $settings['ep_video_header_link_title']
        ];

        echo '
            <div class="ep-elementor-item ep-video-header-wrapper" data-video-url="' . $settings['ep_video_header_video']['url'] . '">
                
               ' . $this->text_container($data) . '
                
                <div class="video-image">
                    ' . $image . '
                </div>
                <video loop="true" autoplay="autoplay" muted></video>
            </div>
        ';
    }

    protected function content_template() {
        ?>


        <?php
    }

    private function text_container($data = null) {

        if (empty($data['title']) && empty($data['text']) && empty($data['link'])) {
            return '';
        }

        $title = '';
        $text = '';
        $link = '';

        if (!empty($data['title'])) {
            $type = 'h1';
            if (!empty($data['title_type'])) {
                $type = $data['title_type'][0];
            }

            $title = '
                <div class="elementor-element elementor-element-4eaec42 exad-sticky-section-no exad-glass-effect-no elementor-widget elementor-widget-heading animated fadeInUp" data-id="4eaec42" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;}" data-widget_type="heading.default">
                   <div class="elementor-widget-container">
                      <' . $type . ' class="elementor-heading-title elementor-size-default">' . $data['title'] . '</' . $type . '>
                   </div>
                </div>
            ';
        }

        if (!empty($data['text'])) {
            $text = '
                <div class="elementor-element elementor-element-3d4e90a exad-sticky-section-no exad-glass-effect-no elementor-widget elementor-widget-text-editor animated fadeInUp" data-id="3d4e90a" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_delay&quot;:100}" data-widget_type="text-editor.default">
                   <div class="elementor-widget-container">
                      <div class="elementor-text-editor elementor-clearfix">
                         ' . $data['text'] . '
                      </div>
                   </div>
                </div>
            ';
        }

        if (!empty($data['link'])) {

            $this->add_link_attributes('ep_video_header_link', $data['link']);
            $link_title = __('Read more', 'epsimec');
            if (!empty($data['link_title'])) {
                $link_title = $data['link_title'];
            }

            $link = '
                <div class="elementor-element elementor-element-e3ff6b5 button-gradient exad-sticky-section-no exad-glass-effect-no elementor-widget elementor-widget-button animated fadeInUp" data-id="e3ff6b5" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_delay&quot;:300}" data-widget_type="button.default">
                   <div class="elementor-widget-container">
                      <div class="elementor-button-wrapper">
                         <a ' . $this->get_render_attribute_string('ep_video_header_link') . ' class="elementor-button-link elementor-button elementor-size-sm" role="button">
                             <span class="elementor-button-content-wrapper">
                             <span class="elementor-button-text">' . $link_title . '</span>
                         </span>
                         </a>
                      </div>
                   </div>
                </div>
            ';
        }


        return '
             <div class="ep-container">
                <div class="ep-row">
                    <div class="ep-col">
                        <div class="elementor-widget-wrap">
                            ' . $title . '                       
                            ' . $text . '
                            ' . $link . '
                         </div>
                    </div>    
                </div>
              </div>
        ';

    }

}
