<div class="movie-detail">
    <header>
        <?php the_field('ttna-movie-original_title') ?>
        (<?php echo substr(get_field('ttna-movie-date'), 0, 4) ?>)
    </header>
    <img class="poster" src="<?php the_post_thumbnail_url() ?>" />
    <div class="overview"><?php the_field('ttna-movie-overview') ?></div>
    <div class="imdb">
        <?php _e('Calificaci&oacute;n en IMDb') ?>: <?php the_field('ttna-movie-vote') ?>
    </div>
</div>
