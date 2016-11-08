<?php

/**
 * Admin Class
 *
 * @package column-posts
 * @subpackage Administration
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'ColumnPost_Admin' ) ) :
/*
 * ColumnPost_Admin Class
 */
class ColumnPost_Admin {

	public $options = array();
	
	public function __construct(){
		$this->setup_actions();
	}

	private function setup_actions(){
		add_filter( 'plugin_action_links', array($this, 'cp_settings_link'), 10, 2 );
		add_action( 'admin_init', array( $this, 'register_admin_options' ) );
		add_action( 'admin_menu', array( $this, 'register_admin_page' ) );
	
	}

	public function cp_settings_link( $links, $file ) 
    { 	 
		global $columnpost;
		static $this_plugin;
		
		if (!$this_plugin){
			$this_plugin = $columnpost->basename;
		}
		
		if ($file == $this_plugin){
			$settings_link = '<a href="options-general.php?page=column-posts">'.__('Settings').'</a>'; 
			array_unshift($links, $settings_link); 
		}
		return $links; 
	}

	public function add_default_options(){
		// get options
		$this->options = get_option('cp_options');

		// set default options
		if ( !is_array( $this->options ) ) {
			$this->options = array(
				'nposts'   => '5',
				'titlelen' => '',
				'excerpt'  => false,
				'order'    => 'ID',
				'porder'   => 'date',
				'include'  => '',
				'exclude'  => '',
				'nosticky' => false,
				'cattitle' => '%%title%%',
				'column'   => '2',
				'class'    => 'C',
				'thumb'    => false,
				'tsize'    => '60',
				'catcolor' => '',
				'headcolor'=> '',
				'headsize' => '12',
				'exccolor' => '',
				'excsize'  => '12',
				'famfont'  => '',
				'tborder'  => false,
				'lstyle'   => false,
				'onlythumb'=> false
			);
			update_option('cp_options', $this->options);
		}
		if (strlen($this->options['porder']) == 0) {
			$this->options['porder'] = 'date';
			update_option('cp_options', $this->options);
		}
	}

