<footer>
    <div class="logo-phone">
        <a class="footer-logo" href="/">
            <?php
            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
            ?>
            <img src="<?php echo $image[0]; ?>" width="" height="75">
        </a>
            <div class="phone"> 
                <span class="cons dashicons-phone"></span>
                Téléphone: 09 50 23 62 53
            </div>
            </div>
    <nav class="footer-menu">
    <?php 
        wp_nav_menu( array(
            'theme_location' => 'footer'
        ) );
    ?>
    </nav>
</footer>

<?php wp_footer();?>