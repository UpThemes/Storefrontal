;(function($){
	
	$(document).ready(function() {
		
		
		$slide_container = $('<div id="slide_container"><div id="slide-preview">Below is a preview of the current slide image (scaled to fit this page):</div></div>');
	
		if( $(".show-image").find("img").length ){
			$("#titlediv").after($slide_container);
			$("#slide_container").append($(".show-image"));
			$("#set-post-thumbnail").html("Upload new featured image");
		}
		
		$('.remove-post-thumbnail').live('click', function(){
			$('.show-image').html('');
		});
	
		$('.wp-post-thumbnail').live('click',function(e){
			
			var this_id = $(this).attr('id').match(/\d+$/);
			
			$.getJSON(ajaxurl,{ id : this_id, action : "get_post_thumbnail" },function(data){

				if( !parent.jQuery('#post-body #slide_container').length ){
					parent.jQuery("#titlediv").after($slide_container);
					parent.jQuery("#slide_container").append(parent.jQuery(".show-image"));
				}
	
				if( data.img ){
					parent.jQuery(".show-image").html(data.img);
					parent.jQuery(".show-image").parents("#slide_container").show();
					parent.jQuery("#set-post-thumbnail").delay(1000).html("Upload new featured image");
				} else
					parent.jQuery(".show-image").html('<div class="message error">There was an error with your request. Please reload the page and try again.</div>');

			});

		});

		$('#remove-post-thumbnail').live('click',function(e){
			e.preventDefault();
			parent.jQuery(".show-image").parents("#slide_container").hide();
			parent.jQuery("#set-post-thumbnail").html("Upload new featured image");
		});
		
		var siteurl = $('#slide_hidden').attr('value');
		
		$('#slide_related_content').change(function() {
			var postid = $(this).val();
			var posttitle = $(this).find('option:selected').text();
			$.post(siteurl + "/admin-ajax.php",  { action:"up_ajax_populate", 
				'cookie': encodeURIComponent(document.cookie), pid: postid, posttitle: posttitle
				}, function(xml) {
					var obj = $(xml);
					obj.find('supplemental').each(function() {
						var link = $(this).find('guid').text();
						var excerpt = $(this).find('content').text();
							$('#slide_blurb').attr('value',excerpt);	
							$('#slide_link').attr('value',link);
					});
					}, 'xml');
		});
		
		$('.attachment').each(function() {
			var attach = $(this);
			attach.find('#update_key').live('click',function(e) {
				e.preventDefault();
				var meta_id = attach.find('#old_meta_id').attr('value');
				var new_val = attach.find('#acf_input').attr('value');
				var messageZone = attach.find('#update-message');
				$('#update-message').html('test'+meta_id);
				$.post('admin-ajax.php',  { 
						action:"up_ajax_update_key", 
						'cookie': encodeURIComponent(document.cookie),
						meta_id:meta_id,
						new_val:new_val
					}, 
					function(xml) {
						var obj = $(xml);
						var message = obj.find('response_data').text();
							messageZone.html('<div id="output">' + message + '<\/div>');
							messageZone.fadeIn(1000, function() {
								setTimeout(function() {
									messageZone.fadeOut('fast');
								}, 2000);
							});
							obj.find('supplemental').each(function() {
							
							});
						}, 
					'xml')
					});
	
					
			});
	});

})(jQuery);