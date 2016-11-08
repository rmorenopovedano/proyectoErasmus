<?php
/*
Plugin Name: Column Posts
Plugin URI: http://boroniatechnologies.com/column-posts/
Description: Display the posts in columns organized by posts or categories.
Version: 1.4
Author: Catherine Lebastard
Author URI: http://boroniatechnologies.com
Text Domain: cp
Domain Path: /languages/
License: GPLv2 or later
*/
/*
    Copyright (c) 2012 - 2016 Catherine Lebastard (email: clebastard@boroniatechnologies.com)

    This program is free software; you can redistribute it and/or modify it under 
    the terms of the GNU General Public License as published by the Free Software 
    Foundation; either version 3 of the License, or (at your option) any later 
    version.

    This program is distributed in the hope that it will be useful, but WITHOUT 
    ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS 
    FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with 
    this program. If not, see <http://www.gnu.org/licenses/>.
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if( !class_exists('ColumnPosts') ) :
/*
 * ColumnPosts Class
 */
class ColumnPosts{
	/** Version ************************************************************************/
	public $version = '1.4';

	// Paths
	/** Basename of the Column Posts plugin ************************************/
	public $basename = '';

	/** Absolute path to the Column Posts plugin *******************************/
	public $plugin_dir = '';

	/** URL to the Column Posts directory **************************************/
	public $plugin_url = '';
	
	/** Path to the Column Posts language directory ****************************/
	public $lang_dir = '';
	
	/** Path to the Column Posts script directory ******************************/
	public $script_dir = '';

	/** Path to the Column Posts css directory *********************************/
	public $css_dir = '';
	
    public function __construct()
    {
		$this->setup_globals();
		$this->includes();
		$this->setup_actions();
    }

	private function setup_globals(){
		// Paths
		$this->file          = __FILE__;
		$this->basename      = plugin_basename( $this->file );
		$this->plugin_dir    = plugin_dir_path( $this->file );
		$this->plugin_url    = plugin_dir_url( $this->file );
		$this->lang_dir      = basename(dirname( $this->basename)) .'/languages';
		$this->script_dir    = $this->plugin_url .'js';
		$this->css_dir    = $this->plugin_url .'css';
	}

	private function includes(){		
		require( $this->plugin_dir . 'includes/widget.php'       ); // ColumnPost widget

		/** Admin *************************************************************/

		// Quick admin check and load if needed
		if ( is_admin() ) require( $this->plugin_dir . 'includes/admin.php' ); // Admin options
	}
	
	private function setup_actions(){
		//admin
		if ( is_admin() ) ColumnPost_admin();	
	
		// register text domain
		load_plugin_textdomain('cp', false, $this->lang_dir);

		//Widget
		add_action( 'widgets_init', array( 'ColumnPost_Widget', 'register_widget') );
		
		// add css to the front end page
		add_filter('wp_print_styles', array($this, 'cp_frontstyle'), 10);

		// add the code to be used in the template files 
		add_action('columnpost', array($this, 'cp_print_frontend'));

		// Shortcode
		add_shortcode('columnpost', array($this, 'cp_shortcode'));

		// create the widget
		//add_action( 'widgets_init', array($this, 'cp_widget_init') );		
	}

	function cp_widget_init()
	{
		if (class_exists('ColumnPosts_widget'))
			register_widget('ColumnPosts_widget');
	}

	function cp_print_frontend()
	{
		echo $this->cp_frontend();
	}

	function cp_shortcode($atts){
		extract(shortcode_atts(array(
		'cat_inc'=>'', 'cat_exc'=>''),$atts));
		return $this->cp_frontend($cat_inc, $cat_exc);
	}
	
