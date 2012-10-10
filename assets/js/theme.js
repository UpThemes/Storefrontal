function initDropDown()
{
	var nav = document.getElementById("nav");
	if(nav) {
		var lis = nav.getElementsByTagName("li");
		for (var i=0; i<lis.length; i++) {
			if(lis[i].getElementsByTagName("ul").length > 0) {
				lis[i].className += " drop-down"
			}
		}
	}
}

//Page init scripts
jQuery(document).ready(function($){
	
	initDropDown();
	
	$('#content').fitVids();
  
  $('.gallery').each(function(i){
    var gallery_items = $(this).find('img').length;
    $(this).addClass('gallery-count-'+gallery_items);
    $(this).find('br').remove();
    $(this).append('<br clear="both">');
  });

});