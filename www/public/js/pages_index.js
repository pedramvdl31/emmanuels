$(document).ready(function(){
	page.page_load();
	page.events();
});

page = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function(){

		$(document).on('click','.remove',function(){
			var count = $(this).attr('count');
			var id = $(this).attr('page-id');
			$(document).find("#myModal").attr('page-id',id);
			if (count == 1) {
				$(document).find(".modal-body").html('This page group has '+count+' item. Deleting this page group will result in the loss of all page items that are belong to this group. Press remove to confirm?');
			} else if (count == 0){
				$(document).find(".modal-body").html('Are you sure you want to delete this?');
			}
			else {
				$(document).find(".modal-body").html('This page group has '+count+' items.  Deleting this page group will result in the loss of all page items that are belong to this group. Press remove to confirm?');
			}
			
		});
		$(document).on('click','.remove-btn',function(){
			var id = $(this).parents('.modal:first').attr('page-id');
			$("#form-"+id).submit();
		});

		$(document).on('change','.status',function(){
			var id = $(this).parents('tr:first').find('td:first').attr('this-id');
			var selected_status = $("option:selected", this).attr("value");
			var this_name = $("option:selected", this).html();
			$('#status-modal').attr('page_id',id);
			$('#status-modal').attr('selected_status',selected_status);
			$('#status-modal').find('.modal-body:first').html('Are you sure you want to change this to '+this_name+'?');
			$('#status-modal').modal('show');
			
		});
		$(document).on('click','.yes-status-btn',function(){
			var id = $(this).parents('.modal:first').attr('page_id');
			var selected_status = $(this).parents('.modal:first').attr('selected_status');
			request.change_status(id,selected_status);
		});
		$(document).on('click','.no-status-btn',function(){
			var id = $(this).parents('.modal:first').attr('page_id');
			var selected_status = $(this).parents('.modal:first').attr('selected_status');
			var pre_status = 0;
			if (selected_status == 1) {
				pre_status = 2;
			}
			else {
				pre_status = 1;
			}
			$('.status-'+id).val(pre_status);
		});

	}
};

request = {
	change_status: function(id,selected_status) {
		var token = $('meta[name=_token]').attr('content');
		$.post(
			'/pages/change-status',
			{
				"_token": token,
				"id": id,
				"selected_status":selected_status
			},
			function(results){
				var status = results.status;
				switch(status) {
					case 200: // Approved
					$('#status-modal').modal('hide');
					break;

					default:
					$('#status-modal').modal('hide');
					break;
				}
			}
			);
	}
};