	function cp_frontend($include='', $exclude='')
	{				
		// retrieve CP options
		$options 	  = get_option('cp_options');
		$cp_excerpt  = $options['excerpt'];  // where to print excerpts
		$cp_order    = $options['order'];    // category ordering: id, name or custom
		$cp_porder    = $options['porder'];    // post ordering: title or date		
		if (strlen($include) == 0) $cp_include  = trim($options['include']);  // list only these categories	
		else $cp_include = $include;
		if (strlen($exclude) == 0) $cp_exclude  = trim($options['exclude']);  // doesn't list only these categories	
		else $cp_exclude = $exclude;		
		$cp_column   = $options['column'];   // number of columns
		$cp_class    = $options['class'];    // column classification
		$cp_thumb    = $options['thumb'];    // display thumbnail
		$cp_tsize	  = $options['tsize'];	  // setup thumbnail size
		$cp_catcolor = $options['catcolor']; // setup category font color
		$cp_headcolor= $options['headcolor'];// setup headline font color
		$cp_headsize = $options['headsize']; // setup headline font size
		$cp_exccolor = $options['exccolor']; // setup excerpt font color
		$cp_excsize  = $options['excsize'];  // setup excerpt font size
		$cp_famfont  = $options['famfont'];  // setup font family		

		// display the styling
		$jscript = '
		<script type="text/javascript">

		jQuery(document).ready(function($){
			$(".alignthumb").width("' .$cp_tsize .'px");
			$(".alignthumb").height("auto");';

		if (strlen($cp_catcolor) != 0) {
			$jscript = $jscript .'
			$("#cp-box h3").css("color","' .$cp_catcolor .'");';
		}
		if (strlen($cp_headcolor) != 0) {
			$jscript = $jscript .'
			$("#cp-box .cp-box ul li a").css("color","' .$cp_headcolor .'");';
		}
		if (strlen($cp_headsize) != 0) {
			$jscript = $jscript .'
			$("#cp-box .cp-box ul li a").css("font-size","' .$cp_headsize .'px");';
		}
		if ($cp_excerpt == true){
			if (strlen($cp_exccolor) != 0) {
			$jscript = $jscript .'
			$("#cp-box .cp-box ul li p").css("color","' .$cp_exccolor .'");';
			}
			if (strlen($cp_excsize) != 0) {
			$jscript = $jscript .'
			$("#cp-box .cp-box ul li p").css("font-size","' .$cp_excsize .'px");';
			}
		}
		if (strlen($cp_famfont) != 0){
			$jscript = $jscript .'
			$("#cp-box").css("font-family","' .$cp_famfont .'");';
		}
		if (($cp_thumb == true) && ($options['tborder'] == true)) {
			$jscript = $jscript .'
			$("#cp-box img.alignthumb").css("border","1px solid #cccccc");';
		}
		if ($options['lstyle'] == false) {
			$jscript = $jscript .'
			$("#cp-box .cp-box > ul").css("margin-left","0");
			$("#cp-box .cp-box > ul").css("list-style","none");';
		}

		// setup number of columns
		switch ( $options['column'] ) { 
			case 1: $cp_column_txt = "one"; break;
			case 3: $cp_column_txt = "three"; break;
			default: $cp_column_txt = "two";
		}

		// custom or other category ordering
		if ( $cp_order == "custom" ) { // custom
			$custom_order = split(",", $cp_include);
			foreach ( $custom_order as $custom_order_cat_ID ) {
				$custom_order_cat_object = get_categories('include='.$custom_order_cat_ID);
				$custom_order_cat[] = $custom_order_cat_object[0];
			}
			$cats = $custom_order_cat;
		} else { // by cat_ID or name
			$cats = get_categories('orderby='.$cp_order.'&include='.$cp_include.'&exclude='.$cp_exclude);
		} // end if

		// print the CP section
		$cp_str .= '
		<!-- start of Column Posts ' .$this->version . ' ' .$this->lang_dir  .' -->
		'. $jscript .'
		});

		</script>
		<div id="cp-box">
		';
		
		if ($cp_porder == 'date') $typeorder = "DSC";
		else $typeorder = "ASC";

		$col_cat = 0;
		foreach ($cats as $cat) {
			// get non-empty categories
			if ( $cat->count > 0 ) {
				// set the array to retrieve the posts
				$args = array(
					'numberposts' => $options['nposts'],
					'order' => $typeorder,
					'orderby' => $cp_porder,
					'category' => $cat->cat_ID
				);
				if ($options['nosticky'] == true) $args['post__not_in'] = get_option("sticky_posts");
				if ($options['onlythumb'] == true) $args['meta_key'] = "_thumbnail_id";
				$posts = get_posts( $args );
				$tot_posts = $this->get_nposts_by_cat($posts, $cat->cat_ID);
			
				$numposts = 0;
				$ncol = 1;
				$col_cnt = 0;
				// process all posts from category			
				foreach ($posts as $post1) {
					if (!$this->is_post_child($post1->ID, $cat->cat_ID)){
						$numposts ++;
						if ($numposts == 1){
							$postargs = array(
								'column_txt' => $cp_column_txt,
								'cat_name' => ucwords($cat->name),
								'cattitle' => $options['cattitle']
							);
							$cp_str .= $this->print_title($cp_class, $postargs);
						}
						$postargs = array(
							'class' => $cp_class,
							'column_txt' => $cp_column_txt,
							'titlelen'=> $options['titlelen'],
							'thumb' => $cp_thumb,
							'tsize' => $cp_tsize,
							'excerpt' => $cp_excerpt
						);
						if ($cp_class == 'P'){
							$col_cnt ++;
							if ($ncol == 1) $col_post = ceil($tot_posts / $cp_column);
							elseif ($tot_posts - ($numposts - 1) < $cp_column && $col_cnt == 1) $col_post = ceil(($tot_posts - ($numposts - 1)) /$cp_column);
							elseif ($ncol == $cp_column && $col_cnt == 1) $col_post = $tot_posts - ($numposts -1);
							$postargs['col_post'] = $col_post;
							$postargs['col_cnt'] = $col_cnt;
						}
						global $post;
                                    $post= $post1;
						$cp_str .= $this->print_posts($post, $postargs);
						setup_postdata( $post );
						if ($cp_class == 'P' && $col_cnt == $col_post) {$col_cnt = 0; $ncol ++;}

					} //end if
				} //end foreach posts
			
				if ($numposts > 0){
					$cp_str = $this->print_endposts($cp_class, $col_cat, $cp_column, $cp_str);
				}
			} // end if categories
		} // end foreach cats
		if (($cp_class == 'C') && ($col_cat > 0 && $col_cat < $cp_column)) {
			$cp_str .= '
			<div class="clear"></div>
			';
		}

		// close CP container
		$cp_str .= '
		</div>
		<!-- end of Column Posts ' .$this->version .'-->
		';	
		return $cp_str;	
	}

