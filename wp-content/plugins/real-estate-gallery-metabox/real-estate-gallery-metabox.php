<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://narek-test-domain.xyz
 * @since             1.0.0
 * @package           Real_Estate_Gallery_Metabox
 *
 * @wordpress-plugin
 * Plugin Name:       Real Estate Gallery Metabox
 * Plugin URI:        https://narek-test-domain.xyz
 * Description:       Adds a gallery metabox for real estate post type.
 * Version:           1.0.0
 * Author:            Narek Muradyan
 * Author URI:        https://narek-test-domain.xyz/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       real-estate-gallery-metabox
 * Domain Path:       /languages
 */

function enqueue_real_estate_gallery_metabox_scripts($hook) {
    global $post_type;
    if ('real_estate' === $post_type) {
        wp_enqueue_media();
        wp_enqueue_style('real-estate-gallery-metabox-style', plugins_url('assets/css/style.css', __FILE__));
        wp_enqueue_script('real-estate-gallery-metabox-script', plugins_url('assets/js/script.js', __FILE__), array('jquery'), '1.0', true);
    }
}
add_action('admin_enqueue_scripts', 'enqueue_real_estate_gallery_metabox_scripts');
function custom_gallery_meta_box() {
    add_meta_box(
        'custom-gallery-meta-box',
        'Gallery Images',
        'render_custom_gallery_meta_box',
        'real_estate',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'custom_gallery_meta_box');

function render_custom_gallery_meta_box($post) {
    $gallery_images = get_post_meta($post->ID, "gallery_images", true);

    wp_enqueue_media();
    ?>

    <div class="custom-gallery-container">
        <ul class="custom-gallery-list">
            <?php
            if ($gallery_images) {
                foreach ($gallery_images as $index => $gallery_image) {
                    echo '<li class="custom-gallery-item">';
                    echo '<img src="' . esc_attr($gallery_image) . '" class="custom-gallery-image-preview" />';
                    echo '<input type="hidden" name="gallery_images[]" value="' . esc_attr($gallery_image) . '" />';
                    echo '<a href="#" class="button custom-gallery-remove">Remove</a>';
                    echo '</li>';
                }
            }
            ?>
        </ul>
        <button class="custom-gallery-upload custom-gallery-upload-btn">Upload Images</button>
    </div>

    <?php
}

function save_custom_gallery_meta_box($post_id) {
    if (isset($_POST['gallery_images'])) {
        $gallery_images = array_map('sanitize_text_field', $_POST['gallery_images']);
        update_post_meta($post_id, 'gallery_images', $gallery_images);
    } else {
        delete_post_meta($post_id, 'gallery_images');
    }
}
add_action('save_post', 'save_custom_gallery_meta_box');