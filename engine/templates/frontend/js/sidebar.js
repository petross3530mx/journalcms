//фильтрация по 1 столбцу
   	function filter1 (phrase, _id){
		var words = phrase.value.toLowerCase().split(" ");
    console.log(words);
		var table = document.getElementById(_id);
    console.log(table);
		for (var r = 1; r < table.rows.length; r++){ //сколько строк сверху не фильтровать
			var cellsV = table.rows[r].cells[0].innerHTML.replace(/<[^>]+>/g,""); // 1 столбец для фильтрации
			var cellsV = [cellsV].join(" ");
		    var displayStyle = 'none';
		    for (var i = 0; i < words.length; i++) {
			if (cellsV.toLowerCase().indexOf(words[i])>=0)
				displayStyle = '';
			else {
				displayStyle = 'none';
				break;
			}
			}
		table.rows[r].style.display = displayStyle;
		}
	}

//фильтрация по 2 столбцу
	function filter11 (phrase, _id){
		var words = phrase.value.toLowerCase().split(" ");
		var table = document.getElementById(_id);
		for (var r = 1; r < table.rows.length; r++){ //сколько строк сверху не фильтровать
			var cellsV = table.rows[r].cells[1].innerHTML.replace(/<[^>]+>/g,""); // 2 столбец для фильтрации
			var cellsV = [cellsV].join(" ");
		    var displayStyle = 'none';
		    for (var i = 0; i < words.length; i++) {
			if (cellsV.toLowerCase().indexOf(words[i])>=0)
				displayStyle = '';
			else {
				displayStyle = 'none';
				break;
			}
			}
		table.rows[r].style.display = displayStyle;
		}
	}


  //фильтрация по 2 столбцу
  function filter3 (phrase, _id){
    var words = phrase.value.toLowerCase().split(" ");
    console.log(words);
    var table = document.getElementById(_id);
     console.log(table);
    for (var r = 1; r < table.rows.length; r++){ //сколько строк сверху не фильтровать
      var cellsV = table.rows[r].cells[2].innerHTML.replace(/<[^>]+>/g,""); // 2 столбец для фильтрации
      var cellsV = [cellsV].join(" ");
      console.log(cellsV);
        var displayStyle = 'none';
        for (var i = 0; i < words.length; i++) {
      if (cellsV.toLowerCase().indexOf(words[i])>=0)
        displayStyle = '';
      else {
        displayStyle = 'none';
        break;
      }
      }
    table.rows[r].style.display = displayStyle;
    }
  }




function sortTable(n, k) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById(k);
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.getElementsByTagName("TR");
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch= true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}




$(document).ready(function(){
  $('.acord1').click(function(){
    $(this).parent().children('.inf').toggleClass('hideblock');
  });
    $('.thisselect').change(function() {
        this.form.submit();
    });
  $("#filter").click(function(){
    console.log('ddddd');
    $(this).toggleClass("filtre");
    $("#tbl").toggleClass("hide-table");
});

  $(".checkmark").click(function(){
  $(this).parent().parent().parent().toggleClass("hide");
});

$('.sel-year').on('change', function(){
  vl=$(this).val()
  $('.cawpr').children('div').attr('class', vl);
});
$('.sel-sem').on('change', function(){
  vl=$(this).val()
  $('.cawpr').children('div').children('div').attr('class', vl);
});
$('.sel-dubj').on('change', function(){
  vl=$(this).val()
  $('.cawpr').children('div').children('div').children('div').attr('class', vl);
});

})
