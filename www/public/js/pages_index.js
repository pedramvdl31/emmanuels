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
			console.log(id);
		});

	}
};

request = {

};
