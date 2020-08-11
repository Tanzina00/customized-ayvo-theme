<?php get_header();?>
    <div class="main-container">
        <div class="container">
            <div class="text-center page-404">
                <h1 class="heading"><?php esc_html_e('404','ayvo');?></h1>
                <h2 class="title"><?php esc_html_e('Oops! That page can\'t be found.','ayvo');?></h2>
                <p><?php esc_html_e('Sorry, but the page you are looking for is not found. Please, make sure you have typed the current URL.','ayvo');?></p>
                <a class="button" href="<?php echo esc_url( get_home_url('/') );?>"><?php esc_html_e('Go to Homepage','ayvo');?></a>
            </div>
        </div>
    </div>
<?php get_footer();?>