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
		$('#name').friendurl({id : 'url'});
		$("#name").on("change", function () {
			$('#url').val("/"+urlfriendly($("#name").val()));
		});
		$(".kind").on("change", function () {
			var option_selected = $(this).find('option:selected').val();
			switch(parseInt(option_selected)){
				case 1:
				$('.page-field').addClass('show').removeClass('hide');
				$('#url').attr('id','url_link');
				var option_selected = $('.page_id').find('option:selected').text();
				$('#url_link').val("/");
				if (option_selected != "All Pages") {
					$('#url_link').val("/"+urlfriendly(option_selected));
				};
				break
				case 2:
				$('.page-field').addClass('hide').removeClass('show');
				$('#url_link').attr('id','url');

				var _name = urlfriendly($('#name').val());
				$('#url').val("/"+_name);
				break;
			}
		});
		$(".page_id").on("change", function () {
			var option_selected = $(this).find('option:selected').text();
			if (option_selected != "All Pages") {
				$('#url_link').val("/"+urlfriendly(option_selected));
			}
		});
	}
};

request = {
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