	function cp_frontstyle(){
		wp_enqueue_style('multicolumn', $this->css_dir .'/cp_multicolumn.css', array(), '1.0');
	}

	function print_title($class, $args){
		$title = str_replace("%%title%%",  $args['cat_name'], $args['cattitle']);
		if ($class=='C'){
			$ptitle = '
			<!-- start of Category Column Box-->
			<div class="cp-box ' .$args['column_txt'] .'">
			<h3>' .$title .'</h3><ul>';		
		}else{
			$ptitle = '<h3>' .$title.'</h3>';
		}
		return $ptitle;
	}
	
	function print_posts($post, $args){
		setup_postdata($post);
						
		// cut down post title if length is specified
		if ((int)$args['titlelen'] > 0){
			$title = $this->substr_utf8($post->post_title, 0, $args['titlelen']) .'...';
		} else{
			$title = $post->post_title;
		}
		$title_full = $post->post_title;
		if ($args['class'] == 'P' && $args['col_cnt'] == 1) {
			$ppost = '
			<!-- start of Post Column Box-->
			<div class="cp-box ' .$args['column_txt'] .'"><ul>
			';
		}
	
		// thumbnail
		$thclear = '';
		$bullet = '<li>';
		$thumb = '';
		if ( $args['thumb'] ) {
			if ( has_post_thumbnail($post->ID) ) {
				//$bullet = '';
				$thclear = '<div style="clear:both;"></div>';
				$thumb = wp_get_attachment_image( get_post_thumbnail_id($post->ID), $args['tsize'], false, array('class'=>"alignthumb"));
			}
		}
		$ppost .= $bullet .'<a href="'.get_permalink($post->ID).'" title="'.sprintf(__('Article %s published at %s', 'cp'), $title_full, date_i18n(__('F j, Y g:i a'), strtotime($post->post_date)) ).'">'.$thumb .$title.'</a>';

		// excerpt
		if ( $args['excerpt'] ) {
			$ppost .= '<p>' .get_the_excerpt() .'</p>' .$thclear .'</li>';
		}
		else{
			$ppost .= $thclear .'</li>';
		}
		
		if ($args['class'] == 'P' && $args['col_cnt'] == $args['col_post'])
			$ppost .= '
			</ul></div>
			<!-- end of Post Column Box-->
			';
		return $ppost;
	}
	
	function print_endposts($class, &$ncol, $cp_column, $pstr){
		if ($class == 'C') {
			$pstr .= '</ul></div>
			<!-- end of Category Column Box-->
			';
			$ncol ++;
			if ($ncol == $cp_column) {
				$pstr .= '<div class="clear"></div>';
				$ncol = 0;
			}
		}else
			$pstr .= '<div class="clear"></div>
			';
		return $pstr;
	}
	
	function get_nposts_by_cat($posts, $cat_id){
		$numposts = 0;
		foreach ($posts as $post){
			if (!$this->is_post_child($post->ID, $cat_id)) $numposts += 1;
		}
		return $numposts;
	}

	/**
	 * check if the post belongs to a category parent or child
	 *
	 * @param	int		$post_id	Post id
	 * @param	string	$cat		Category to compare
	*/
	function is_post_child($post_id, $cat){
		$retval = false;
		$categories = get_the_category($post_id);
		foreach ($categories as $category){
			if ($category->category_parent == $cat) return true;
			if ($category->cat_ID == $cat) $retval = false;		
		}
		return $retval;
	}

	/**
	 * unicode substr workaround from http://en.jinzorahelp.com/forums/viewtopic.php?f=18&t=6231
	 *
	 * @param	string	$str		Text to be cut down
	 * @param	int		$from		Initial position
	 * @param	int		$len		Total text length
	*/
	function substr_utf8($str,$from,$len)
	{
		# utf8 substr
		# http://www.yeap.lv
		return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.
		'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s',
		'$1',$str);
	}

	function cp_uninstaller()
	{
		delete_option('cp_options');
	}


} //end class

// calling the CP class
$columnpost = new ColumnPosts();

// uninstalling the plugin
register_uninstall_hook( __FILE__, array('ColumnPosts','cp_uninstaller') );

endif;
?>
