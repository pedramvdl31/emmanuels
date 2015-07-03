$(document).ready(function() {
    pages.pageLoad();
    pages.events();
    pages.stepy();
});

pages = {
    pageLoad: function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
            }
        });
        $("#overwrite-date-single-0").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate: 0
        });
        $("#overwrite-date-range-start-0").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate: 0
        });
        $("#overwrite-date-range-end-0").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate: 0
        });
        $("#blackout-input").datepicker({
            dateFormat: 'DD, d MM, yy',
            minDate: 0,
            onSelect: function(date) {
                add_new_blackout_date(date);
            }

        });
    },
    events: function() {
        $(document).on('click', '#add-overwrite', function() {

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
                    var _this = $(this);
                    validate_step_1(_this, href, "stepy");
                    
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
            var _this = $(this);
            validate_step_1(_this, null, "btn");

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
            } else if (value = "range") {
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

                        $(document).find("#overwrite-date-single-" + count).datepicker({
                            dateFormat: 'DD, d MM, yy',
                            minDate: 0
                        });

                        $(document).find("#overwrite-date-range-start-" + count).datepicker({
                            dateFormat: 'DD, d MM, yy',
                            minDate: 0
                        });

                        $(document).find("#overwrite-date-range-end-" + count).datepicker({
                            dateFormat: 'DD, d MM, yy',
                            minDate: 0
                        });
                        $(document).find(".type-select").change(function() {
                            var value = $(this).find('option:selected').val();
                            if (value == "single") {
                                $(this).parents('.this-wrapper').find('.range-wrapper').addClass('hide');
                                $(this).parents('.this-wrapper').find('.single-wrapper').removeClass('hide');
                            } else if (value = "range") {
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
    },
    validate_hours_ajax: function(data, this_this, href, type) {
        // TYPE = STEPY OR THE NEXT BTN
        var token = $('meta[name=csrf-token]').attr('content');
        $.post(
            '/limits/validate-hours', {
                "_token": token,
                "data": data
            },
            function(result) {
                var status = 200;
                var data = result.validation_result;
                var error = 0;
                switch (status) {
                    case 200: // Approved
                    var first_this = null;
                    var count = 0;
                        $.each(data, function(i, val) {
                            //IF IT HAS ERROR GET THE KEY AND SHOW IT
                            count = count + 1;
                            if (val["info"] == "error") {
                                error = 1;
                                $('.time-error-' + i).removeClass('hide');
                                $('.time-error-' + i).parents('.list-group-item:first').find('.form-group').addClass('has-error');
                                if (count == 1) {
                                    first_this = i;
                                };
                            };
                        });
                        if (error == 0) {
                            if (type == "stepy") {
                                $("#deliveryStepy li").removeClass('active');
                                this_this.parents('li:first').addClass('active');
                                $(".steps").addClass('hide');
                                $(href).removeClass('hide');
                            } else {
                                $("#deliveryStepy .active").next('li').addClass('row-active');
                                $("#deliveryStepy li").removeClass('active');
                                $(document).find(".row-active").addClass('active').removeClass('row-active');
                                var _href = $(document).find('#deliveryStepy .active a').attr('href');
                                $(".steps").addClass('hide');
                                $(_href).removeClass('hide');
                            }

                        } else {
                            // console.log(first_this);
                            //     $('html,body').animate({
                            //         scrollTop: $('.time-error-'+first_this).offset().top - 100
                            //     }, 1000);
                        }
                        break;
                    default:
                        break;
                }
            }
        );
    }
}

function validate_step_1(_this, href, type) {
    var error_count = 0;
    //STEPY WAS CLICKED
    if (type == "stepy") {

        clear_all_validation_errors();
        //FLAG ZERO IS NO ERROR
        var flag = 0;
        $('.step-1').find('tr').each(function(index) {
            //FOR EACH DAY
            var selected_radio = $(" input:radio:checked", this).val();
            //IGNORE VALIDATION IF IT WAS CLOSED
            if (selected_radio != "closed") {
                //GO THROUHT AND .. CHECK IF EVERY INPUT IS SET
                $(this).find('.form-selects').each(function(index) {
                    if ($("option:selected", this).val() == '' || $("option:selected", this).val() == '0') {
                        flag = 1;
                        error_count = error_count + 1;
                        //IF THE SELECT WAS NOT SELECTED ADD HAS-ERROR TO IT
                        $(this).parents('.form-group:first').addClass('has-error')
                            .find('.select-error').removeClass('hide');
                            //SAVE THE FIRST ERROR, SO LATER WE CAN SCROLL TO IT
                            if (error_count ==1 ) {
                                last_this = $(this);
                            };
                    };
                });
            };
        });
        if (flag == 1) {
            //SCROLL TO THE ERROR
        $('html,body').animate({
          scrollTop: $(last_this).offset().top - 20
        }, 1000);
        };
        //IF THERE WAS NOW ERRORS THEN PROCEED TO NEXT STEPY
        if (flag == 0) {
            //VALIDATE HOURS
            var data = [];
            // INIT ALL ARRAYS
            for (var i = 0; i <= 7; i++) {
                data[i] = [];
            };
            var f_count = 0;
            $('.step-1').find('tr').each(function(index) {
                //FOR EACH DAY
                var selected_radio = $(" input:radio:checked").val();
                //IGNORE VALIDATION IF IT WAS CLOSED
                if (selected_radio != "closed") {

                    //GO THROUHT AND .. CHECK IF EVERY INPUT IS SET
                    $(this).find('.form-selects').each(function(index) {

                        var this_value = $("option:selected", this).val();
                        var this_category = $(this).attr('this_category');
                        data[this_category].push(this_value);
                        f_count = f_count + 1;
                    });
                };
            });
            request.validate_hours_ajax(data, _this, href);
        };
    } 


// NEXT BTN WAS CLICKED

    else {
        clear_all_validation_errors();
        //FLAG ZERO IS NO ERROR
        var flag = 0;
        $('.step-1').find('tr').each(function(index) {
            //FOR EACH DAY
            var selected_radio = $(" input:radio:checked", this).val();
            //IGNORE VALIDATION IF IT WAS CLOSED
            if (selected_radio != "closed") {
                //GO THROUHT AND .. CHECK IF EVERY INPUT IS SET
                $(this).find('.form-selects').each(function(index) {
                    if ($("option:selected", this).val() == '' || $("option:selected", this).val() == '0') {
                        flag = 1;
                        error_count = error_count + 1;
                        //IF THE SELECT WAS NOT SELECTED ADD HAS-ERROR TO IT
                        $(this).parents('.form-group:first').addClass('has-error')
                            .find('.select-error').removeClass('hide');
                             //SAVE THE FIRST ERROR, SO LATER WE CAN SCROLL TO IT
                            if (error_count ==1 ) {
                                last_this = $(this);
                            };
                    };
                });
            };
        });
        if (flag == 1) {
            //SCROLL TO THE ERROR
        $('html,body').animate({
          scrollTop: $(last_this).offset().top - 20
        }, 1000);
        };
        //IF THERE WAS NOW ERRORS THEN PROCEED TO NEXT STEPY
        if (flag == 0) {
            //VALIDATE HOURS
            var data = [];
            // INIT ALL ARRAYS
            for (var i = 0; i <= 7; i++) {
                data[i] = [];
            };
            var f_count = 0;
            $('.step-1').find('tr').each(function(index) {
                //FOR EACH DAY
                var selected_radio = $(" input:radio:checked").val();
                //IGNORE VALIDATION IF IT WAS CLOSED
                if (selected_radio != "closed") {

                    //GO THROUHT AND .. CHECK IF EVERY INPUT IS SET
                    $(this).find('.form-selects').each(function(index) {

                        var this_value = $("option:selected", this).val();
                        var this_category = $(this).attr('this_category');
                        data[this_category].push(this_value);
                        f_count = f_count + 1;
                    });
                };
            });
            request.validate_hours_ajax(data, _this, href, type);
        };
    }

}

function clear_all_validation_errors() {
    $('.first_section').find('tr').each(function(index) {
        $('select').each(function(index) {
            $(this).parents('.form-group:first').removeClass('has-error')
                .find('.select-error').addClass('hide');
        });
    });
    $('.time-error').addClass('hide');
}

function add_new_blackout_date(date) {
    //COUNT THE BLACKOUTS
    var count = ($('.blackout-date').length) + 1;

    var html = '<div class="blackout-single-wrapper">' +
        '<div class="alert alert-danger alert-style blackout-date clearfix" role="alert" >' +
        '<span class="badge">' + count + '</span>' +
        '   ' + date +
        '<a class="btn btn-danger btn-sm pull-right " id="remove-blackout-' + count + '" >Remove</a>' +
        '</div>' +
        '<input type="hidden" name="blackoutdates[' + count + ']"  class="blackout-form"  value="' + date + '">' +
        '</div>';
    $('#blackout-group-wrapper').append(html);
    //ADD EVENT LISTENER
    $("#remove-blackout-" + count).click(function() {
        $(this).parents('.blackout-single-wrapper:first').remove();
        //REINDEX AFTER EACH REMOVE
        reindex_blackouts();
    });

}

//REINDEX AFTER REMOVE
function reindex_blackouts(count) {
    $('#blackout-group-wrapper .blackout-single-wrapper').each(function(index) {
        var new_index = index + 1;
        //REINDEX BADGE NUMBERS
        $(this).find('.badge:first').html(new_index);

        //REIDEX FORM NAMES
        $(this).find('.blackout-form:first').attr('name', 'blackoutdates[' + new_index + ']');
    });
}