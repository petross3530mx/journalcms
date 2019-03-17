$.fn.hasAttr = function(name) {
   return this.attr(name) !== undefined;
};
$(document).ready(function(){
  $('.thisselect').change(function() {
      this.form.submit();
  });

$('#changator1').change(function(){
  min = $(this).children("option:selected").attr('first');
  max = $(this).children("option:selected").attr('last');
  
 $('#changator2').attr('min', min );
 $('#changator2').attr('max', max );
});


$(".rowchange").click(function(){



  touk= $(this).children('.ua').html();

  toru= $(this).children('.ru').html();

  toen= $(this).children('.en').html();

  toval = $(this).attr('value');

  $('#en').val(toen);
  $('#ru').val(toru);
  $('#uk').val(touk);
  $('#num').val(toval);


});


            $("#search").keyup(function(){
                _this = this;
                $.each($("#mytable tbody tr"), function() {
                    if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                       $(this).hide();
                    else
                       $(this).show();
                });
            });





$('#smx').click(function(){

kind=$('#kind').val();
label=$('#label').val();
ls=$('#datepicker2').val();
d=$('#smx').val();
mys='index.php?option=editjournal&k='+kind+'&l='+label+'&d='+d+'&ls='+ls;


        $.ajax({method: 'post', url: mys  ,
             data: {'updx2': '0' },
             success: function(data) {
                console.log('sucsess-sql-upd');
                 }
            });


});



$('.iklk .vis').click(function(){

  kind=$(this).attr("data-kind");
  label=$(this).attr("data-label");
  datatimedate=$(this).attr("data-timedate");
  did=$(this).attr("data-id");

  $('#kind').val(kind);
  $('#label').val(label);
  $('#datepicker2').val(datatimedate);
  $('#smx').val(did);
});




  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })



    $(".rem").click(function(){

      thiscol=$(this).attr('col');


      col=$(this).index();

      varx='td:eq('+col+')';

      console.log('clickedplus ' + col);

      $('.tablex tr').find(varx).empty();

    	console.log('clickedplus');
              mys='index.php?option=editjournal&del='+thiscol;
              $.ajax({method: 'post', url: mys  ,
              data: {'datarows': 'datarows','ajax': true },
              success: function(data) {
                console.log('sql-trunk');
                 }
            });

    });

        $(".rom").click(function(){

      thiscol=$(this).attr('col');


      col=$(this).index();

      varx='td:eq('+col+'), th:eq('+col+')';

      console.log('clickedplus ' + col);

      $('.tablex tr').find(varx).remove();

      console.log('clickedplus');
              mys='index.php?option=editjournal&rem='+thiscol;
              $.ajax({method: 'post', url: mys  ,
              data: {'datarows': 'datarows','ajax': true },
              success: function(data) {
                console.log('sql-trunk');
                 }
            });

    });


      $(document).ready(function() {
    $( "#datepicker" ).datepicker();
    $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  } );

            $(document).ready(function() {
    $( "#datepicker2" ).datepicker();
    $( "#datepicker2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
  } );

      $(".vivibilitytd span").click(function(){
        clx=$(this).attr('class');
        console.log(clx);
        if(clx=='novizible0'){
          $(this).removeClass("novizible0");
          $(this).siblings().removeClass("vizible0");
          $(this).siblings().addClass("vizible1");
          $(this).addClass("novizible1");
          //updx=$(this).parent().attr('value');
          //console.log(updx);
          mys='index.php?option=editjournal';

        }
        else if(clx=="vizible1")       {
          $(this).removeClass("vizible1");
          $(this).siblings().addClass("novizible0");
          $(this).siblings().removeClass("novizible1");
          $(this).addClass("vizible0");


        }

        $.ajax({method: 'post', url: 'index.php?option=editjournal'  ,
             data: {'updx': $(this).parent().attr('value'),'ajax': true },
             success: function(data) {
                console.log('sucsess-sql-insert');
                 }
            });



      }),
      $(".markinput").on("keyup" , function(){

      	idx=$(this).parent().parent().parent().parent().attr("idx");
      	console.log('idx:'+idx);

      	datarows=$(this).parent().attr("datarows");
      	console.log('datarows:'+datarows);

      	value=$(this).val();
      	console.log('value:'+value);

      	valx=$(this).attr("value");
        student=$(this).parent().parent().attr("student");
        console.log('valx:'+valx);

        $(this).attr("value", $(this).val());

        mys='';
        mys = "index.php?option=editjournal&id="+idx+"&datarows="+datarows+"&student="+student+"&value="+value+"&idx="+idx+"&up=k";


        if($(this).hasAttr('update')) {
            console.log('значення не пустує');
            mys = "index.php?option=editjournal&id="+idx+"&datarows="+datarows+"&student="+student+"&value="+value+"&idx="+idx+"&up=k";
            console.log(mys);
            console.log('оновлено');
        } else {
            console.log('значення пустує');
            mys = "index.php?option=editjournal&id="+idx+"&datarows="+datarows+"&student="+student+"&value="+value+"&idx="+idx;
            console.log(mys);
            console.log("вставлено");
        }


        $.ajax({method: 'post', url: mys  ,
             data: {'datarows': datarows,'ajax': true },
             success: function(data) {
                console.log('sucsess-sql1');
                 }
            });







    });

  var score=0;
      $('.hook tr td ').each(function(){
  score += +this.textContent;
  console.log(score);

}); 

jxx=0;
$('.undersumm').each(function(){

  $(this).parent().children('.vis').children('input').each(function(){
    var el= parseInt( $(this).val() );
    if(!isNaN(el)){
      jxx += el;
    }
    console.log(jxx);
  });
  $(this).html(jxx);    
  jxx=0;                                    
});

 
 




});
