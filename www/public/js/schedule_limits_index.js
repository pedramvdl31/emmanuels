$(document).ready(function(){
	pages.pageLoad();
	pages.events();
});

pages = {
	pageLoad: function(){
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
        });
            $('#zipcode').datetimepicker({
              language: 'pt-BR'
            });
    },
    events: function(){

    }
}