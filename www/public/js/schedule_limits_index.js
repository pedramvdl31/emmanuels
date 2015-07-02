$(document).ready(function(){
	pages.pageLoad();
	pages.events();
    pages.stepy();
});

pages = {
	pageLoad: function(){
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=csrf-token]').attr('content') }
        });
        $("#overwrite-date-single-0").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate:0
        });
        $("#overwrite-date-range-start-0").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate:0
        });
        $("#overwrite-date-range-end-0").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate:0
        });
    },
    events: function(){
        $(document).on('click','#add-overwrite',function(){

            //CLOSE ALL ACCORDIONS
            $('#overwrite').find('.panel-collapse').removeClass('in');

            //COUNT NUMBER OF SETS
            var count = $('.overwrite-wrapper').length;

            request.add_overwrite(count);
        });
    },
        stepy: function() {
        $("#deliveryStepy li a").click(function(e) {
            var href = $(this).attr('href');
            previous_step = $("#deliveryStepy .active");
            if (!($(this).parents('li:first').hasClass('disabled'))) {
                // IF THE PREVIOUS STEP WAS 1
                if (previous_step.attr('id') == 'schedule-stepy') {
                    //VALIDATE BEFORE CHANGING THE STEP
                    validate_step_1();

                } else {
                    
                    e.preventDefault();
                    $("#deliveryStepy li").removeClass('active');
                    $(this).parents('li:first').addClass('active');
                    $(".steps").addClass('hide');
                    $(href).removeClass('hide');
                    if ((href == "#overwrite")) {

                    }
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
            //  setDeliveryAddress();
            // }


            if ($('#user_id').val() != "") {
                // check_all_inputs();
            };
        });
        
        $("#set-forgotten-btn").click(function() {
            //NAVIGATE TO ADDRESS TAB, IN ORDER TO FILL NAME, EMAIL OR PHONE
            $('#member-tab').addClass('active');
            $('#new-address-tab').removeClass('active');
            $('#address').removeClass('hide');
            $('#newaddress').removeClass('show').addClass('hide');
        });

        $(".previous").click(function() {
            $("#deliveryStepy .active").prev('li').addClass('row-active');
            $("#deliveryStepy li").removeClass('active');
            $(document).find(".row-active").addClass('active').removeClass('row-active');
            var href = $(document).find('#deliveryStepy .active a').attr('href');
            $(".steps").addClass('hide');
            $(href).removeClass('hide');
            // if($(this).attr('step') == 5) {//coming from deliverySetup
            //  updateBillingInfo();
            // }
        });

        $(document).find(".type-select").change(function() {
            var value = $(this).find('option:selected').val();
            if (value == "single") {
                $(this).parents('.this-wrapper').find('.range-wrapper').addClass('hide');
                $(this).parents('.this-wrapper').find('.single-wrapper').removeClass('hide');
            } else if (value = "range"){
                $(this).parents('.this-wrapper').find('.range-wrapper').removeClass('hide');
                $(this).parents('.this-wrapper').find('.single-wrapper').addClass('hide');
            }
        });
    }
}
request = {
    add_overwrite: function(count) {
        var token = $('meta[name=csrf-token]').attr('content');
        $.post(
            '/limits/overwrite', {
                "_token": token,
                "count": count
            },
            function(result) {
                var data = result.data;
                var status = 200;
                var html = result.html;
                switch (status) {
                    case 200: // Approved
                    $('#content-wrapper').append(html);

                    $(document).find("#overwrite-date-single-"+count).datepicker({
                        dateFormat: 'DD, d MM, yy',
                        minDate:0
                    });

                    $(document).find("#overwrite-date-range-start-"+count).datepicker({
                        dateFormat: 'DD, d MM, yy',
                        minDate:0
                    });

                    $(document).find("#overwrite-date-range-end-"+count).datepicker({
                        dateFormat: 'DD, d MM, yy',
                        minDate:0
                    });
                        $(document).find(".type-select").change(function() {
                            var value = $(this).find('option:selected').val();
                            if (value == "single") {
                                $(this).parents('.this-wrapper').find('.range-wrapper').addClass('hide');
                                $(this).parents('.this-wrapper').find('.single-wrapper').removeClass('hide');
                            } else if (value = "range"){
                                $(this).parents('.this-wrapper').find('.range-wrapper').removeClass('hide');
                                $(this).parents('.this-wrapper').find('.single-wrapper').addClass('hide');
                            }
                        });
                    break;

                    case 201:

                    break;

                    case 400:

                    break;

                    default:
                    break;
                }
            }
            );
}
}
function validate_step_1()
{
    //FLAG ZERO IS NO ERROR
    $flag = 0;
    $('.first_section').find('tr').each(function( index ) {
    //FOR EACH DAY
        $selected_radio =  $( "input:radio:checked" ).val();
        //IGNORE VALIDATION IF IT WAS CLOSED
        if ($selected_radio != "closed") {
            //GO THROUHT AND .. CHECK IF EVERY INPUT IS SET
            $('select').each(function( index ) {
                if ($("option:selected",this).val() == 0) { 
                    $flag = 1;
                    $(this).addClass('hide');
                };
            });
        };
             

    });
}