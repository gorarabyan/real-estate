<?php
/**
 * Template Name: Real Estate Single
 *
 * This template is used to display single posts of the 'real_estate' post type.
 */

get_header();

while ( have_posts() ) :
    the_post();
    ?>
    <div id="post-<?php the_ID(); ?>" class="container mt-3">
    <h1 class="entry-title"><?php the_title(); ?></h1>

    <div class="row mt-3">
        <div class="galleryItems col-lg-6">
            <div class="row">
                <a href="<?= esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')) ?>" class="col-lg-12 py-2 px-1">
                    <img src="<?= esc_url(get_the_post_thumbnail_url(get_the_ID(), 'thumbnail')) ?>" class="img-fluid featuredImage" alt="">
                </a>

                <?php
                $galleryImages = get_post_meta($post->ID, "gallery_images", true);
                if ($galleryImages) {
                    foreach ($galleryImages as $galleryImage) {
                        echo '<a href="' . esc_url($galleryImage) . '" class="col-lg-2 px-1">
                                <img src="' . esc_url($galleryImage) . '" class="img-fluid">
                              </a>';
                    }
                }
                ?>
            </div>
        </div>

        <div class="col-lg-6">
            <?php
            $list = '';
            $address = get_post_meta(get_the_ID(), 'address', true);
            $city = get_post_meta(get_the_ID(), 'cities_option', true);
            $area = get_post_meta(get_the_ID(), 'area', true);
            $living_area = get_post_meta(get_the_ID(), 'living_area', true);
            $floor = get_post_meta(get_the_ID(), 'floor', true);
            $price = get_post_meta(get_the_ID(), 'price', true);

            if ($address) {
                echo '<p>' . __('Адрес: ') . $address . '</p>';
            }
            if ($city) {
                $list .= '<li>' . __('Город: ') . $city . '</li>';
            }
            if ($area) {
                $list .= '<li>' . __('Площадь: ') . $area . '</li>';
            }
            if ($living_area) {
                $list .= '<li>' . __('Жилая площадь: ') . $living_area . '</li>';
            }
            if ($floor) {
                $list .= '<li>' . __('Этаж: ') . $floor . '</li>';
            }
            if ($price) {
                $list .= '<li>' . __('Стоимость: ') . $price . '</li>';
            }
            ?>

            <ul class="list-unstyled">
                <?php echo $list; ?>
            </ul>
        </div>
    </div>

    <div class="entry-content mt-4">
        <?php the_content(); ?>
    </div>
</div>
   

<?php endwhile;

get_footer();
