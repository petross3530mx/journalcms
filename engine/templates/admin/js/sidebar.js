$("*").load(function() {
	var dHeight = $(document).height();
	var result = 175;
	$("#sidebar").height(dHeight - result);
});