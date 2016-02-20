$('#confirmbox').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var recipient = button.data('whatever');
  var modal = $(this);
  $.ajax({
    url: '/php/buynew.php?name='+recipient,
    success: function(data){
      modal.find('.modal-body').html(data);
    }
  });
  modal.find('.modal-title').text('Buy Shares from ' + recipient);
  modal.find('.btn-primary').attr('data-title', recipient);
});

$('#confirmsell').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var recipient = button.data('whatever');
  var modal = $(this);
  $.ajax({
    url: '/php/sellnew.php?name='+recipient,
    success: function(data){
      modal.find('.modal-body').html(data);
    }
  });
  modal.find('.modal-title').text('Sell Shares of ' + recipient);
  modal.find('.btn-primary').attr('data-title', recipient);
});

$('#loaner').on('show.bs.modal', function(event){
  var button = $(event.relatedTarget);
  var action = button.data('whatever');
  var modal = $(this);
  modal.find('.btn-primary').html(action);
  if(action === "Apply"){
    $.ajax({
      url: '/php/loandata.php',
      success: function(data){
        modal.find('.modal-body').html(data);
      }
    });
    modal.find('.btn-primary').attr('onclick', 'applyloan();');
  }else{
    $.ajax({
      url: '/php/rloandata.php',
      success: function(data){
        modal.find('.modal-body').html(data);
      }
    });
    modal.find('.btn-primary').attr('onclick', 'payloan();');
  }

});

$(document).ready(function(){
  $('#confirmbox').find('.btn-primary').click(function(){
    buy($(this).attr('data-title'), $('#confirmbox').find('.requirement').val());
    $('#confirmbox').find('.btn-default').click();
  });
  $('#confirmsell').find('.btn-primary').click(function(){
    sell($(this).attr('data-title'), $('#confirmsell').find('.requirement').val());
    $('#confirmsell').find('.btn-default').click();
  });
  $('.openerp').click(function(){
    if($('.passbook').css('display') == 'block'){
      $('.passbook').css('margin-left','-200px');
      setTimeout(function(){
        $('.passbook').css('display','none');
      }, 500);
      $('.openerp').html("<span class='glyphicon glyphicon-forward'></span>");
    }else{
      $('.passbook').css('display', 'block');
      setTimeout(function(){
        $('.passbook').css('margin-left', '0px');
      }, 200);
      $('.openerp').html("<span class='glyphicon glyphicon-backward'></span>");
    }
  });
});

function buy(recipient, requirement){
  var modal = $(this);
  $.ajax({
    url: '/php/buy.php?name='+recipient+'&requirement='+requirement,
    success: function(data){
      $('.chamber').find('.container .alert').remove();
      $('.chamber').find('.container').prepend("<div class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+data+" !</div>");
    }
  });
}

function sell(recipient, requirement){
  $.ajax({
    url: '/php/sell.php?name='+recipient+'&requirement='+requirement,
    success: function(data){
      $('.chamber').find('.container .alert').remove();
      $('.chamber').find('.container').prepend("<div class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+data+" !</div>");
    }
  });
}

function applyloan(){
  var x = $('#loaner').find('.requirement').val();
  $.ajax({
    url: '/php/loanreg.php?requirement='+x+'&tag=1',
    success: function(data){
      $('.chamber').find('.container .alert').remove();
      $('.chamber').find('.container').prepend("<div class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+data+" !</div>");
      $('#loaner').find('.btn-default').click();
    }
  });
}

function payloan(){
  var x = $('#loaner').find('.requirement').val();
  $.ajax({
    url: '/php/loanreg.php?requirement='+x+'&tag=2',
    success: function(data){
      $('.chamber').find('.container .alert').remove();
      $('.chamber').find('.container').prepend("<div class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>"+data+" !</div>");
      $('#loaner').find('.btn-default').click();
    }
  });
}