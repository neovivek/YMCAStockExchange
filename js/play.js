google.load('visualization', '1', {packages: ['corechart']});

function drawChart(company) {
  var jsonData = $.ajax({
    url: "/php/getDataC.php?company="+company,
    dataType:"json",
    async: false
  }).responseText;
  var data = new google.visualization.DataTable(jsonData, 0.6);

  var options = {
    width: 650,
    height: 263,
    title: 'Trading chart',
    hAxis: {title: 'Time',
      textStyle: { color: '#01579b', fontSize: 16, fontName: 'Arial', bold: true },
      titleTextStyle: { color: '#01579b', fontSize: 16, fontName: 'Arial', bold: true }
    },
    vAxis: {
      textStyle: { color: '#1a237e', fontSize: 16, fontName: 'Arial', bold: true }
    },
    colors: ['#a52714'],
    backgroundColor: '#E4E4E4 '
  };

  var chart = new google.visualization.LineChart(document.getElementById('ex4'));

  chart.draw(data, options);
}

$(document).ready(function(){
  $('.comp').click(function(){
    var target = $(this).attr('data-target');
    $('.data').html("<h3>Loading ...</h3>");
    $.ajax({
      url: '/php/companydata.php?company='+target,
      success: function(data){
        $('.data').html(data);
        $('.data').scrollTop = $('.data').scrollHeight;
      },
      complete: function(){
        drawChart(target);
      }
    });
  });
});