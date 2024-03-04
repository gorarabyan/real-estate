<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array( 'understrap-styles' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION

function enqueue_lightgallery_scripts() {
    wp_enqueue_style('lightgallery-css', get_stylesheet_directory_uri().'/assets/css/lightgallery.min.css');

    wp_enqueue_script('lightgallery-js', get_stylesheet_directory_uri().'/assets/js/lightgallery.min.js', array('jquery'), null, true);

    wp_enqueue_script('lg-zoom-js', get_stylesheet_directory_uri().'/assets/js/lg-zoom.min.js', array('lightgallery-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_lightgallery_scripts');

function my_custom_script() {
    wp_enqueue_script('custom-script', get_stylesheet_directory_uri() . '/assets/js/script.js', array('jquery'), '1.0', true);
    
    
    wp_enqueue_script('ajax-functions', get_stylesheet_directory_uri() . '/assets/js/ajaxFunctions.js', array('jquery'), null, true);

    wp_localize_script('ajax-functions', 'ajax', array('url' => admin_url('admin-ajax.php')));
}

add_action('wp_enqueue_scripts', 'my_custom_script');

function custom_register_footer_menu() {
    register_nav_menu('footer-menu',__( 'Footer Menu' ));
}
add_action( 'init', 'custom_register_footer_menu' );

function create_real_estate_post_type() {
    register_post_type( 'real_estate', array(
        'label'     => __( 'Real Estate', 'understrap-child' ),
        'public' => true,
        'has_archive' => true,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        'taxonomies' => array( 'real_estate_type' )
    ) );

    register_post_type( 'Cities', array(
        'label'     => __( 'Cities', 'understrap-child' ),
        'public' => true,
        'has_archive' => true,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    ) );
}
add_action( 'init', 'create_real_estate_post_type' );

function create_real_estate_type_taxonomy() {
    $args = array(
        'label'     => __( 'Property Type', 'understrap-child' ),
        'public' => true,
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'real-estate-type' )
    );

    register_taxonomy( 'real_estate_type', 'real_estate', $args );
}
add_action( 'init', 'create_real_estate_type_taxonomy' );

function add_cities_metabox() {
    add_meta_box(
        'cities_metabox',
        __('Cities', 'understrap-child'),
        'render_cities_metabox',
        'real_estate',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_cities_metabox');

function render_cities_metabox($post) {
    wp_nonce_field('cities_metabox', 'cities_metabox_nonce');

    $selected_value = get_post_meta($post->ID, 'cities_option', true);
    global $wpdb;

    $posts_table = $wpdb->prefix . 'posts';

    $query = $wpdb->prepare("SELECT ID, post_title FROM $posts_table WHERE post_type = %s", 'cities');

    $cities = $wpdb->get_results($query);
    $options = array();

    foreach ($cities as $city) {
        $options[$city->post_title] = $city->post_title;
    }

    echo '<label for="cities_option">' . __('Select a City', 'understrap-child') . '</label>';
    echo ' <select id="cities_option" name="cities_option">';
    foreach ($options as $value => $label) {
        echo '<option value="' . esc_attr($value) . '" ' . selected($selected_value, $value, false) . '>' . esc_html($label) . '</option>';
    }
    echo '</select>';
}

function save_cities_metabox($post_id) {
    if (!isset($_POST['cities_metabox_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['cities_metabox_nonce'], 'cities_metabox')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (isset($_POST['cities_option'])) {
        update_post_meta($post_id, 'cities_option', sanitize_text_field($_POST['cities_option']));
    }
}
add_action('save_post', 'save_cities_metabox');

add_action('wp_ajax_create_real_estate_post', 'create_real_estate_post');
add_action('wp_ajax_nopriv_create_real_estate_post', 'create_real_estate_post');

function create_real_estate_post() {
    
    if ( !empty( $_POST['post_title'] ) && !empty( $_POST['featured_image_data_url'] ) && !empty( $_POST['content'] ) && !empty( $_POST['city'] ) && !empty( $_POST['area'] ) && !empty( $_POST['livingArea'] ) && !empty( $_POST['floor'] ) && !empty( $_POST['price'] ) && !empty( $_POST['address'] ) ) {
        $post_title = sanitize_text_field( $_POST['post_title'] );
        $content = sanitize_text_field( $_POST['content'] );
        $city = sanitize_text_field( $_POST['city'] );
        $area = $_POST['area'];
        $livingArea = $_POST['livingArea'];
        $floor = $_POST['floor'];
        $price = $_POST['price'];
        $address = $_POST['address'];
        $propertyType = $_POST['property_type'];
        $featured_image_data_url = $_POST['featured_image_data_url'];
        
        $featured_image_name = $_POST['featured_image_name'];
        $featured_image_data_name = $_POST['featuredImageDataName'];
       
        $base64_string = str_replace('data:'.$featured_image_data_name.';base64,', '', $featured_image_data_url);
        $featured_image_binary = base64_decode($base64_string);
        $upload_dir = wp_upload_dir();
        $target_file = $upload_dir['path'] . '/'.$featured_image_name;
        
        if (file_put_contents($target_file, $featured_image_binary)) {
            $post_data = array(
                'post_title'    => $post_title,
                'post_content'  => $content,
                'post_status'   => 'pending',
                'post_type'     => 'real_estate'
            );

            $post_id = wp_insert_post( $post_data );
            
            if($post_id){
                
                update_post_meta( $post_id, 'area', $area );
                update_post_meta( $post_id, 'living_area', $livingArea );
                update_post_meta( $post_id, 'floor', $floor );
                update_post_meta( $post_id, 'price', $price );
                update_post_meta( $post_id, 'address', $address );
                
                wp_set_object_terms( $post_id, $propertyType, 'real_estate_type' );
                
                $file_path = $upload_dir['path'] . '/'.$featured_image_name;

                $attachment_id = wp_insert_attachment( array(
                    'post_mime_type' => $featured_image_data_name,
                    'post_title' => $post_title,
                    'post_content' => '',
                    'post_status' => 'inherit'
                ), $file_path, $post_id );
    
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                $attach_data = wp_generate_attachment_metadata( $attachment_id, $file_path );
                wp_update_attachment_metadata( $attachment_id, $attach_data );
                set_post_thumbnail( $post_id, $attachment_id ); 
                
                if (isset($_POST['gallery_image_names']) && isset($_POST['gallery_image_data_urls'])) {
                    $gallery_image_names = $_POST['gallery_image_names'];
                    $gallery_image_data_names = $_POST['galleryImageDataNames'];
                    $gallery_image_data_urls = $_POST['gallery_image_data_urls']; 
                    $gallery_image_paths = array(); 
                
                    foreach ($gallery_image_data_urls as $index => $gallery_image_data_url) {
                        $gallery_image_name = $gallery_image_names[$index];
                        $gallery_image_data_name = $gallery_image_data_names[$index];
                        $base64_string = str_replace('data:'.$gallery_image_data_name.';base64,', '', $gallery_image_data_url);
                        $gallery_image_binary = base64_decode($base64_string);
                        $gallery_file_path = $upload_dir['path'] . '/' . $gallery_image_name;
                        $gallery_file_url = $upload_dir['url'] . '/' . $gallery_image_name;
                        if (file_put_contents($gallery_file_path, $gallery_image_binary)) {
                            $gallery_image_paths[] = $gallery_file_url;
                        }
                    }
                
                    $serialized_gallery_image_paths = array_map('sanitize_text_field', $gallery_image_paths);

                    update_post_meta($post_id, 'gallery_images', $serialized_gallery_image_paths);
                }
    
                echo 'Post submitted successfully!';
            }
            
        } else {
            echo "<span class='text-danger'>Can't upload a file, please try again."; 
        }
    } else {
            echo '<span class="text-danger">Please fill out all fields.</span>';
    }

    wp_die();
   
}





