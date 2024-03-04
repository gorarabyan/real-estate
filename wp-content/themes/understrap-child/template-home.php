<?php
/*
Template Name: Home Page
*/
?>

<?php get_header(); ?>

<?php

$argsPosts = array(
    'post_type'      => 'real_estate',
    'posts_per_page' => 6,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$argsCities = array(
    'post_type'      => 'cities',
    'posts_per_page' => 4,
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$queryCities = new WP_Query( $argsCities );

$queryPosts = new WP_Query( $argsPosts );

?>
<section class="carouselSection container-fluid">
   <div id="myCarousel" class="carousel slide" data-ride="carousel">

    
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?q=80&w=1000&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8aG90ZWwlMjByb29tfGVufDB8fDB8fHww" class="d-block w-100 object-fit-cover img-fluid" alt="Первый слайд">
        </div>
        <div class="carousel-item">
            <img src="https://c4.wallpaperflare.com/wallpaper/753/207/605/luxury-house-interior-wallpaper-preview.jpg" class="d-block w-100 object-fit-cover img-fluid" alt="Второй слайд">
        </div>
        <div class="carousel-item">
            <img src="https://miro.medium.com/v2/resize:fit:1358/1*RCIK1zwt7T6J-zlYVs7tSg.jpeg" class="d-block w-100 object-fit-cover img-fluid" alt="Третий слайд">
        </div>
    </div>

    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>

</div>
</section> 

<section class="latestPostsSection container mt-5 ">
    <h1>Последние публикации</h1>
    <div class="latestPosts row mt-4">
        <?php if ($queryPosts->have_posts()) :
            while ($queryPosts->have_posts()) : $queryPosts->the_post();
                ?>
                <div class="col-md-4 mb-4">
                    <div class="singlePost card shadow-sm">
                        <a href="<?php the_permalink(); ?>">
                            <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?>" class="card-img-top" alt="">
                        </a>
                        <div class="card-body d-flex flex-column justify-content-flex-start singlePost-body">
                            <h3 class="card-title post-title">
                                 <a href="<?php the_permalink() ?>">
                                     <?php
                                          $title = get_the_title(); 
                                          echo mb_strlen($title) > 40 ? mb_substr($title, 0, 40) . '...' : $title;
                                    ?>
                              </a>
                            </h3>
                            <div class="card-text entry-content mt-3">
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
</section>

<section class="aboutUsSection container-fluid py-5">
    <div class="container">
        <div class="row">
        <div class="col-md-6">
            <img src="https://kamleshyadav.com/templatemonster/hotel-lovato/wp-content/uploads/2018/12/55-1024x576-1-1.jpg" class="img-fluid" alt="About Us Image">
        </div>

        <div class="col-md-6 text-white">
            <p>About Us</p>
            <h2>Let Tranquil Surprise You</h2>
            <p class="font-weight-bold">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmodpoir incididunt ut labore et dolore magna aliqua.</p>
            <p>Ut enim ad minim veniam, qiuis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consuats  iruredolor in reprehenderit in voluptate velit esse cillum dolore e fugiat nulla pariatur. Excepteur sint occaecat. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain.</p>
            <div class="d-flex align-items-start">
    <figure class="mb-0">
        <img decoding="async" width="150" height="73" src="https://kamleshyadav.com/templatemonster/hotel-lovato/wp-content/uploads/2019/03/signature-1.png" class="img-fluid" alt="signature" title="signature-1">
    </figure>
</div>
        </div>
    </div>
    </div>
</section>

<section class="latestCitiesSection container mt-5">
    <h1>Города</h1>
    <div class="latestCities row mt-4">
        <?php if ($queryCities->have_posts()) :
            while ($queryCities->have_posts()) : $queryCities->the_post();
                ?>
                <div class="col-md-4 mb-4">
                    <div class="singlePost card shadow-sm">
                        <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?>" class="card-img-top" alt="">
                        <div class="card-body d-flex flex-column align-items-center" style="background-color: #b08d54; color: white;">
                            <h3 class="card-title city-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="card-text entry-content card-city">
                                   <?php the_excerpt(); ?>
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
</section>


<section class="formSection container mt-5 shadow-sm">
    <h1>Добавить недвижимость</h1>
    <form id="real_estate_form" action="#" method="post" enctype="multipart/form-data">
        <div class="row">
            <!-- Левая часть -->
            <div class="col-md-6">
                <div class="input-group mb-3">
                    <label class="w-100">Заголовок
                        <br><input type="text" id="title" class="form-control" name="title" placeholder="Заголовок">
                    </label>
                </div>
             
                <div class="input-group mb-3">
                    <?php
                    global $wpdb;

                    $posts_table = $wpdb->prefix . 'posts';

                    $query = $wpdb->prepare("SELECT ID, post_title FROM $posts_table WHERE post_type = %s", 'cities');

                    $cities = $wpdb->get_results($query);
                    $options = array();

                    foreach ($cities as $city) {
                        $options[$city->post_title] = $city->post_title;
                    }

                    echo '<div class="input-group-prepend"><label for="cities_option" class="input-group-text">' . __('Выберите город', 'understrap-child') . '</label></div>';
                    echo ' <select id="cities_option" name="cities_option" class="custom-select">';
                    foreach ($options as $value => $label) {
                        echo '<option value="' . esc_attr($value) . '" ' . selected($selected_value, $value, false) . '>' . esc_html($label) . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>
                
                <div class="input-group mb-3">
                    <label class="w-100">Адрес
                        <br><textarea name="address" class="form-control" id="address" placeholder="Область, улица, квартира и т.д." rows="2"></textarea>
                    </label>
                </div>
                
                <div class="input-group mb-3">
                    <label class="w-100">Площадь
                        <br><input type="text" name="area" id="area" class="form-control" placeholder="Напр. 41,1 м²">
                    </label>
                </div>
                
                <div class="input-group mb-3">
                    <label class="w-100">Жилая площадь
                        <br><input type="text" name="living_area" id="living-area" class="form-control" placeholder="Напр. 41,1 м²">
                    </label>
                </div>
                
                <div class="input-group mb-3">
                    <label class="w-100">Этаж
                        <br><input type="text" name="floor" id="floor" class="form-control" placeholder="Напр. 4">
                    </label>
                </div>
            </div>

            <!-- Правая часть -->
            <div class="col-md-6">

                <div class="input-group mb-3">
                    <label class="w-100">Цена
                        <br><input type="text" name="price" id="price" class="form-control" placeholder="Напр. 30 911 639 ₽">
                    </label>
                </div>
                
                 <div class="input-group mb-3">
                    <label class="w-100">Описание
                        <br><textarea name="content" class="form-control" id="content" placeholder="Описание" rows="4"></textarea>
                    </label>
                </div>
                
                <div class="input-group mb-3">
                    <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'real_estate_type',
                        'hide_empty' => false,
                    ));

                    $termsOptions = [];

                    foreach ($terms as $term) {
                        $termsOptions[$term->name] = $term->name;
                    }

                    echo '<div class="input-group-prepend"><label for="property_type" class="input-group-text">' . __('Тип недвижимости', 'understrap-child') . '</label></div>';
                    echo ' <select id="property_type" name="property_type" class="custom-select">';
                    foreach ($termsOptions as $value => $label) {
                        echo '<option value="' . esc_attr($value) . '" ' . selected($selected_value, $value, false) . '>' . esc_html($label) . '</option>';
                    }
                    echo '</select>';
                    ?>
                </div>

                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="featuredImage" id="featuredImage" accept="image/*" > 
                        <label class="custom-file-label" for="featuredImage">Главное изображение</label>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <div class="custom-file">
                        <input type="file" id="galleryImages" class="custom-file-input" name="gallery_images[]" accept="image/*" multiple>
                        <label class="custom-file-label" for="galleryImages">Другие фотографии</label>
                    </div>
                </div>

            </div>
        </div>

        <input type="submit" id="submit-post" value="Submit" class="btn btn-primary mt-3 mb-3" style="background-color: #b08d54;">
    </form>

    <div id="response_message"></div>
</section>

<?php get_footer(); ?>
