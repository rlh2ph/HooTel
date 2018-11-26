var bg_images = ["img/header.jpg", "img/header1.jpg", "img/header2.jpg", "img/header3.jpg"];

$(".dot").click(function(){
	clearTimeout(timer);
	var slide = $(this).attr('data-slide') - 1;
	//Preload again in case page size changed
	var preimg = new Image();
	preimg.src = bg_images[slide];
	preimg.onload = function(){
		$("#homepage-header").css('background-image', "url(" + bg_images[slide] + ")");
	}
	$("#dot-div span").removeClass("dot-active");
	$(this).addClass("dot-active");
	timer = setTimeout("header_bg_change()", 5000);
});

function header_bg_change(){
	var cur_slide = $("#dot-div .dot-active").attr("data-slide") - 1;
	$("#dot-" + (cur_slide + 1)%4).click();	
};

var timer = setTimeout("header_bg_change()", 5000);
