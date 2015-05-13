$(document).ready(function(){
	menu.page_load();
	menu.events();
});
menu = {
	page_load: function(){
		$.ajaxSetup({
			headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
		});
	},
	events: function(){
		$('#rate').priceFormat({
		    prefix: '',
		    thousandsSeparator: '',
		    centsLimit: 4,
		     limit: 5,
		});

		$( "#rate" ).keyup(function() {
		  var this_rate = $(this).val();
		  var new_rate = this_rate * 100;
		  $('.percentage').html(new_rate);
		});
	}
};

request = {
};
