<?php
/**
 * Plugin Name: BrightonSEO
 * Plugin URI: https://pragmatic.agency
 * Description: A set of example features for BrightonSEO Workshop 2019
 * Author: Sean Blakeley
 * Author URI: https://pragmatic.agency
 * Version: 1.0.0
 * License: GPL2+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package BrightonSEO
 */


/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Yoast Breadcrumbs
 * IMPORTANT: where you want breadcrumbs to appear in your theme, add:
 * <?php wptasty_article_header(); ?>
 * 
 */
function brightonseo_yoast_breadcrumbs() {
    if ( function_exists('yoast_breadcrumb') ) {
        yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
    }
}
add_action( 'brightonseo_article_header', 'brightonseo_yoast_breadcrumbs' );

/**
 * Add search snippet
 * Adds the search snippet script for Google
 */
function wptasty_sitelink_search() {
	echo '
		<script type="application/ld+json">
			{
				"@context": "https://schema.org",
				"@type": "WebSite",
				"url": "' . get_home_url() . '",
				"potentialAction": {
					"@type": "SearchAction",
					"target": "' . get_home_url() . '/?s={search_term_string}",
					"query-input": "required name=search_term_string"
				}
			}
		</script>
	';
}
add_action( 'wp_footer', 'wptasty_sitelink_search' );

/**
 * Add Admin reminder for theme script
 */
function yoast_breadcrumbs_warning() {
	echo '<div class="notice notice-warning is-dismissible">
	
		<p>Don\'t forget to add this code where you want your Yoast breadcrumbs to appear:</p>
		<code>
			&lt;?php do_action( \'brightonseo_article_header\' ); ?&gt;
		</code>
    </div>';
}
add_action( 'admin_notices', 'yoast_breadcrumbs_warning' );

/**
 * Redirect to our out of stock template
 * IMPORTANT: this code should be added to WooCommerce>Templates> Sin
 */
function redirect_products_info() {
    echo '
    <div class="notice notice-info is-dismissible">
		<p>To create a different template for out of stock products:</p>
		<p>Create or edit the file in your theme <code>yourtheme/woocommerce/single-product.php</code></p>
		<p> see: <a href="https://docs.woocommerce.com/document/template-structure/">WooCommerce Templates</a>
		<p>Add this replacement loop:</p>
<pre><code>&lt;?php while ( have_posts() ) : the_post();
	$product = wc_get_product( get_the_ID() );
	if ( ( TRUE === $product->manage_stock && NULL != $product->stock_quantity ) || \'instock\' === $product->stock_status ) {
	wc_get_template_part( \'content\', \'single-product\' );
} else {
	wc_get_template_part( \'content\', \'single-product-out-of-stock\' );
}
endwhile; // end of the loop. ?&gt;</code></pre>
<p>Create a template-part file <code>yourtheme/template-parts/content/single-product-out-of-stock.php</code></p>
<p><i>Change the out of stock template to fit your needs</i></p>
</div>';
}
add_action( 'admin_notices', 'redirect_products_info' );