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

		// $(document).on('click','.remove-btn',function(){
		// 	var id = $(this).parents('.modal:first').attr('menu-id');
		// 	$("#form-"+id).submit();
		// });

		$("#add-content").click(function(){
			var content_area = null ;
			request.add_content(content_area);
		});

	}
};
request = {
	add_content: function(content_area) {
		var token = $('meta[name=_token]').attr('content');
		$.post(
			'/pages/content-add',
			{
				"_token": token,
				"content_area": content_area
			},
			function(results){
				var status = results.status;
				var html = results.html;
				switch(status) {
					case 200: // Approved
						
					break;

					default:
					break;
				}
			}
			);
	}
};