	public function register_admin_options(){
		$this->add_default_options();
	
		//Usage section
		add_settings_section('cp_usage', __('Usage','cp'), array( $this, 'cp_usage_section' ), 'column-posts');

		//Column section
		add_settings_section('cp_columns', __('Columns','cp'), array( $this, 'cp_columns_section' ), 'column-posts');
		/**Fields**/
		add_settings_field('cp_class', __('Classified by','cp'), array( $this, 'cp_columns_class' ), 'column-posts', 'cp_columns');
	 	//register_setting  ( 'column-posts', 'cp_class' );
		add_settings_field('cp_column', __('Number of columns','cp'), array( $this, 'cp_columns_column' ), 'column-posts', 'cp_columns');
	 	//register_setting  ( 'column-posts', 'cp_column' );

		//Category section
		add_settings_section('cp_categories', __('Categories','cl'), array( $this, 'cp_categories_section' ), 'column-posts');
		/**Fields**/
		add_settings_field('cp_cattitle', __('Category title','cp'), array($this, 'cp_categories_cattitle' ), 'column-posts', 'cp_categories');
	 	//register_setting  ( 'column-posts', 'cp_cattitle' );			
		add_settings_field('cp_include', __('Include category','cp'), array($this, 'cp_categories_include' ), 'column-posts', 'cp_categories');
	 	//register_setting  ( 'column-posts', 'cp_include' );
		add_settings_field('cp_exclude', __('Exclude category','cp'), array( $this, 'cp_categories_exclude' ), 'column-posts', 'cp_categories');
	 	//register_setting  ( 'column-posts', 'cp_exclude' );
		add_settings_field('cp_order', __('Order categories by','cp'), array( $this, 'cp_categories_order' ), 'column-posts', 'cp_categories');
	 	//register_setting  ( 'column-posts', 'cp_order' );
		
		//Posts section
		add_settings_section('cp_posts', __('Posts','cp'), array( $this, 'cp_posts_section' ), 'column-posts');
		/**Fields**/
		add_settings_field('cp_nposts', __('Number of posts','cp'), array( $this, 'cp_posts_nposts' ), 'column-posts', 'cp_posts');
	 	//register_setting  ( 'column-posts', 'cp_nposts' );	
		add_settings_field('cp_titlelen', __('Headline length','cp'), array( $this, 'cp_posts_titlelen' ), 'column-posts', 'cp_posts');
	 	//register_setting  ( 'column-posts', 'cp_titlelen' );
		add_settings_field('cp_nosticky', __('Hide sticky posts','cp'), array( $this, 'cp_posts_nosticky' ), 'column-posts', 'cp_posts');
	 	//register_setting  ( 'column-posts', 'cp_nosticky' );
		add_settings_field('cp_excerpt', __('Show excerpt','cp'), array( $this, 'cp_posts_excerpt' ), 'column-posts', 'cp_posts');
	 	//register_setting  ( 'column-posts', 'cp_excerpt' );
		add_settings_field('cp_thumb', __('Show thumbnail','cp'), array( $this, 'cp_posts_thumb' ), 'column-posts', 'cp_posts');
	 	//register_setting  ( 'column-posts', 'cp_thumb' );
		add_settings_field('cp_tsize', __('Thumbnail size','cp'), array( $this, 'cp_posts_tsize' ), 'column-posts', 'cp_posts');
	 	//register_setting  ( 'column-posts', 'cp_tsize' );
		add_settings_field('cp_onlythumb', __('Show only posts with thumbnails','cp'), array( $this, 'cp_posts_onlythumb' ), 'column-posts', 'cp_posts');
	 	//register_setting  ( 'column-posts', 'cp_onlythumb' );
		add_settings_field('cp_porder', __('Order post by','cp'), array( $this, 'cp_posts_porder' ), 'column-posts', 'cp_posts');

		
		//Styling section
		add_settings_section('cp_styling', __('Styling','cp'), array( $this, 'cp_styling_section' ), 'column-posts');
		/**Fields**/
		add_settings_field('cp_catcolor', __('Category font color','cp'), array( $this, 'cp_styling_catcolor' ), 'column-posts', 'cp_styling');
	 	//register_setting  ( 'column-posts', 'cp_catcolor' );		
		add_settings_field('cp_headcolor', __('Headline font color','cp'), array( $this, 'cp_styling_headcolor' ), 'column-posts', 'cp_styling');
	 	//register_setting  ( 'column-posts', 'cp_headcolor' );	
		add_settings_field('cp_headsize', __('Headline font size','cp'), array( $this, 'cp_styling_headsize' ), 'column-posts', 'cp_stylings');
	 	//register_setting  ( 'column-posts', 'cp_headsize' );
		add_settings_field('cp_famfont', __('Font family','cp'), array( $this, 'cp_styling_famfont' ), 'column-posts', 'cp_styling');
	 	//register_setting  ( 'column-posts', 'cp_famfont' );
		add_settings_field('cp_exccolor', __('Excerpt font color','cp'), array( $this, 'cp_styling_exccolor' ), 'column-posts', 'cp_styling');
	 	//register_setting  ( 'column-posts', 'cp_exccolor' );		
		add_settings_field('cp_excsize', __('Excerpt font size','cp'), array( $this, 'cp_styling_excsize' ), 'column-posts', 'cp_styling');
	 	//register_setting  ( 'column-posts', 'cp_excsize' );
		add_settings_field('cp_tborder', __('Thumbnail border','cp'), array( $this, 'cp_styling_tborder' ), 'column-posts', 'cp_styling');
	 	//register_setting  ( 'column-posts', 'cp_tborder' );
		add_settings_field('cp_lstyle', __('List style','cp'), array( $this, 'cp_styling_lstyle' ), 'column-posts', 'cp_styling');
	 	//register_setting  ( 'column-posts', 'cp_lstyle' );
		register_setting( 'column-posts', 'cp_options' );
	}

	public function register_admin_page() {
		// add the setting page for this plugin
		add_options_page(__('Column Posts Options', 'cp'),  __('Column Posts', 'cp'), 'manage_options', 'column-posts', array($this,'cp_options'));

		if (isset($_GET['page']) && $_GET['page'] == 'column-posts') {
			// load scripts in the setting page
			add_action( 'admin_print_scripts', array( $this, 'cp_admscript' ) );
		}
	}

	function cp_admscript(){
		global $columnpost;

		wp_enqueue_script('iColorPicker', $columnpost->script_dir .'/iColorPicker.js', array(), '1.0', true);
		wp_enqueue_script('options', $columnpost->script_dir .'/cp_options.js', array(), '1.0', true);
	}

	function cp_options()
	{
?>	
	<div class="wrap">

		<?php screen_icon(); ?>

		<h2><?php _e( 'Column Posts Options', 'cp' ) ?></h2>

		<form action="options.php" method="post" id="cp-conf">

			<?php settings_fields( 'column-posts' ); ?>

			<?php do_settings_sections( 'column-posts' ); ?>

			<p class="submit">
				<input type="submit" name="submit" class="button-primary" value="<?php _e( 'Save Changes', 'cp' ); ?>" />
			</p>
		</form>
	</div>

<?php
	}

