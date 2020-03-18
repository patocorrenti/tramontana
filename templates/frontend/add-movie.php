<?php if (is_object($movies) && is_array($movies->results)) : ?>
    <?php if (count($movies->results)) : ?>
    <ul class="tramontana-movie_list">
    <?php foreach($movies->results as $movie) : ?>
        <li>
            <article>
                <header>
                    <h5><?php echo $movie->title ?></h5>
                    <div>(<?php echo substr($movie->release_date, 0, 4) ?>)</div>
                </header>
                <img src="http://image.tmdb.org/t/p/w185/<?php echo $movie->poster_path ?>" alt="">
                <div>
                    <?php echo $movie->overview ?>
                </div>
            </article>
        </li>
    <?php endforeach ?>
    </ul>
    <?php else : ?>
        No se encontró nada
    <?php endif ?>
<?php endif ?>
<form action="" method="post">
    <input type="text" value="" name="search_movie">
    <button>
        BUSCAR
    </button>
</form>
