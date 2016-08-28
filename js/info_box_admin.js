jQuery(document).ready(function($) {

	var checked_info_box_title = jQuery('#grad_info_box_title').attr("checked");

	if (checked_info_box_title =='checked')
	{	
				jQuery('#coderlol_info_box_title_color_grad').css('visibility', '');
				jQuery('#coderlol_info_box_title_color_grad').css('width', '50%');
				jQuery('#coderlol_info_box_title_grad_position').css('visibility', '');
				jQuery('#coderlol_info_box_title_grad_position').css('width', '50%');
				jQuery('#coderlol_info_box_title_grad_position').css('position', 'inherit');
	}
	else
	{
				jQuery('#coderlol_info_box_title_color_grad').css('visibility', 'hidden');				
				jQuery('#coderlol_info_box_title_color_grad').css('width', '0%');
				jQuery('#coderlol_info_box_title_grad_position').css('visibility', 'hidden');
				jQuery('#coderlol_info_box_title_grad_position').css('width', '0%');	
				jQuery('#coderlol_info_box_title_gead_position').css('position', 'absolute');		
	}


	var checked_info_box_content = jQuery('#grad_info_box_content').attr("checked");

	if (checked_info_box_content =='checked')
	{

				jQuery('#coderlol_info_box_content_color_grad').css('visibility', '');
				jQuery('#coderlol_info_box_content_color_grad').css('width', '50%');
				jQuery('#coderlol_info_box_content_grad_position').css('visibility', '');
				jQuery('#coderlol_info_box_content_grad_position').css('width', '50%');
				jQuery('#coderlol_info_box_content_grad_position').css('position', 'inherit');
	}
	else
	{
				jQuery('#coderlol_info_box_content_color_grad').css('visibility', 'hidden');				
				jQuery('#coderlol_info_box_content_color_grad').css('width', '0%');
				jQuery('#coderlol_info_box_content_grad_position').css('visibility', 'hidden');
				jQuery('#coderlol_info_box_content_grad_position').css('width', '0%');	
				jQuery('#coderlol_info_box_content_grad_position').css('position', 'absolute');	
	}




	jQuery('#grad_info_box_title').change( function () {

			var visible_info_box_title = jQuery('#coderlol_info_box_title_color_grad').css('visibility');
			if (visible_info_box_title=='hidden')
			{
				jQuery('#coderlol_info_box_title_color_grad').css('visibility', '');
				jQuery('#coderlol_info_box_title_color_grad').css('width', '50%');
				jQuery('#coderlol_info_box_title_grad_position').css('visibility', '');
				jQuery('#coderlol_info_box_title_grad_position').css('width', '50%');
				jQuery('#coderlol_info_box_title_grad_position').css('position', 'inherit');
				jQuery('#coderlol_info_box_title_grad_position').val('');

			}
			else
			{	
				jQuery('#coderlol_info_box_title_color_grad').css('visibility', 'hidden');				
				jQuery('#coderlol_info_box_title_color_grad').css('width', '0%');
				jQuery('#coderlol_info_box_title_grad_position').css('visibility', 'hidden');
				jQuery('#coderlol_info_box_title_grad_position').css('width', '0%');	
				jQuery('#coderlol_info_box_title_gead_position').css('position', 'absolute');
				jQuery('#coderlol_info_box_title_grad_position').val('');			
			}




	});


	jQuery('#grad_info_box_content').change( function () {

			var visible_info_box_content = jQuery('#coderlol_info_box_content_color_grad').css('visibility');
			if (visible_info_box_content=='hidden')
			{
				jQuery('#coderlol_info_box_content_color_grad').css('visibility', '');
				jQuery('#coderlol_info_box_content_color_grad').css('width', '50%');
				jQuery('#coderlol_info_box_content_grad_position').css('visibility', '');
				jQuery('#coderlol_info_box_content_grad_position').css('width', '50%');
				jQuery('#coderlol_info_box_content_grad_position').css('position', 'inherit');
				jQuery('#coderlol_info_box_content_grad_position').css('position', 'inherit');
				jQuery('#coderlol_info_box_content_grad_position').val('');

			}
			else
			{	
				jQuery('#coderlol_info_box_content_color_grad').css('visibility', 'hidden');				
				jQuery('#coderlol_info_box_content_color_grad').css('width', '0%');
				jQuery('#coderlol_info_box_content_grad_position').css('visibility', 'hidden');
				jQuery('#coderlol_info_box_content_grad_position').css('width', '0%');	
				jQuery('#coderlol_info_box_content_grad_position').css('position', 'absolute');	
				jQuery('#coderlol_info_box_content_grad_position').val('');		
			}




	});


	var current_uploadID = '';


	jQuery('#upload_image_url_info_box').click(function() {

		current_uploadID = jQuery(this).prev('input');

		formfield = jQuery('#upload_image').attr('name');	

		tb_show('Загрузка фонового изображения', 'media-upload.php?type=image&TB_iframe=true&post_id=0', false);

		window.send_to_editor = function(html) {
			var image_url = jQuery('img',html).attr('src');
			current_uploadID.val(image_url);
			if ( current_uploadID.attr('id') == 'url_info_box_title_bg' )
				{
					jQuery('#current_title_image').html( function() {
						return '<img src=' + image_url + ' style="max-width: 250px; max-height: 250px;">';
					});
				}
			else if (current_uploadID.attr('id') == 'url_info_box_content_bg' )
				{
					jQuery('#current_desk_image').html( function() {
						return '<img src=' + image_url + ' style="max-width: 250px; max-height: 250px;">';
					});
				}
    		tb_remove();
		}

		return false;

	});




});