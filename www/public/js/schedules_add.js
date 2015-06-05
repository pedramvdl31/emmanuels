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

	$("#searchCustomerNavTabs a").click(function(e){

		e.preventDefault();
		var tab_href = $(this).attr('href');
		$("#searchCustomerNavTabs li").removeClass('active');
		$(this).parents('li:first').addClass('active');
		$(".customerListDiv").addClass('hide');
		$(tab_href).removeClass('hide');
		if(tab_href == '#customerGuests') {
			$("#userSearchTable").addClass('hide').find("tbody").html('');
			// deliveries.remove_customer_info_data();
		}
	});

		$("#searchBy").change(function(){
			var search = $(this).find('option:selected').val();
			$(".searchByFormGroup").addClass('hide');
			$("#searchBy-"+search).removeClass('hide');
		});
		$("#title").on("change", function () {
			$('#url').val("/"+urlfriendly($("#title").val()));
		});

		$(document).on('click','#content .panel',function(){
			$(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
			$(this).removeClass('panel-default').addClass('panel-success');
		});

		$(document).on('click','.minus-q',function(){
			var qty = parseInt($(this).parents('.input-group:first').find('input').val());
			var new_qty = 0;
			if (qty > 0) {
				new_qty = qty - 1;
			};
			
			$(this).parents('.input-group:first').find('input').val(new_qty);

			//ajax
			if ( ($('#select-make').val() != "") || ($('#select-item').val() != "") ) {
				alert($('#select-make').val());
			};


		});

		$(document).on('click','.add-q',function(){
			var qty = parseInt($(this).parents('.input-group:first').find('input').val());
			var new_qty = 0;
			var new_qty = qty + 1;

			$(this).parents('.input-group:first').find('input').val(new_qty);
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
		$("#title").keyup(function(){
			var have_error = false; 
			var name_array = $(window.controller_names);
			var dup_val = "";
			var enterd_title = $(this).val();
			jQuery.each( name_array, function( i, val ) {
				if (val == enterd_title && val != "") {
					dup_val = val;
					have_error = true;
				};
			});
			if (have_error == true) {
				$(this).parents('.form-group:first').addClass('has-error');
				$(this).parents('.form-group:first').find('#title-duplicate').removeClass('hide');
				$('#accordion-pro').collapse('show');
				$(document).find('#labels-div .'+dup_val).removeClass('label-default').addClass('label-danger');
				$('.submit-btn').addClass('disabled');
			} else {
				$(this).parents('.form-group:first').removeClass('has-error');
				$(this).parents('.form-group:first').find('#title-duplicate').addClass('hide');
				$(document).find('#labels-div .label').removeClass('label-danger').addClass('label-default');
				$('.submit-btn').removeClass('disabled');
			}
		});
		$(document).on('click','.remove-collapse',function(){

			// console.log($(document).find('.content-area .content-set').length);
			var count = 1;
			$( ".content-area .content-set" ).each(function( index ) {
				$(this).find('.panel-title a .this-title').html('Content '+count);
				count++;
			});
			var this_set = $(this).parents('.content-set').attr('this_set');

			tinymce.remove('#content-body-'+this_set);
			$(this).parents('.content-set:first').remove();
			var count = $('#content_count').val();
			re_count = (count == 0) ? null : count--;

			$('#content_count').val(re_count);
		});

		$(".searchByButton").click(function(){
			var company_id = $("#company_id").val();
			var type = $(this).parents('.searchByFormGroup:first').attr('id').replace('searchBy-','');
			search = {};
			search[type] = {};

			$(this).parents('.searchByFormGroup:first').find('.searchInputItem').each(function(e){
				var name = $(this).attr('name');
				search[type][name] = $(this).val();

			});
			request.search_users(company_id,search);

		});

	}
};
request = {
	search_users: function(company_id, search) {
		var token = $('meta[name=_token]').attr('content');
		$.post(
			'/users/request-users',
			{
				"_token": token,
				company_id: company_id,
				search: search
			},
			function(result){
				var status = result.status;
				// var message = result.message;
				var table_tbody = result.users_tbody;
				$("#userSearchTable").removeClass('hide');
				$("#userSearchTable tbody").html(table_tbody);
						$(document).find("#userSearchTable tbody tr").click(function(){
			var user_id = $(this).find('.checkUser').val();
			if($(this).find('.checkUser:checked').length === 0) {
				$(this).addClass('success').find('.checkUser').prop('checked',true);
				$(document).find('#userSearchTable tbody tr:not(.success)').addClass('hide');
				// request.set_user(user_id);
				
			} else {
				$(this).removeClass('success').find('.checkUser').removeAttr('checked');
				// deliveries.remove_customer_info_data();
			}
			
		});
				// deliveries.search_customer_events();
			}
			);
	},
	add_content: function(content_set_count) {
		
		var token = $('meta[name=_token]').attr('content');
		$.post(
			'/schedules/order-add',
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

					break;

					default:
					break;
				}

			}
			);
	}
};
function urlfriendly(url)
{
	url = url
	.toLowerCase() // change everything to lowercase
	.replace(/^\s+|\s+$/g, "") // trim leading and trailing spaces		
	.replace(/[_|\s]+/g, "-") // change all spaces and underscores to a hyphen
	.replace(/[^a-z\u0400-\u04FF0-9-]+/g, "") // remove all non-cyrillic, non-numeric characters except the hyphen
	.replace(/[-]+/g, "-") // replace multiple instances of the hyphen with a single instance
	.replace(/^-+|-+$/g, ""); // trim leading and trailing hyphens
	return url;
}