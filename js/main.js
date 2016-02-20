$(document).ready(function(){
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
    $('#recover-container').on('shown.bs.modal', function () {
        $('#recover').focus()
    });
    $('#form-signup').on('shown.bs.modal', function () {
        $('#name').focus()
    });
    $.ajaxSetup({ cache: false });
    
    $('body').css('min-height', $(window).height()+'px');
    function marquee(){
        $.ajax({
            url: '/php/highlight.php',
            success: function(data){
                $('.bottom').html(data);
            },
            complete: function(){
                setTimeout(marquee, 100000);
            }
        });
    }   
    marquee();

    $('.bottom').css('top', ($(window).height() - 34)+'px');
});

$(document).scroll(function(){
   $('.bottom').css('top', ($(window).height() - 34 + window.pageYOffset)+'px');
   $('.bottom').css('left', window.pageXOffset+'px');
});
$(window).resize(function(){
    $('.bottom').css('top', ($(window).height() - 34 + window.pageYOffset)+'px');
});