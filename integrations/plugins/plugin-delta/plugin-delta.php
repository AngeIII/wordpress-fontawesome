<?php

/**
 * Plugin Name:       Plugin Delta SVG with JavaScript
 * Plugin URI:        https://fontawesome.com/plugin-delta/
 * Description:       Test Client Plugin that tries to enqueue its own SVG with JavaScript
 *                    version of Font Awesome which conflicts with the FontAwesome
 *                    plugin.
 * Version:           0.0.1
 * Author:            Font Awesome
 * Author URI:        https://fontawesome.com/
 * License:           GPLv3
 */

defined( 'WPINC' ) || die;
define( 'DELTA_PLUGIN_VERSION', '0.0.1' );
define( 'DELTA_PLUGIN_LOG_PREFIX', 'delta-plugin' );

add_action('init', function(){
  wp_enqueue_script(
    'DELTA_PLUGIN_LOG_PREFIX',
    'https://use.fontawesome.com/releases/v5.0.11/js/all.js',
    array(),
    null,
    false
  );
  wp_enqueue_style(
    'plugin-delta-style',
    trailingslashit(plugins_url()) . trailingslashit(plugin_basename(__DIR__)) . 'style.css',
    array(),
    null,
    'all'
  );
});

add_action('font_awesome_enqueued', function($loadSpec){
  if ( class_exists('FontAwesome') ) {
    error_log( DELTA_PLUGIN_LOG_PREFIX . " font_awesome_enqueued: " . "method: " . $loadSpec['method'] . ", ver: " . $loadSpec['version']);
  }
}, 10, 3);

add_filter('the_content', function($content){
  $pre_content = <<<EOT
<div class="plugin-delta-pre-content">
  <h2>Plugin Delta</h2>
  <p>Expected by plugin-delta (introduced v5.0.11): "fas fa-cloud-download": <i class="fas fa-cloud-download"></i></p>
</div>
EOT;
  return $pre_content . $content;
}, 10, 1);