	public function cp_usage_section(){
		global $columnpost;

		echo '<p>' . __("To display the posts in columns, use the following code in your template files: <code>&lt;?php do_action('columnpost'); ?&gt;</code>.<br/>You can use the shortcode <b>[columnpost]</b> if you want to display the output of this plugin in your page or post content.<br/>Also, the column posts can be displayed in the sidebar by using the Column Posts widget.", 'cp') .'</p>';
		echo '<input type="hidden" name="imgsrc" value="' .$columnpost->plugin_url .'">';
	}

	public function cp_columns_section(){
		echo '<p>' . __('The posts are grouped by categories or posts, and displayed in columns.','cp') .'</p>';
	}

	public function cp_columns_class(){
?>
		<p><?php echo $this->base;?></p>
		<input name="cp_options[class]" type="radio" id="cp_class" value="C" <?php checked( $this->options['class'], "C" ); ?>/> <?php _e('Category', 'cp'); ?><br />
		<input name="cp_options[class]" type="radio" id="cp_class" value="P" <?php checked( $this->options['class'], "P" ); ?>/> <?php _e('Post', 'cp'); ?><br />
<?php		
	}
	
	public function cp_columns_column(){
?>
		<input name="cp_options[column]" type="radio" id="cp_column" value="1" <?php checked( $this->options['column'], 1 ); ?>/> <?php _e('One', 'cp'); ?><br />
		<input name="cp_options[column]" type="radio" id="cp_column" value="2" <?php checked( $this->options['column'], 2 ); ?>/> <?php _e('Two', 'cp'); ?><br />
		<input name="cp_options[column]" type="radio" id="cp_column" value="3" <?php checked( $this->options['column'], 3 ); ?>/> <?php _e('Three', 'cp'); ?><br />
<?php		
	}

	public function cp_categories_section(){
		echo '<p>' .__('This section allow you to redefine the category title, include or exclude categories and change their ordering.', 'cp') .'</p>';
	}	
	
	public function cp_categories_cattitle(){
?>
		<input name="cp_options[cattitle]" type="text" value="<?php echo ($this->options['cattitle']); ?>" id="cp_cattitle" size="50" />
		<label for="cp_options[cattitle]"><?php _e( '%%title%% is the category name', 'cp' ); ?></label>
<?php
	}
	
	public function cp_categories_include(){
?>
		<input name="cp_options[include]" type="text" value="<?php echo ($this->options['include']); ?>" id="cp_include" />
		<label for="cp_options[include]"><?php _e( 'comma separated category ID\'s', 'cp' ); ?></label>
<?php
	}
	
	public function cp_categories_exclude(){
?>
		<input name="cp_options[exclude]" type="text" value="<?php echo ($this->options['exclude']); ?>" id="cp_exclude" />
		<label for="cp_options[exclude]"><?php _e( 'comma separated category ID\'s', 'cp' ); ?></label>
<?php
	}
	
	public function cp_categories_order(){
?>
		<input name="cp_options[order]" type="radio" id="cp_order" value="ID" <?php checked( $this->options['order'], "ID" ); ?>/> <?php _e('Category ID', 'cp'); ?><br />
		<input name="cp_options[order]" type="radio" id="cp_order" value="name" <?php checked( $this->options['order'], "name" ); ?>/> <?php _e('Category Name', 'cp'); ?><br />
		<input name="cp_options[order]" type="radio" id="cp_order" value="custom" disabled <?php checked( $this->options['order'], "custom" ); ?>/> <?php echo sprintf(__('Custom, as listed in <em>%s</em>', 'cp'), __('Include category', 'cp') ); ?>
<?php
	}
	
	public function cp_posts_section(){
		echo '<p>' .__('This section allow you to specify the number of posts to show, adjust the lenght of the title, hide sticky posts, show excerpts and thumbnails.','cp') .'</p>';
	}

	public function cp_posts_nposts(){
?>
		<input name="cp_options[nposts]" type="text" value="<?php echo $this->options['nposts']; ?>" id="cp_nposts" size="2" />
<?php
	}
	
	public function cp_posts_titlelen(){
?>
		<input name="cp_options[titlelen]" type="text" value="<?php echo $this->options['titlelen']; ?>" id="cp_titlelen" size="2" /> 
		<label for="cp_options[titlelen]"><?php _e( 'leave blank for full post title length, optimal 34 characters', 'cp' ); ?></label>		
<?php	
	}
	
