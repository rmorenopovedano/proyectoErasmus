<?php
/**
 * @version   $Id: roksprocket.php 29742 2015-12-28 14:30:26Z jakub $
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2016 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

/**
 *
 */
class RokSprocket_Widgets_RokSprocket extends WP_Widget
{
    /**
     * @var string
     */
    var $short_name = 'roksprocket_options';
    /**
     * @var string
     */
    var $long_name = 'RokSprocket';
    /**
     * @var string
     */
    var $description = 'RocketTheme RokSprocket Widget';
    /**
     * @var string
     */
    var $css_classname = 'roksprocket_options';
    /**
     * @var int
     */
    var $width = 200;
    /**
     * @var int
     */
    var $height = 400;

    /**
     * @var array
     */
    protected static $sprocket_items = array();
    protected static $did_maybe_has_shortcode = false;

    protected $container;

    /**
     *
     */
    function __construct()
    {
        if (empty($this->short_name) || empty($this->long_name)) {
            die("A widget must have a valid type and classname defined");
        }
        $widget_options = array('classname' => $this->css_classname, 'description' => __($this->description));
        $control_options = array('width' => $this->width, 'height' => $this->height);
        parent::__construct($this->short_name, $this->long_name, $widget_options, $control_options);
        $this->container = RokCommon_Service::getContainer();

    }

    /**
     * @return array
     */
    public static function get_defaults()
    {
        $defaults = array(
            'title' => '',
            'module_id' => 0
        );
        add_option('widget_roksprocket_options', $defaults);
        return $defaults;
    }

    /**
     * intilize roksprocket widget
     */
    public static function init()
    {
        global $pagenow;

        if (defined('ROKSPROCKET_ERROR_MISSING_LIBS') && ROKSPROCKET_ERROR_MISSING_LIBS == true) return;
        register_widget("RokSprocket_Widgets_RokSprocket");

        if (is_admin() && $pagenow == 'widgets.php') {
            RokCommon_Header::addScript(RokCommon_Composite::get('rs_admin_assets.js')->getURL('widget.js'));
        }
    }

