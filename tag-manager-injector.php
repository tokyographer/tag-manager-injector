<?php
/*
Plugin Name: Tag Manager Injector
Plugin URI: https://your-plugin-url.com
Description: Allows users to easily inject Google Tag Manager code in the header and footer of their WordPress website.
Version: 1.0.0
Author: Anthony Tatekawa
Author URI: https://your-website-url.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

// Add the plugin settings page
add_action('admin_menu', 'tag_manager_injector_add_settings_page');
function tag_manager_injector_add_settings_page() {
    add_options_page('Tag Manager Injector Settings', 'Tag Manager Injector', 'manage_options', 'tag-manager-injector', 'tag_manager_injector_render_settings_page');
}

// Render the plugin settings page
function tag_manager_injector_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Tag Manager Injector Settings</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('tag_manager_injector_settings');
                do_settings_sections('tag-manager-injector');
                submit_button();
            ?>
        </form>
    </div>
    <?php
}

// Register plugin settings
add_action('admin_init', 'tag_manager_injector_register_settings');
function tag_manager_injector_register_settings() {
    register_setting('tag_manager_injector_settings', 'tag_manager_injector_header_code');
    register_setting('tag_manager_injector_settings', 'tag_manager_injector_footer_code');

    add_settings_section('tag_manager_injector_section', 'Code Injection', 'tag_manager_injector_section_callback', 'tag-manager-injector');

    add_settings_field('tag_manager_injector_header_code', 'Header Code', 'tag_manager_injector_header_code_callback', 'tag-manager-injector', 'tag_manager_injector_section');
    add_settings_field('tag_manager_injector_footer_code', 'Footer Code', 'tag_manager_injector_footer_code_callback', 'tag-manager-injector', 'tag_manager_injector_section');
}

// Callback functions for settings fields
function tag_manager_injector_section_callback() {
    echo '<p>Enter your Google Tag Manager code below:</p>';
}

function tag_manager_injector_header_code_callback() {
    $header_code = get_option('tag_manager_injector_header_code');
    echo '<textarea name="tag_manager_injector_header_code" rows="6" cols="50">' . esc_textarea($header_code) . '</textarea>';
}

function tag_manager_injector_footer_code_callback() {
    $footer_code = get_option('tag_manager_injector_footer_code');
    echo '<textarea name="tag_manager_injector_footer_code" rows="6" cols="50">' . esc_textarea($footer_code) . '</textarea>';
}

// Inject code in the header
add_action('wp_head', 'tag_manager_injector_inject_header_code');
function tag_manager_injector_inject_header_code() {
    $header_code = get_option('tag_manager_injector_header_code');
    if ($header_code) {
        echo $header_code;
    }
}

// Inject code in the footer
add_action('wp_footer', 'tag_manager_injector_inject_footer_code');
function tag_manager_injector_inject_footer_code() {
    $footer_code = get_option('tag_manager_injector_footer_code');
    if ($footer_code) {
        echo $footer_code;
    }
}
