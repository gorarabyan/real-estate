<?php
/**
 * Template Name: Cities Single
 *
 * This template is used to display single posts of the 'cities' post type.
 */

get_header();

while ( have_posts() ) :
    the_post();
    
    $cityName = get_the_title();
    
    $args = array(
        'post_type'      => 'real_estate',
        'posts_per_page' => 5,
        'orderby'        => 'date',
        'order'          => 'DESC',
        'meta_query'     => array(
            array(
                'key'     => 'cities_option',
                'value'   => $cityName,
                'compare' => '=',
            ),
        ),
    );
    
    $query = new WP_Query( $args );
    ?>
    
    <div id="post-<?php the_ID(); ?>" class="container mt-3">
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <div class="row mt-3">
            <div class="entry-content col-lg-12">
                <?php the_content(); ?>
            </div>
        </div>
        
        <div class="">
            <div class="row">
                <?php if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="singlePost card shadow-sm">
                                <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?>" class="card-img-top" alt="">
                                <div class="card-body d-flex flex-column justify-content-flex-start singlePost-body">
                                    <h3 class="card-title post-title">
                                        <a href="<?php the_permalink()?>">
                                            <?php
                                          $title = get_the_title(); 
                                          echo mb_strlen($title) > 40 ? mb_substr($title, 0, 40) . '...' : $title;
                                    ?>
                                        </a>
                                        </h3>
                                    <div class="card-text entry-content">
                                    <?php
                                        $list = '';
                                        $city = get_post_meta(get_the_ID(), 'cities_option', true);
                                        $area = get_post_meta(get_the_ID(), 'area', true);
                                        $living_area = get_post_meta(get_the_ID(), 'living_area', true);
                                        $floor = get_post_meta(get_the_ID(), 'floor', true);
                                        $price = get_post_meta(get_the_ID(), 'price', true);
                                        
                                        if ($price) {
                                            $list .= '<li><h3>' . $price . '</h3></li>';
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
                                        
                                    ?>
                                        <ul class="list-unstyled">
                                            <?php echo $list; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>
    </div>

<?php endwhile;

get_footer();
