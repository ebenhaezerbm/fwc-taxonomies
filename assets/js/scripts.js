( function ($) {
    $(document).on('click', '.fa-plus-square-o', function(){
         $(this).attr('class', 'fa fa-minus-square-o has-child');
         $(this).siblings('ul').css('display','block');
    });

    $(document).on('click', '.has-child', function(){
         $(this).attr('class', 'fa fa-plus-square-o');
         $(this).siblings('ul').css('display','none');
    });
}(jQuery));