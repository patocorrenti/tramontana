<div class="ttna-search_movie">
    <?php if (is_object($movies) && is_array($movies->results)) : ?>
        <h3 class="title"><?php _e('Selecciona la pel&iacute;cula', 'tramontana') ?></h3>
        <?php if (count($movies->results)) : ?>
        <form action="" method="post">
            <ul class="movie_list" id="ttna-movie_list">
            <?php foreach($movies->results as $movie) : ?>
                <li>
                    <article class="movie">
                        <div class="image">
                            <?php if ($movie->poster_path) : ?>
                                <img src="http://image.tmdb.org/t/p/w185/<?php echo $movie->poster_path ?>" alt="">
                            <?php endif ?>
                        </div>
                        <div class="data">
                            <header>
                                <h5 class="name"><?php echo $movie->title ?></h5>
                                <div class="date"><?php echo substr($movie->release_date, 0, 4) ?></div>
                            </header>
                            <div class="desc">
                                <?php echo $movie->overview ?>
                            </div>
                            <input class="add" type="submit" value="Agregar" name="<?php echo $movie->id ?>">
                        </div>
                    </article>
                </li>
            <?php endforeach ?>
            </ul>
        </form>
        <?php else : ?>
            No se encontró nada
        <?php endif ?>
    <?php endif ?>
    <form action="" method="post" class="search_movie_form">
        <?php wp_nonce_field( 'ttna_search_movie') ?>
        <input type="text" value="" name="search_movie" placeholder="<?php _e('Nombre de la pel&iacute;cula', 'tramontana') ?>">
        <button type="submit">
            <?php _e('Buscar', 'tramontana') ?>
        </button>
    </form>
</div>