	public function cp_posts_nosticky(){
?>
		<input name="cp_options[nosticky]" type="checkbox" <?php checked( (bool) $this->options['nosticky'], true ); ?> id="cp_nosticky" />
<?php
	}
	
	public function cp_posts_excerpt(){
?>
		<input name="cp_options[excerpt]" type="checkbox" <?php checked( (bool) $this->options['excerpt'], true ); ?> id="cp_excerpt" />
<?php	
	}
	
	public function cp_posts_thumb(){
?>
		<input name="cp_options[thumb]" type="checkbox" <?php checked( (bool) $this->options['thumb'], true ); ?> id="cp_thumb" />
<?php
	}
	
	public function cp_posts_tsize(){
?>
		<input name="cp_options[tsize]" type="text" value="<?php echo ($this->options['tsize']) ? $this->options['tsize'] : "60"; ?>" id="cp_tsize" size="2" />
		<label for="cp_options[tsize]"><?php _e( 'enter size in px for thumbnail width (height proportionally to width)', 'cp' ); ?></label>	
<?php
	}
	
	public function cp_posts_onlythumb(){
?>
		<input name="cp_options[onlythumb]" type="checkbox" <?php checked( (bool) $this->options['onlythumb'], true ); ?> id="cp_onlythumb" />
<?php	
	}

	public function cp_posts_porder(){
?>
		<input name="cp_options[porder]" type="radio" id="cp_porder" value="date" <?php checked( $this->options['porder'], "date" ); ?>/> <?php _e('Post Date', 'cp'); ?><br />
		<input name="cp_options[porder]" type="radio" id="cp_porder" value="title" <?php checked( $this->options['porder'], "title" ); ?>/> <?php _e('Post Title', 'cp'); ?><br />
<?php	
	}
	
	public function cp_styling_section(){
		echo '<p>' .__('You can change the styling of the column posts such as font family, font color. font size, etc .', 'cp') .'</p>';	
	}
	
	public function cp_styling_catcolor(){
?>
		<input name="cp_options[catcolor]" type="text" size="10" value="<?php echo $this->options["catcolor"]; ?>" id="cp_catcolor" class="iColorPicker" />
		<?php _e('(<em>blank assumes the theme color</em>)', 'cp'); ?>
<?php	
	}
	
	public function cp_styling_headcolor(){
?>
		<input name="cp_options[headcolor]" type="text" size="10" value="<?php echo $this->options["headcolor"]; ?>" id="cp_headcolor" class="iColorPicker" />	
		<?php _e('(<em>blank assumes the theme color</em>)', 'cp'); ?>
<?php	
	}
	
	public function cp_styling_headsize(){
?>
		<input name="cp_options[headsize]" type="text" value="<?php echo $this->options['headsize']; ?>" id="cp_eadsize" /> <?php _e('px', 'cp'); ?>
<?php	
	}
	
	public function cp_styling_famfont(){
?>
		<input name="cp_options[famfont]" type="text" size="50" value="<?php echo stripslashes($this->options['famfont']); ?>" id="cp_famfont" /><br /><small><?php _e('Example: verdana, arial, sans-serif. Blank assumes the theme.', 'cp'); ?></small>
<?php	
	}
	
	public function cp_styling_exccolor(){
?>
		<input name="cp_options[exccolor]" type="text" size="10" value="<?php echo $this->options['exccolor'] ?>" id="cp_exccolor" class="iColorPicker" />		
		<?php _e('(<em>blank assumes the theme color<em>)', 'cp'); ?>
<?php
	}
	
	public function cp_styling_excsize(){
?>
		<input name="cp_options[excsize]" type="text" value="<?php echo $this->options['excsize']; ?>" id="cp_excsize" /> <?php _e('px', 'cp'); ?>
<?php
	}
	
	public function cp_styling_tborder(){
?>
		<input name="cp_options[tborder]" type="checkbox" <?php checked( (bool) $this->options['tborder'], true ); ?> id="cp_tborder" />
<?php
	}
	
	public function cp_styling_lstyle(){
?>
		<input name="cp_options[lstyle]" type="checkbox" <?php checked( (bool) $this->options['lstyle'], true ); ?> id="cp_lstyle" />
<?php
	}
	
}
endif; // class_exists check

function ColumnPost_admin() {
	global $ColumnPost;

	new ColumnPost_Admin();
}
?>
