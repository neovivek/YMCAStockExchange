$(document).ready(function(){ 
    $('.chamber').on('click', '.logout', function(){
        $.ajax({
            url: '/php/error.php',
            success: function(){
                $.removeCookie('username');
                FB.logout();
                window.location = '/';
            }
        });
    });
  $('.open').click(function(){
    $('.reply').css('display', 'none');
    var target = $(this).attr('data-target');
    if($(target).css('display') == 'block'){
      $(target).css('display', 'none');
    }else{
      $(target).css('display', 'block');
    }
  });
});

$(document).scroll(function(){
    var x = window.pageYOffset;
   $('.nail').css('top', (110 + x)+'px');
});

function update(){
    if($(location).attr('hash') !== "#/market"){ return; }
    $.ajax({
        url: '/php/update.php',
        success: function(data){
            $('.latest_heading').html(data);
        },
        complete: function(){
            setTimeout(update ,4000);
        }
    });
}

function log(){
    $.ajax({
        url: '/php/trans.php',
        success: function(data){
            $('.all_record').html(data);
        }
    });
}

function profiler(){
    if($(location).attr('hash') !== "#/profile"){ return; }
    $.ajax({
        url: '/php/passbook.php',
        success: function(data){
            $('.passbook').html(data);
        }
    });
    $.ajax({
        url: '/php/shares.php',
        success: function(data){
            $('.profile').html(data);
        },
        complete: function(){
            setTimeout(profiler, 6000);
        }
    });
}
function board(){
    $.ajax({
        url: '/php/leader.php',
        success: function(data){
            $('.board').html(data);
        },
        complete: function(){
            setTimeout(board, 3000);
        }
    });
}