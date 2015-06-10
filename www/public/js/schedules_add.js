$(document).ready(function() {
	page.page_load();
	page.events();
	page.stepy();
	page.validation();
});
page = {
	page_load: function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
			}
		});

		
	},
	stepy: function() {
		$("#deliveryStepy li a").click(function(e) {
			var href = $(this).attr('href');
			if (!($(this).parents('li:first').hasClass('disabled'))) {
				previous_step = $("#deliveryStepy .active");
				e.preventDefault();
				$("#deliveryStepy li").removeClass('active');
				$(this).parents('li:first').addClass('active');
				$(".steps").addClass('hide');
				$(href).removeClass('hide');
				if ((href == "#information")) {
					if ($('#user_id').val() != "") {
					// check_all_inputs();
				};
			}
		} else {
			if ((href == "#content")) {
				check_all_inputs();
			}
		}
	});

		$(".next").click(function() {

			$("#deliveryStepy .active").next('li').addClass('row-active');
			$("#deliveryStepy li").removeClass('active');
			$(document).find(".row-active").addClass('active').removeClass('row-active');
			var href = $(document).find('#deliveryStepy .active a').attr('href');
			$(".steps").addClass('hide');
			$(href).removeClass('hide');
            // if($(this).attr('step') == 4) {//this step is billing info
            // 	setDeliveryAddress();
            // }


            if ($('#user_id').val() != "") {
            	// check_all_inputs();
            };
        });
		$(".previous").click(function() {
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
	events: function() {
		$("#searchCustomerNavTabs a").click(function(e) {
			e.preventDefault();
			var tab_href = $(this).attr('href');
			$("#searchCustomerNavTabs li").removeClass('active');
			$(this).parents('li:first').addClass('active');
			$(".customerListDiv").addClass('hide');
			$(tab_href).removeClass('hide');
			if (tab_href == '#newaddress') {
				$('#tabs_checklist').val('newaddress');
			} else {
				$('#tabs_checklist').val('address');
			}
		});
		$(document).find("#searchBy").change(function() {
			var search = $(this).find('option:selected').val();
			$(".searchByFormGroup").addClass('hide');
			$("#searchBy-" + search).removeClass('hide');
		});
		$("#title").on("change", function() {
			$('#url').val("/" + urlfriendly($("#title").val()));
		});
		$(document).on('click', '#content .panel', function() {
			$(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
			$(this).removeClass('panel-default').addClass('panel-success');
		});
		//QTY---
		$(document).on('click', '.minus-q', function() {
			var parents = $(this).parents('.panel:first').attr('this_set');


			if (($('#select-make-'+parents).val() != "") || ($('#select-item-'+parents).val() != "")) {
				var this_category = find_category($(this));

			//THIS_CATEGOR 0 = SERVICES, 1 = ITEMS
			if (this_category == 0) {//SERVICE
				var this_e = $(this).parents('.panel:first').find('.select-item');
				var this_rate = $("option:selected", this_e).attr('rate');
				var qty = parseInt($(this).parents('.input-group:first').find('input').val());
				var new_qty = 0;
				if (qty > 0) {
					new_qty = qty - 1;
				};
				$(this).parents('.input-group:first').find('input').val(new_qty);
			} else if (this_category == 1) {//ITEMS
				var this_e = $(this).parents('.panel:first').find('.select-item');
				var this_rate = $("option:selected", this_e).attr('rate');
				var qty = parseInt($(this).parents('.input-group:first').find('input').val());
				var new_qty = 0;
				if (qty > 0) {
					new_qty = qty - 1;
				};
				$(this).parents('.input-group:first').find('input').val(new_qty);
				set_price(this_rate,new_qty,parents);

				//GATHER DATA AND SAVE IT INTO A FORM
				var this_item_id = $("option:selected", this_e).val();
				store_items(this_category,new_qty,parents,this_item_id,di);
			};



		};
	});

$(document).on('click', '.add-q', function() {
	var parents = $(this).parents('.panel:first').attr('this_set');
	if (($('#select-make-'+parents).val() != "") || ($('#select-item-'+parents).val() != "")) {
		var this_category = find_category($(this));

			//THIS_CATEGOR 0 = SERVICES, 1 = ITEMS
			if (this_category == 0) {
				var this_e = $(this).parents('.panel:first').find('.select-make');
				var this_rate = $("option:selected", this_e).attr('rate');
				var qty = parseInt($(this).parents('.input-group:first').find('input').val());
				var new_qty = 0;
				var new_qty = qty + 1;

				$(this).parents('.input-group:first').find('input').val(new_qty);
			} else if (this_category == 1) {
				var this_e = $(this).parents('.panel:first').find('.select-item');
				var this_rate = $("option:selected", this_e).attr('rate');
				var qty = parseInt($(this).parents('.input-group:first').find('input').val());
				var new_qty = 0;
				var new_qty = qty + 1;

				$(this).parents('.input-group:first').find('input').val(new_qty);
				set_price(this_rate,new_qty,parents);

				var this_item_id = this_e.val();
				store_items(this_category,new_qty,parents,this_item_id,null);
			};
		}

	});

$("#add-content").click(function() {
	var content_set_count = $(document).find('.content-set').length;
	$(document).find('#content .panel-collapse').removeClass('in');
	$(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
	request.add_content(content_set_count);
});
$("#preview-btn").click(function() {
            // var serialized_data = $("#add-form").serialize();
            // request.load_preview(serialized_data);
        });
$("#title").keyup(function() {
	var have_error = false;
	var name_array = $(window.controller_names);
	var dup_val = "";
	var enterd_title = $(this).val();
	jQuery.each(name_array, function(i, val) {
		if (val == enterd_title && val != "") {
			dup_val = val;
			have_error = true;
		};
	});
	if (have_error == true) {
		$(this).parents('.form-group:first').addClass('has-error');
		$(this).parents('.form-group:first').find('#title-duplicate').removeClass('hide');
		$('#accordion-pro').collapse('show');
		$(document).find('#labels-div .' + dup_val).removeClass('label-default').addClass('label-danger');
		$('.submit-btn').addClass('disabled');
	} else {
		$(this).parents('.form-group:first').removeClass('has-error');
		$(this).parents('.form-group:first').find('#title-duplicate').addClass('hide');
		$(document).find('#labels-div .label').removeClass('label-danger').addClass('label-default');
		$('.submit-btn').removeClass('disabled');
	}
});
	$(document).on('click', '.remove-collapse', function() {

            // console.log($(document).find('.content-area .content-set').length);

            var this_set = $(this).parents('.content-set').attr('this_set');
            $(this).parents('.content-set:first').remove();


    });

$(".searchByButton").click(function() {
	var company_id = $("#company_id").val();
	var type = $(this).parents('.searchByFormGroup:first').attr('id').replace('searchBy-', '');
	search = {};
	search[type] = {};

	$(this).parents('.searchByFormGroup:first').find('.searchInputItem').each(function(e) {
		var name = $(this).attr('name');
		search[type][name] = $(this).val();

	});
	request.search_users(company_id, search);

});


},
events_after: function() {
	$(".select-make").change(function() {
		var this_category = find_category($(this));
		var parents = $(this).parents('.panel:first').attr('this_set');
		reset_order_form(parents);
		var element = $("option:selected", this);
		var rate = parseFloat(element.attr("rate"));
		if ($(this).find('option:selected').val() != '') {
			$('#select-item-'+parents).removeAttr('disabled');
			var new_rate = rate.toFixed(2)
			$('#rate-'+parents).val(new_rate+' $');
		} else {
			$('#select-item-'+parents).attr('disabled','disabled');
			$('#rate-'+parents).val('-');
		}
			if ($('.service-group-'+parents).length != 0) {
				// var html = '<input class="item-group-'+parents+' item-group" type="hidden" value="" name="item_order" id="item-'+parents+'-0">';
				$('.service-group-'+parents).remove();
			}
	});
	$(".select-item").change(function() {
		var this_category = find_category($(this));
		var parents = $(this).parents('.panel:first').attr('this_set');
		reset_order_form(parents);
		if ($(this).find('option:selected').val() != '') {//ITEM SELECTED
			$('#height-'+parents).removeAttr('disabled');
			$('#length-'+parents).removeAttr('disabled');
		} else {
			$('#height-'+parents).attr('disabled','disabled');
			$('#length-'+parents).attr('disabled','disabled');
		}
		if (this_category == 0) {
			if ($('.service-group-'+parents).length != 0) {
				// var html = '<input class="item-group-'+parents+' item-group" type="hidden" value="" name="item_order" id="item-'+parents+'-0">';
				$('.service-group-'+parents).remove();
			}
		} else if (this_category == 1){
			if ($('.item-group-'+parents).length != 0) {
				// var html = '<input class="item-group-'+parents+' item-group" type="hidden" value="" name="item_order" id="item-'+parents+'-0">';
				$('.item-group-'+parents).remove();
			}
		}

	});
	$('.radio-option').click(function() {
		var this_id = $(this).attr('id');
		var parents = $(this).parents('.panel:first').attr('this_set');
		reset_order_form(parents);
		if (this_id == "service-radio") {

			$('#select-item-'+parents).attr('disabled','disabled');
			$('.make-form-'+parents).removeClass('hide').addClass('show');
			$('.item-form-'+parents).removeClass('hide').addClass('show');
			$('.qty-form-'+parents).addClass('hide').removeClass('show');
			$('.di-form-'+parents).removeClass('hide').addClass('show');
			$('.rate-form-'+parents).removeClass('hide').addClass('show');
			$('.price-form-'+parents).removeClass('hide').addClass('show');


		} else if (this_id == "item-radio") {

			$('#select-item-'+parents).removeAttr('disabled');
			$('.make-form-'+parents).removeClass('show').addClass('hide');
			$('.item-form-'+parents).removeClass('hide').addClass('show');
			$('.qty-form-'+parents).removeClass('hide').addClass('show');
			$('.di-form-'+parents).removeClass('show').addClass('hide');
			$('.rate-form-'+parents).removeClass('show').addClass('hide');
			$('.price-form-'+parents).removeClass('hide').addClass('show');

		

		}
	});

	//QTY---

	$(".qty").keyup(function(){
			if ($(this).val().match(/^\d+$/)) {//CHECK IF IT IS NUMERIC
				var this_category = find_category($(this));
			//THIS_CATEGOR 0 = SERVICES, 1 = ITEMS
			if (this_category == 0) {
			} else if (this_category == 1) {
				var parents = $(this).parents('.panel:first').attr('this_set');
				var this_e = $(this).parents('.panel:first').find('.select-item');
				var this_rate = $("option:selected", this_e).attr('rate');
				var this_qty = parseInt($(this).val());
				set_price(this_rate,this_qty,parents);
			};
		};
	});
	//

	$(".height").keyup(function(){
		var height = $(this).val();
		if (height.match(/^\d+$/) && height != "0") {//CHECK IF IT IS NUMERIC
			var parents = $(this).parents('.panel:first').attr('this_set');
			var length = $('#length-'+parents).val();
			if (length.match(/^\d+$/) && length != "0") {//CHECK IF IT IS NUMERIC
				var this_category = find_category($(this));
				var element = $("option:selected", $('#select-make-'+parents));
				var rate = parseFloat(element.attr("rate"));

				var total = get_total(rate,height,length);

				$('#total-'+parents).val(total+' $');

				var di = {
				height:height,
				length:length
				};
				var this_service_id = element.val();
				store_items(this_category,null,parents,this_service_id,di);

			};
		}
	});

	$(".length").keyup(function(){
		var length = $(this).val();
		if (length.match(/^\d+$/) && length != "0") {//CHECK IF IT IS NUMERIC
			var parents = $(this).parents('.panel:first').attr('this_set');
			var height = $('#height-'+parents).val();
			if (height.match(/^\d+$/) && height != "0") {//CHECK IF IT IS NUMERIC
				var this_category = find_category($(this));
				var element = $("option:selected", $('#select-make-'+parents));
				var rate = parseFloat(element.attr("rate"));

				var total = get_total(rate,height,length);
				$('#total-'+parents).val(total+' $');

				var di = {
				height:height,
				length:length
				};
				var this_service_id = element.val();
				store_items(this_category,null,parents,this_service_id,di);
			}

		};
	});

},
validation: function(){
	$("#name").blur(function(){
		var type = "name";
		var value = $(this).val();
		var _this = $(this);
		request.ajax_validation(value, type, _this);
	});

	$("#email").blur(function(){
		var type = "email";
		var value = $(this).val();
		var _this = $(this);
		request.ajax_validation(value, type, _this);
	});

	$("#telephone").blur(function(){
		var type = "phone";
		var value = $(this).val();
		var _this = $(this);
		request.ajax_validation(value, type, _this);
	});

	$("#street").blur(function(){
		var form_value = $(this).val();
		var _this = $(this);
		var type = "street";
		var message = type + ' is required.'
		if (form_value != '') {
			uni_show_validation(_this,message,1,type);
		} else {
			uni_show_validation(_this,message,2,type);
		}
	});
	$("#unit").blur(function(){
		var form_value = $(this).val();
		var _this = $(this);
		var type = "unit";
		var message = type + ' is required.'
		if (form_value != '') {
			uni_show_validation(_this,message,1,type);
		} else {
			uni_show_validation(_this,message,2,type);
		}
	});
	$("#city").blur(function(){
		var form_value = $(this).val();
		var _this = $(this);
		var type = "city";
		var message = type + ' is required.'
		if (form_value != '') {
			uni_show_validation(_this,message,1,type);
		} else {
			uni_show_validation(_this,message,2,type);
		}
	});
	$("#state").blur(function(){
		var form_value = $(this).val();
		var _this = $(this);
		var type = "state";
		var message = type + ' is required.'
		if (form_value != '') {
			uni_show_validation(_this,message,1,type);
		} else {
			uni_show_validation(_this,message,2,type);		
		}
	});
	$("#zipcode").blur(function(){
		var form_value = $(this).val();
		var _this = $(this);
		var type = "zipcode";
		var message = type + ' is required.'
		if (form_value != '') {
			uni_show_validation(_this,message,1,type);
		} else {
			uni_show_validation(_this,message,2,type);
		}
	});
}
};
request = {
	ajax_validation: function(value, type, _this) {
		var token = $('meta[name=csrf-token]').attr('content');
		$.post(
			'/schedules/ajax-validation',
			{
				"_token": token,
				value: value,
				type: type
			},
			function(result){
				var data = result.data;
				var status = data['status'];
				var message = data.validator[type];
				switch(status) {
                    case 200: // Approved
                    _this.parents('.form-group:first').addClass('has-success').addClass('has-feedback').removeClass('has-error');
                    _this.parents('.form-group:first').find('.val-error').removeClass('show').addClass('hide');
                    _this.parents('.form-group:first').find('.val-success').removeClass('hide').addClass('show');
                    _this.parents('.form-group:first').find('.val-help').removeClass('show').addClass('hide');
                    $('#checklist').attr(type,true);
                    validate_company_checklist();
                    break;

                    case 201: 

                    break;

                    case 400: 
                    _this.parents('.form-group:first').addClass('has-error').addClass('has-feedback').removeClass('has-success');
                    _this.parents('.form-group:first').find('.val-success').removeClass('show').addClass('hide');
                    _this.parents('.form-group:first').find('.val-error').removeClass('hide').addClass('show');
                    _this.parents('.form-group:first').find('.val-help').removeClass('hide').addClass('show').html(message);
                    $('#checklist').attr(type,false);
                    validate_company_checklist();

                    break;

                    default:
                    break;
                }
            }
            );
},

search_users: function(company_id, search) {
	var token = $('meta[name=_token]').attr('content');
	$.post(
		'/users/request-users', {
			"_token": token,
			company_id: company_id,
			search: search
		},
		function(result) {
			var status = result.status;
                // var message = result.message;
                var table_tbody = result.users_tbody;
                $("#userSearchTable").removeClass('hide');
                $("#userSearchTable tbody").html(table_tbody);

                $(document).find("#userSearchTable tbody tr").click(function() {
                	var user_id = $(this).find('.checkUser').val();
                	if ($(this).find('.checkUser:checked').length === 0) {//IS NOT ACTIVE
                		$(this).addClass('success').find('.checkUser').prop('checked', true);
                		$(document).find('#userSearchTable tbody tr:not(.success)').addClass('hide');
                        //GET USER INFORMATION
                        request.set_user(user_id);

                    } else {//IS ACTIVE
                    	$('#user_id').val(null);
                    	$(this).removeClass('success').find('.checkUser').removeAttr('checked');
                    	wipe_user_information();
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
		'/schedules/order-add', {
			"_token": token,
			"content_set_count": content_set_count
		},
		function(results) {
			var status = results.status;
			var html = results.html;
			switch (status) {
                    case 200: // Approved

                        // $('#content_count').val((content_set_count--));
                        $('.content-area').append(html);
                        page.events_after();
                        break;
                        default:
                        break;
                    }

                }
                );
},
set_user: function(user_id) {
	$('#myModal').modal('show');
	var token = $("meta[name=_token]").attr('content');
	$.post(
		'/user/request-user-information',
		{
			"_token": token,
			user_id: user_id,
		},
		function(result){
			$('#myModal').modal('hide');
			var status = result.status;
			var user_data = result.user_data;

			var first_name = result.user_data['firstname'];
			var last_name = result.user_data['lastname'];
			var phone = result.user_data['phone'];
			var city = result.user_data['city'];
			var state = result.user_data['state'];
			var street = result.user_data['street'];
			var zipcode = result.user_data['zipcode'];
			var email = result.user_data['email'];
			var unit = result.user_data['unit'];

			switch(status) {
					case 200: // Approved
					$('#user_id').val(user_id);

					$("#name").val(first_name + ' ' +last_name);
					$("#telephone").val(phone);
					$("#email").val(email);
					$("#street").val(street);
					$("#city").val(city);
					$("#unit").val(unit);
					$("#state").val(state);
					$("#zipcode").val(zipcode);
					check_all_inputs();
					break;
					case 400: // Approved

					break;

					default:

					break;
				}
			}
			);
}
};

function urlfriendly(url) {
	url = url
        .toLowerCase() // change everything to lowercase
        .replace(/^\s+|\s+$/g, "") // trim leading and trailing spaces		
        .replace(/[_|\s]+/g, "-") // change all spaces and underscores to a hyphen
        .replace(/[^a-z\u0400-\u04FF0-9-]+/g, "") // remove all non-cyrillic, non-numeric characters except the hyphen
        .replace(/[-]+/g, "-") // replace multiple instances of the hyphen with a single instance
        .replace(/^-+|-+$/g, ""); // trim leading and trailing hyphens
        return url;
    }
    function reset_order_form(id){
    	$('#qty-'+id).val('0');
    	$('#total-'+id).val('');
    	$('#length-'+id).val('');
    	$('#height-'+id).val('');
    }
    function set_price(rate,qty,parents){
    	if (($('#select-make-'+parents).val() != "") || ($('#select-item-'+parents).val() != "")) {
    		if (qty > 0) {
    			var total = rate * qty;
    			var fixed_total = total.toFixed(2);
    			$('#total-'+parents).val(fixed_total+' $');
    		} else {
    			$('#total-'+parents).val('00.0 $');
    		}
    	}

    }
    function find_category(_this){	
    	var result = null;
    	if (_this.parents('.panel:first').find('#service-radio').prop('checked') == true) {
    		result = 0;
    	} else if(_this.parents('.panel:first').find('#item-radio').prop('checked') == true){
    		result = 1;
    	}
    	return result;
    }

    function uni_show_validation(_this,message,status,type){	
    	switch(status){
    		case 1://SUCCESS
    		$('#checklist').attr(type,true);

    		_this.parents('.form-group:first').addClass('has-success').addClass('has-feedback').removeClass('has-error');
    		_this.parents('.form-group:first').find('.val-error').removeClass('show').addClass('hide');
    		_this.parents('.form-group:first').find('.val-success').removeClass('hide').addClass('show');
    		_this.parents('.form-group:first').find('.val-help').removeClass('show').addClass('hide');

    		validate_company_checklist();
    		break;
    		case 2://ERROR
    		$('#checklist').attr(type,false);

    		_this.parents('.form-group:first').addClass('has-error').addClass('has-feedback').removeClass('has-success');
    		_this.parents('.form-group:first').find('.val-success').removeClass('show').addClass('hide');
    		_this.parents('.form-group:first').find('.val-error').removeClass('hide').addClass('show');
    		_this.parents('.form-group:first').find('.val-help').removeClass('hide').addClass('show').html(message);

    		validate_company_checklist();
    		break;
    	}

    }
    function validate_company_checklist()
    {
    	var ch = $('#checklist');
    	if (ch.attr('name')=="true" &&  
    		ch.attr('phone')=="true" &&
    		ch.attr('email')=="true" && 
    		ch.attr('street')=="true" &&
    		ch.attr('zipcode')=="true" &&
    		ch.attr('city')=="true" &&
    		ch.attr('unit')=="true" &&
    		ch.attr('state')=="true" 
    		) {
    		$('#next-btn').removeClass('disabled');
    	$('.content-step').removeClass('disabled');

    	
    } else {
    	$('#next-btn').addClass('disabled');
    	$('.content-step').addClass('disabled');

    }

}



function check_all_inputs()
{
	var type = "name";
	var value = $('#'+type).val();
	var _this = $('#'+type);
	request.ajax_validation(value, type, _this);


	var type = "email";
	var value = $('#'+type).val();
	var _this = $('#'+type);
	request.ajax_validation(value, type, _this);

	var type = "phone";
	var value = $('#telephone').val();
	var _this = $('#telephone');
	request.ajax_validation(value, type, _this);


	var type = "street";
	var value = $('#'+type).val();
	var _this = $('#'+type);
	var form_value = _this.val();
	var message = type + ' is required.'
	if (form_value != '') {
		uni_show_validation(_this,message,1,type);
	} else {
		uni_show_validation(_this,message,2,type);
	}

	var type = "unit";
	var value = $('#'+type).val();
	var _this = $('#'+type);
	var form_value = _this.val();
	var message = type + ' is required.'
	if (form_value != '') {
		uni_show_validation(_this,message,1,type);
	} else {
		uni_show_validation(_this,message,2,type);
	}

	var type = "city";
	var value = $('#'+type).val();
	var _this = $('#'+type);
	var form_value = _this.val();
	var message = type + ' is required.'
	if (form_value != '') {
		uni_show_validation(_this,message,1,type);
	} else {
		uni_show_validation(_this,message,2,type);
	}

	var type = "state";
	var value = $('#'+type).val();
	var _this = $('#'+type);
	var form_value = _this.val();
	var message = type + ' is required.'
	if (form_value != '') {
		uni_show_validation(_this,message,1,type);
	} else {
		uni_show_validation(_this,message,2,type);		
	}

	var type = "zipcode";
	var value = $('#'+type).val();
	var _this = $('#'+type);
	var form_value = _this.val();
	var message = type + ' is required.'
	if (form_value != '') {
		uni_show_validation(_this,message,1,type);
	} else {
		uni_show_validation(_this,message,2,type);
	}

	validate_company_checklist();
}

function get_total(rate,height,length)
{
	var di = height * length;
	var total = rate * di;
	var fixed_total = total.toFixed(2);
	return fixed_total;
}

function wipe_user_information()
{
	$('#name').val('');
	$('#telephone').val('');
	$('#email').val('');
	$('#street').val('');
	$('#unit').val('');
	$('#city').val('');
	$('#state').val('');
	$('#zipcode').val('');
	check_all_inputs();
}

function store_items(this_category,new_qty,parents,this_order_id,di)
{
	var category_name = this_category == 1 ? "item":"service";
	if (this_category == 0) {//SERVICE
		var count_s = parseInt($('#service_count').val());
		if (count_s != 0) {
			$('.service-group-'+parents).remove();
		};
		var height = di['height'];
		var length = di['length'];
		var html_i = '<input type="hidden" class="service-group-'+parents+' service-group" value="'+this_order_id+'" name="service_order['+parents+'][id]" id="service-'+parents+'" >';
		var html_h = '<input type="hidden" class="service-group-'+parents+' service-group" value="'+height+'" name="service_order['+parents+'][height]" id="service-'+parents+'" >';
		var html_l = '<input type="hidden" class="service-group-'+parents+' service-group" value="'+length+'" name="service_order['+parents+'][length]" id="service-'+parents+'" >';
		$('#this-body').append(html_i);
		$('#this-body').append(html_h);
		$('#this-body').append(html_l);
		var new_count_s = (count_s + 1);
		$('#service_count').val(new_count_s);

	} else {//ITEM
		var count_i = $('#item_count').val();
		var html = '<input type="hidden" class="item-group-'+parents+' item-group" value="'+this_order_id+'" name="item_order['+parents+']['+count_i+']" id="item-'+parents+'-'+count_i+'" >';
		$('#this-body').append(html);
		var new_count_i = (count_i + 1);
		$('#item_count').val(new_count_i);
	}
}

function count_sections(this_category,parents)
{
	if (this_category == 0) {//SERVICE

	} else {//ITEM

	}
}