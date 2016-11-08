=== Column Posts ===
Contributors: lebasca
Donate link: http://boroniatechnologies.com/contribute
Tags: column, column posts, category posts, categories, category, posts, excerpt, thumbnail
Requires at least: 3.6
Tested up to: 4.4
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display categories or posts in columns.

== Description ==

Column Posts is a WordPress plugin that allows you to display your posts in columns. The columns can be classified by categories or posts. 

= These are the features: =
* The columns can be grouped by categories or posts.
* The column boxes can be displayed between 1 to 3 columns.
* The category title can be redefined.
* The categories can be selected manually or displayed all.
* The categories can be ordered by id, name and listed in the include category.
* The number of posts can be specified.
* The posts can be shown with excerpts, thumbnails or only post title.
* Sticky posts can be hidden.
* Only posts with thumbnails by category can be shown.
* The posts can be ordered by title or date.
* The size of the thumbnails is configurable.
* The appearance of the elements shown in the plugin can be configured.
* This plugin has the flexibility to be used as a template tag or widget.
* Shortcode with include and exclude category parameters

= Usage =

To display the posts in columns, use the following code in your template files: <?php do_action('columnpost'); ?>.
You can use the shortcode [columnpost] if you want to display the output of this plugin in your page or post content.
Also, the column posts can be displayed in the sidebar by using the Column Posts widget.

= Translators =

* Spanish (es_ES) - [Andrew Kurtis](http://www.webhostinghub.com/), [Catherine Lebastard](http://www.boroniatechnologies.com/)

If you have created your own language pack, or have an update of an existing one, you can contact [me](http://boroniatechnologies.com/contact/) so that I can bundle it into Column Posts. You can download the latest [POT file](http://plugins.svn.wordpress.org/column-posts/trunk/languages/column-posts.pot).

== Installation ==

= Automatic installation =

  1. Go to the Dashboard and click Plugins > Add New.
  2. Enter Column Posts under search textbox.
  3. Click Install Now to install this plugin.
  4. Confirm the popup window to install the plugin.
  5. Click Proceed to continue with the installation.
  6. Click Activate Plugin to activate it.

= Manual installation =

  1. Download the files for this plugin.
  2. Upload the files to the wp-content/plugins directory.
  3. Go to the Dashboard and find this plugin in the list.
  4. Click Activate Plugin to activate it.

The settings page is found in settings > Column Posts.

== Frequently asked questions ==

= Is there a way to change the  maximum number of columns? =

No at this moment. The maximum number of column is three and it is predefined. 

= If I remove the reserved word for category title (%%title%%), can I still get the title? =

No, you have to leave this predefine word in order to get the category title; otherwise, the category title won’t be displayed. Also, you can add words before or after the reserved word for category title (%%title%%).

= How can I specify the categories that I want to display? =

You have to enter the category id into include category textbox. You can also enter the categories that you want to exclude into exclude category textbox.

= Why custom radio button is disabled? =

Custom option is disabled when there are no categories typed in include category textbox. Once you enter some text, you will see the custom option enabled.

= Can I have different font-family for the category title and the excerpt? =

No, the font-family is the same for the whole output plugin.

= If I don’t know the hex color value, is there a color picker? =

Yes, the color picker is next to the textbox for entering the color. When you click on the square, the color picker tool will appear below the textbox. This color picker works the same as the one in photoshop.

= I would like to know how to limit the amount of excerpt data I am displaying: like number of words or number of characters, etc. Sometimes is too much of it and I do not want to fill up the page with big paragraphs of information. Is this possible? = 

Yes, you can limit the amount of excerpt words by adding these lines in your functions.php file located in your theme directory:

function custom_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

In the example above, I limited the excerpt to 25 words but you can put any number that you want.

= Does shortcode support parameters? =

The version 1.3 of this plugin supports two parameters: include category and exclude category.
Example:
[columnpost cat_inc=”1,8″ cat_exc=”4″] // lists categories 1 and 8 and exclude category 4
[columnpost cat_inc=”1,8″] // lists categories 1 and 8 and uses the exclude category if it is specified in the settings
[columnpost cat_exc=”4″] // excludes category 4 and uses the include category if it is specified in the settings

== Screenshots ==

1. Column Post Setting Options.
2. Column Post is displayed in the Front page.

== Changelog ==
= 1.4 =
* Updated Readme.txt

= 1.3 =
* Added shortcode with include and exclude category parameters

= 1.2.5 =
* Fixed the translation of this plugin

= 1.2.4 =
* Fixed pass by reference argument deprecated in php 5.4.

= 1.2.3 =
* Fixed the display of the first post caused by version 1.2.2.

= 1.2.2 =
* Fixed excerpt more link.

= 1.2.1 =
* Added div element to the post title.

= 1.2 =
* Added the functionality to show post thumbnail image proportionally.

= 1.2 =
* Added the functionality to show post thumbnail image proportionally.

= 1.1.1 =
* Fixed the display of thumbnails.

= 1.1 =
* Changed the display of the reserved word for category title. It displays category name instead of category slug.
* Added shortcode.
* Added the possibility to order the posts by title or date.

= 1.0.1 =
* Plugin version updated

= 1.0 =
* Plugin launched