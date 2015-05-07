$(document).ready(function(){
	page.page_load();
	page.events();
	page.stepy();
});
page = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
		tinymce.init({
			selector: ".content-body"
		});
	},
	stepy: function() {
		$("#deliveryStepy li a").click(function(e){
			previous_step = $("#deliveryStepy .active");
			e.preventDefault();
			var href = $(this).attr('href');
			$("#deliveryStepy li").removeClass('active');
			$(this).parents('li:first').addClass('active');
			$(".steps").addClass('hide');
			$(href).removeClass('hide');
			// if ((href == "#billingInfo")) {
			// 	if (previous_step.hasClass('customerInfo') || previous_step.hasClass('menuSelection')) {
			// 	}
			// }
		});

		$(".next").click(function(){

			$("#deliveryStepy .active").next('li').addClass('row-active');
			$("#deliveryStepy li").removeClass('active');
			$(document).find(".row-active").addClass('active').removeClass('row-active');
			var href = $(document).find('#deliveryStepy .active a').attr('href');
			$(".steps").addClass('hide');
			$(href).removeClass('hide');
	// if($(this).attr('step') == 4) {//this step is billing info
	// 	setDeliveryAddress();
	// }

});
		$(".previous").click(function(){
			$("#deliveryStepy .active").prev('li').addClass('row-active');
			$("#deliveryStepy li").removeClass('active');
			$(document).find(".row-active").addClass('active').removeClass('row-active');
			var href = $(document).find('#deliveryStepy .active a').attr('href');
			$(".steps").addClass('hide');
			$(href).removeClass('hide');
	// if($(this).attr('step') == 5) {//coming from deliverySetup
	// 	updateBillingInfo();
	// }
});
	},
	events: function(){
		$('#title').friendurl({id : 'url'});
		$(document).on('click','#content .panel',function(){
			$(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
			$(this).removeClass('panel-default').addClass('panel-success');
		});
$("#add-content").click(function(){
	var content_set_count = $(document).find('#content .panel-collapse').length;
	$(document).find('#content .panel-collapse').removeClass('in');
	$(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
	request.add_content(content_set_count);
});
$("#preview-btn").click(function(){
			// var serialized_data = $("#add-form").serialize();
			// request.load_preview(serialized_data);
		});

}
};
request = {
	add_content: function(content_set_count) {
		
		var token = $('meta[name=_token]').attr('content');
		$.post(
			'/pages/content-add',
			{
				"_token": token,
				"content_set_count": content_set_count
			},
			function(results){
				var status = results.status;
				var html = results.html;
				switch(status) {
					case 200: // Approved

					$('#content_count').val((content_set_count--));
					$('.content-area').append(html);
					tinymce.init({
						selector: ".content-body"
					});
					break;

					default:
					break;
				}
			}
			);
	}
	// load_preview: function(serialized_data) {
	// 	var token = $('meta[name=_token]').attr('content');
	// 	$.post(
	// 		'/pages/load-preview',
	// 		{
	// 			"_token": token,
	// 			"serialized_data": serialized_data
	// 		},
	// 		function(results){
	// 			var status = results.status;
	// 			// var html = results.html;
	// 			switch(status) {
	// 				case 200: // Approved

	// 				break;


	// 				default:
	// 				break;
	// 			}
	// 		}
	// 		);
	// }
};
