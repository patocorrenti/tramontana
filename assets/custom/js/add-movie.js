(function($){
    $(function() {

        if ($('#ttna-movie_list').length) {

            const $list = $('#ttna-movie_list');

            $('#ttna-movie_list .movie').click(function(){
                $('#ttna-movie_list .movie').removeClass('selected');
                $(this).addClass('selected');
            })
        }

    });
})(jQuery)
