<?php
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php get_template_part( 'sidebar-templates/sidebar', 'footerfull' ); ?>

    <footer class="site-footer pt-3 pb-1 mt-5" id="wrapper-footer">
    
    	<div class="<?php echo esc_attr( $container ); ?>">
    
    		<div class="row">
    
    			<div class="col-md-6">

    					<div class="site-info">
    					    <?php
                            if ( ! has_custom_logo() ) { ?>

                            	<?php if ( is_front_page() && is_home() ) : ?>
                            
                            		<h1 class="navbar-brand mb-0">
                            			<a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
                            				<?php bloginfo( 'name' ); ?>
                            			</a>
                            		</h1>
                            
                            	<?php else : ?>
                            
                            		<a class="navbar-brand" rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" itemprop="url">
                            			<?php bloginfo( 'name' ); ?>
                            		</a>
                            
                            	<?php endif; ?>
                            
                            	<?php
                            } else {
                            	the_custom_logo();
                            } ?>
    					</div>
    
    			</div>
    			<div class="col-md-6">
    			    <p class="text-center text-white">&copy; 2024 RealEstate. All rights reserved.</p>
    			</div>
    		</div>
    
    	</div>
    
    </footer>

</div>

<?php wp_footer(); ?>

</body>

</html>