    /**
     * initialize individual widget instances
     */
    public static function roksprocket_init()
    {
        if (defined('ROKSPROCKET_ERROR_MISSING_LIBS') && ROKSPROCKET_ERROR_MISSING_LIBS == true) return;
        $option = get_option('widget_roksprocket_options');
        $sidebar_widgets = wp_get_sidebars_widgets();

        foreach ($sidebar_widgets as $sidebar => $sidebar_widgets) {
            if ($sidebar != 'wp_inactive_widgets') {
                if ($sidebar_widgets && is_array($sidebar_widgets)) {
                    foreach ($sidebar_widgets as $widget) {
                        if (strpos($widget, 'roksprocket_options-') !== false) {
                            $widget_id = intval(str_replace('roksprocket_options-', '', $widget));
                            $instance = $option[$widget_id];
                            if($instance !== null) {
                                self::prepare_sprocket_items($instance['module_id']);
                            }
                        }
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    public static function get_active_layouts()
    {
        $option = get_option('widget_roksprocket_options');
        $sidebar_widgets = wp_get_sidebars_widgets();
        $layouts = array();

        foreach ($sidebar_widgets as $sidebar => $sidebar_widgets) {
            if ($sidebar != 'wp_inactive_widgets') {
                if ($sidebar_widgets && is_array($sidebar_widgets)) {
                    foreach ($sidebar_widgets as $widget) {
                        if (strpos($widget, 'roksprocket_options-') !== false) {
                            $widget_id = intval(str_replace('roksprocket_options-', '', $widget));
                            $curr_inst = $option[$widget_id];
                            $layouts[] = array(
                                'layout' => $curr_inst['layout'],
                                'style' => $curr_inst['style']
                            );
                        }
                    }
                }
            }
        }
        return $layouts;
    }

    /**
     * @param $new_instance
     * @param $old_instance
     *
     * @return mixed
     */
    function update($new_instance, $old_instance)
    {
        $global_instance = array();
        foreach (self::get_defaults() as $param) {
            if (array_key_exists($param, $new_instance)) {
                $global_instance[$param] = $new_instance[$param];
                unset($new_instance[$param]);
            }
        }
        update_option('widget_roksprocket_options', $global_instance);

        return $new_instance;
    }

    /**
     * @param $instance
     */
    function form($instance)
    {
        global $wpdb;

        $defaults = $this->get_defaults();
        $instance = rs_parse_options((array)$instance, $defaults);
        foreach ($instance as $variable => $value) {
            $$variable = rs_cleanOutputVariable($variable, $value);
            $instance[$variable] = $$variable;
        }
        $instance['id_base'] = $this->id_base;
        $instance['number'] = $this->number;

        /** @var $form RokCommon_Form */
        $form = $this->container->getService('roksprocket.widget.form');
        $form->loadFile(dirname(__FILE__) . '/form.xml');
        $form->bind($instance);
        $form->getNamehandler()->setInstance($instance);
        ob_start();
        echo RokCommon_Composite::get('rs_templates.widget')->load('form.php', array(
            'instance' => $instance,
            'form' => $form
        ));
        echo ob_get_clean();
    }


    /**
     * @param $args
     * @param $instance
     */
    function render($args, $instance)
    {
        //add thickbox
        wp_enqueue_script('jquery');
        wp_enqueue_style('thickbox');
        add_thickbox();

        $instance['widget_id'] = $this->number;

        // Check if the widget is loaded by a Gantry 5 particle
        if(strpos($this->id, 'roksprocket_options--') !== false && !isset(self::$sprocket_items[$instance['module_id']])) {
            self::prepare_sprocket_items($instance['module_id']);
        }

        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );

        ob_start();
        echo $args['before_widget'];
        if ($title != '') {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        $atts = array('id' => $instance['module_id']);
        echo apply_filters('widget_content', self::shortcode_render($atts));

        echo $args['after_widget'];
        echo ob_get_clean();
    }

    /**
     * @param $args
     * @param $instance
     */
    function widget($args, $instance)
    {
        extract($args);
        $defaults = self::get_defaults();
        $instance = wp_parse_args((array)$instance, $defaults);
        foreach ($instance as $variable => $value) {
            $$variable = rs_cleanOutputVariable($variable, $value);
            $instance[$variable] = $$variable;
        }
        $this->render($args, $instance);
    }

    public static function shortcode_render($atts)
    {
        if (isset($atts['id']) && $atts['id'] > 0) {
            $items = self::$sprocket_items;
            if(self::$did_maybe_has_shortcode && (empty($items) || !isset($items[$atts['id']]))) {
                self::prepare_sprocket_items($atts['id']);
                $items = self::$sprocket_items;
            }
            if(isset($items[$atts['id']])) {
                return '<div class="roksprocket-shortcode">' . do_shortcode($items[$atts['id']]) . '</div>';
            }
        }
    }

    public static function maybe_has_shortcode($data) {
        $found_shortcodes = array();

        foreach($data as $post) {
            $found = self::has_sprocket_shortcode($post->post_content, 'roksprocket');
            if($found !== false) {
                $found_shortcodes[] = $found;
            }
        }

        if(!empty($found_shortcodes)) {
            foreach($found_shortcodes as $shortcode_id) {
                if(is_array($shortcode_id)) {
                    foreach($shortcode_id as $short_id) {
                        self::prepare_sprocket_items($short_id);
                    }
                } else {
                    self::prepare_sprocket_items($shortcode_id);
                }
            }
        }

        self::$did_maybe_has_shortcode = true;

        return $data;
    }

    public static function prepare_sprocket_items($sprocket_id = 0) {
        if(!is_admin() && $sprocket_id > 0 && !isset(self::$sprocket_items[$sprocket_id])) {
            $container = RokCommon_Service::getContainer();
            $model = $container->getService('roksprocket.widgets.model');
            $widget_def = $model->getInstanceInfo($sprocket_id);
            if (is_null($widget_def)) return;
            $params = $widget_def->getParams();
            $params->set('module_id', $sprocket_id);
            $widget = new RokSprocket_Wordpress($params);
            $widget->renderGlobalHeaders();
            $items = $widget->getData();
            self::$sprocket_items[$sprocket_id] = $widget->render($items);
        }
    }

    public static function has_sprocket_shortcode( $content, $tag ) {
        if ( false === strpos( $content, '[' ) ) {
            return false;
        }

        if ( shortcode_exists( $tag ) ) {
            preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );
            if ( empty( $matches ) )
                return false;

            $sprocket_ids = array();
            foreach ( $matches as $shortcode ) {
                if ( $tag === $shortcode[2] ) {
                    $sprocket_ids[] = preg_replace("/\\D/uis", '', trim($shortcode[3]));
                }
            }
            if(!empty($sprocket_ids)) return $sprocket_ids;
            return false;
        }
        return false;
    }

    public static function addLanguages()
    {

        $container = RokCommon_Service::getContainer();
        $options = new RokCommon_Options();

        if ($container->hasParameter('roksprocket.template.override.path')) {
            rs_load_plugin_textdomain('wp_roksprocket', ROKSPROCKET_PLUGIN_PATH . '/languages');

            /** @var $i18n RokCommon_I18N_Wordpress */
            $i18n = $container->i18n;
            $i18n->addDomain('wp_roksprocket');
        }

        $section = new RokCommon_Options_Section('roksprocket_module', 'module_config.xml');
        $section->addPath(dirname(__FILE__));
        $section->addPath($container['roksprocket.template.override.path']);
        $options->addSection($section);

        // load up the layouts
        /** @var $i18n RokCommon_I18N_Wordpress */
        $i18n = $container->i18n;
        foreach ($container['roksprocket.layouts'] as $type => $layoutinfo) {
            $section = new RokCommon_Options_Section('layout_' . $type, $layoutinfo->options->file);

            foreach ($layoutinfo->paths as $layoutpath) {
                if (is_dir($layoutpath . '/language')) {
                    rs_load_plugin_textdomain('wp_roksprocket_layout_' . $type, $layoutpath . '/language');
                }
                $section->addPath($layoutpath);
            }
            $options->addSection($section);
            $i18n->addDomain('wp_roksprocket_layout_' . $type);
        }
    }

}

add_shortcode('roksprocket', array('RokSprocket_Widgets_RokSprocket', 'shortcode_render'));
add_filter('the_posts', array('RokSprocket_Widgets_RokSprocket', 'maybe_has_shortcode'));
add_action('widgets_init', array('RokSprocket_Widgets_RokSprocket', 'init'));
add_action('widgets_init', array('RokSprocket_Widgets_RokSprocket', 'roksprocket_init'));
add_action('init', array('RokSprocket_Widgets_RokSprocket', 'addLanguages'), -10);
