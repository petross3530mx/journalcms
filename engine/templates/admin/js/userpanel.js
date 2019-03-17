$(".user-interface-panel").css({
	"width":" 186px",
	"height":" 27px",
	"color":" #818181",
	"font-size":" 12px",
	"background":" url(engine/templates/phpandmysqlpattern/images/authline.png) no-repeat",
	"border":" none",
	"margin-left":" 7px",
	"padding":" 0 10px"
});

function loginClearValue() {
	var start = "Логин";
	var id = "u-name";
	var valueParam = $("#" + id);
	if(valueParam.val() == start) {
		valueParam.val("");
	}
	
}

function passwordClearValue() {
	var start = "Пароль";
	var id = "u-password";
	var valueParam = $("#" + id);
	if(valueParam.val() == start) {
		valueParam.val("");
	}
	
}

function searchClearValue() {
	var start = "Поиск";
	var id = "search-line";
	var valueParam = $("#" + id);
	if(valueParam.val() == start) {
		valueParam.val("");
	}
	
}

$("#u-auth").css({
	"border":" none",
	"background":" url(engine/templates/phpandmysqlpattern/images/authbtn.png) no-repeat",
	"width":" 82px",
	"height":" 27px",
	"cursor":" pointer"
});

$("#search").css({
	"position":" absolute",
	"top":" 70px",
	"right":" 30px"
});
//efefef
$("#search-line").css({
	"width":" 200px",
	"height":" 34px",
	"background-color":" #efefef",
	"border":" none",
	"padding":" 0 15px",
	"color":" #ccc"
});

$("#search-btn").css({
	"width":" 36px",
	"height":" 34px",
	"background":" url(engine/templates/phpandmysqlpattern/images/searchstring.png) no-repeat",
	"cursor":" pointer",
	"padding":" 0px",
	"margin-left":" -2px",
	"border":"none",
	"margin-top":"1px"
});

$("#search table td").css({
	"padding":" 0px",
	"margin":" 0px"
});

$("#search table tr").css({
	"padding":" 0px",
	"margin":" 0px"
});

$(".input-search").css({
	"border":"1px solid #ccc",
	"color":"#ccc",
	"background":"#eee",
	"padding":"10px"
});

$(".input-search[type=text]").css({
	"width":"300px",
	"color":"#777"
});