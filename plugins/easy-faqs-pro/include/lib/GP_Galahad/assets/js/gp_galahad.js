var gp_galahad_submit_contact_form = function (f) {
	$ = jQuery;
	
	// initialize the form
	var ajax_url = 'https://goldplugins.com/tickets/galahad/catch.php';
	//f.attr('action', ajax_url);
	
	// show 'one moment' emssage
	var msg = '<p><span class="fa fa-refresh fa-spin"></span><em> One moment..</em></p>';
	var msg_holder = $('.gp_galahad_message');
	msg_holder.html(msg);
	
	// wrap the data in in a form (its current a div), so that it can be serialized via jQuery
	var f = jQuery(f).detach();
	var wrap = f.wrap('<form></form>').parent();
	data = wrap.serialize();
	
	$.ajax(
		ajax_url,
		{
			method: 'post',
			data: data,
			dataType: 'json',
			success: function (ret) {
				msg_holder.html(ret.msg);
			},
			error: function (ret) {
				msg_holder.html("We apologize, but we could not submit your ticket automatically. Please visit https://goldplugins.com/contact/ to submit your ticket through the website.");
			}
		}
	);
	return false; // prevent form from submitting normally
};

var gp_galahad_setup_contact_forms = function() {
	$ = jQuery;
	var forms = $('.gp_support_form_wrapper div[data-gp-ajax-form="1"]');
	if (forms.length > 0) {
		console.log(forms);
		forms.each(function () {
			var f = this;
			var btns = $(this).find('.button[type="submit"]').on('click', 
				function () {
					gp_galahad_submit_contact_form(f);
					return false;
				} 
			);
		});
	}
	jQuery('.gp_ajax_contact_form').on('submit', gp_galahad_submit_contact_form);
};

jQuery( function() { 
	gp_galahad_setup_contact_forms();
});