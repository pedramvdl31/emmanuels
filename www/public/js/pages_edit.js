		$(document).ready(function() {
			page.page_load();
			page.events();
			page.stepy();
		});
		page = {
			page_load: function() {
				$.ajaxSetup({
					headers: {
						'X-CSRF-Token': $('meta[name=csrf-token]').attr('content')
					}
				});
				tinymce.init({
					fontsize_formats: "8pt 10pt 12pt 14pt",
					selector: ".content-body",
					toolbar: "undo redo pastetext| bold italic | styleselect | fontsizeselect"
				});
				$('.dd').nestable({
					maxDepth: 1
				});
				$('.dd').on('change', function() {
					list_reindex();
				});

				var count_onload = $(".dd ol li .dd-handle").length;
				if (count_onload > 0) 
				{
					if ($('#is_session').val() == 1) {
						var is_session = 1;
						set_slider_images_onload(is_session);
					} else {
						var is_session = 0;
						set_slider_images_onload(is_session);
					}
		        		set_browse_btn();
		        	};

		        },
		        stepy: function() {
		        	$("#deliveryStepy li a").click(function(e) {
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
		        	$('#title').friendurl({
		        		id: 'url'
		        	});
		        	$("#title").on("change", function () {
		        		$('#url').val("/"+urlfriendly($("#title").val()));
		        	});
		        	$(document).on('click', '#content .panel', function() {
		        		$(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
		        		$(this).removeClass('panel-default').addClass('panel-success');
		        	});
		        	$("#add-content").click(function() {
		        		var content_set_count = $(document).find('#content .panel-collapse').length;
		        		$(document).find('#content .panel-collapse').removeClass('in');
		        		$(document).find('#content .panel').removeClass('panel-success').addClass('panel-default');
		        		request.add_content(content_set_count);
		        	});
		        	$("#addSlide").click(function() {
		        		request.add_slider_image();
		        	});
		        	$("#preview-btn").click(function() {
		            // var serialized_data = $("#add-form").serialize();
		            // request.load_preview(serialized_data);
		        });

		        	$(document).on('click', '.remove-collapse', function() {
		            // console.log($(document).find('.content-area .content-set').length);
		            var count = 1;
		            $(".content-area .content-set").each(function(index) {
		            	$(this).find('.panel-title a .this-title').html('Content ' + count);
		            	count++;
		            });
		            var this_set = $(this).parents('.content-set').attr('this_set');

		            tinymce.remove('#content-body-' + this_set);
		            $(this).parents('.content-set:first').remove();
		            var count = $('#content_count').val();
		            re_count = (count == 0) ? null : count--;

		            $('#content_count').val(re_count);
		        });


		        	$(document).on('click', '.remove-img', function() {
		        		// var img_name = $(this).parents(".dd-item").attr('img-name');
		        		var _img_name = $(this).parents('li:first').find('img:first').attr('alt');
		        		var from = $(this).parents('li:first').attr('from');
		        			request.remove_image_temp(_img_name,from);
		        			if ($(this).parents('li:first').remove()) {
		        				list_reindex();
		        			};
		        	});

		        	// $(document).on('click', '.fileinput-remove', function() {	
		        	// 	// var img_name = $(this).parents(".dd-item").attr('img-name');
		        	// 	var _img_name = $(this).parents('li:first').find('img:first').attr('alt');
		        	// 	var img_count = $(this).parents(".dd").find("img[alt='"+_img_name+"']").length;
		        	// 	if (parseInt(img_count) == 1) {
		        	// 		request.remove_image_temp(_img_name);
		        			
		        	// 	} 
		        	// 	set_browse_btn();
		        	// });


		        }
		    };
		    request = {
		    	add_content: function(content_set_count) {

		    		var token = $('meta[name=_token]').attr('content');
		    		$.post(
		    			'/pages/content-add', {
		    				"_token": token,
		    				"content_set_count": content_set_count
		    			},
		    			function(results) {
		    				var status = results.status;
		    				var html = results.html;
		    				switch (status) {
		                    case 200: // Approved

		                    $('#content_count').val((content_set_count--));
		                    $('.content-area').append(html);
		                    tinymce.init({
		                    	fontsize_formats: "8pt 10pt 12pt 14pt",
		                    	selector: ".content-body",
		                    	toolbar: "undo redo pastetext| bold italic | styleselect | fontsizeselect"
		                    });
		                    break;

		                    default:
		                    break;
		                }

		            }
		            );
		    	},
		    	remove_image_temp: function(img_name,from) {
		    		var token = $('meta[name=_token]').attr('content');
		    		$('.submit-btn').addClass('disabled');
		    		$.post(
		    			'/pages/remove-temp', {
		    				"_token": token,
		    				"img_name": img_name,
		    				"from":from
		    			},
		    			function(results) {
		    				var status = results.status;
		    				switch (status) {
		                    case 200: // Approved
		                    session_reindex();
		                    $('.submit-btn').removeClass('disabled');
		                    break;

		                    default:
		                    $('.submit-btn').removeClass('disabled');
		                    break;
		                }
		            }
		            );
		    	},
		    	save_image_temp: function(file) {
		    		var token = $('meta[name=_token]').attr('content');
		    		$.post(
		    			'/pages/image-temp', {
		    				"_token": token,
		    				"file": file
		    			},
		    			function(results) {
		    				var status = results.status;
		    				switch (status) {
		                    case 200: // Approved
		                        // $('#content_count').val((content_set_count--));
		                        // $('.content-area').append(html);
		                        break;

		                        default:
		                        break;
		                    }
		                }
		                );
		    	},
		    	add_slider_image: function() {
		    		var token = $('meta[name=_token]').attr('content');
		    		var order = $(".dd ol li .dd-handle").length + 1;
		    		$.post(
		    			'/pages/insert-slide', {
		    				"_token": token,
		    				order: order
		    			},
		    			function(results) {
		    				var status = results.status;
		    				var html = results.html;
		    				var order = results.order;
		    				switch (status) {
		                    case 200: // Approved

		                    $('.dd-list').append(html);
		                    file_input_init(order);

		                    break;
		                    default:
		                    break;
		                }
		            }
		            );
		    	},
		    	session_reindex: function(session_data) {
		    		var token = $('meta[name=_token]').attr('content');
		    		$.post(
		    			'/pages/session-reindex', {
		    				"_token": token,
		    				"session_data": session_data
		    			},
		    			function(results) {
		    				var status = results.status;
		    				switch (status) {
		                    case 200: // Approved
		                  	  $('.submit-btn').removeClass('disabled');
		                    break;
		                    default:
		                    break;
		                }
		            }
		            );
		    	}
		    };
		    function file_input_init(order) {
		    	var $el2 = $("#input-706-" + order);
			    // custom footer template for the scenario
			    // the custom tags are in braces
			    var footerTemplate = '<div class="file-thumbnail-footer">\n' +
			    '   <div style="margin:5px 0">\n' +
			    '       <input class="kv-input kv-new form-control input-sm {TAG_CSS_NEW}" value="{caption}" placeholder="Enter caption...">\n' +
			    '       <input class="kv-input kv-init form-control input-sm {TAG_CSS_INIT}" value="{TAG_VALUE}" placeholder="Enter caption...">\n' +
			    '   </div>\n' +
			    '   {actions}\n' +
			    '</div>';
			    $el2.fileinput({
			    	uploadUrl: '/pages/image-temp',
			    	uploadAsync: false,
			    	maxFilesNum: 1,
			    	maxFileCount: 1,
			    	overwriteInitial: false,
			    	layoutTemplates: {
			    		footer: footerTemplate
			    	},
			    	previewThumbTags: {
			            '{TAG_VALUE}': '', // no value
			            '{TAG_CSS_NEW}': '', // new thumbnail input
			            '{TAG_CSS_INIT}': 'hide' // hide the initial input
			        },
			        initialPreview: [],
			        initialPreviewConfig: [

			        ],
			        initialPreviewThumbTags: [

			        ],
			        uploadExtraData: function() { // callback example
			        	var out = {},
			        	key = "order";
			        	out[key] = order;
			        	return out;
			        }
			    }).on("filebatchselected", function(event, files) {
		        // trigger upload method immediately after files are selected
		        $el2.fileinput("upload");
		        session_reindex();
		        set_browse_btn();
		        set_image_name(order,files[0]['name']);
		        $('.submit-btn').addClass('disabled');
		    }).on('filebatchuploadcomplete', function(event, files, extra) {

		    });
		}
		function list_reindex() {
			var div_count = $(".dd ol li .dd-handle").length;
			var session_data = {

			};
			$('.dd > ol > li > .dd-handle ').each(function(e) {
				var count = e + 1;
				$(this).html('<i class="glyphicon glyphicon-move"></i>&nbsp;'+count+'');
				$(this).attr('order', count);
			});
			$('.dd > ol > li').each(function(e) {
				var order = $(this).find('.dd-handle').attr('order');
				var image_name = $(this).find('img').attr('alt');
				var from = $(this).attr('from');
				var image_name_new = image_name.replace(/\s+/g, "-");
				if (image_name_new !== undefined) {
					session_data[order] = [image_name_new];
					session_data[order].push(from);
				}
			});
			request.session_reindex(session_data);
		}

		function session_reindex() {

			setTimeout(function(){ 

				var div_count = $(".dd ol li .dd-handle").length;
				var session_data = {
				};
				$('.dd > ol > li').each(function(e) {
					var order = $(this).find('.dd-handle').attr('order');
					var image_name = $(this).find('img').attr('alt');
					var from = $(this).attr('from');
					var image_name_new = image_name.replace(/\s+/g, "-");
					if (image_name_new !== undefined) {
						session_data[order] = [image_name_new];
						session_data[order].push(from);
					}
				});
				request.session_reindex(session_data);
			}, 3000);

		}

		function set_slider_images_onload(is_session) {
			$('.dd > ol > li').each(function(e) {
				var order = $(this).find('.dd-handle').attr('order');
				var image_path = $(this).find('.dd-handle').attr('image_path');
				var from = $(this).attr('from');
				file_input_init_onload(order, image_path,is_session,from);
			});

			session_reindex();
		}

		function set_browse_btn() {
			$('.dd > ol > li').each(function(e) {
				count_images = $(this).find('.file-preview-frame img').length;
				if (count_images != 0) {
					$(this).find('.btn-file').addClass('disabled');
				} else {
					$(this).find('.btn-file').removeClass('disabled');
				}
			});
		}

		function set_image_name(order,img_name) {
			$(document).find('.dd > ol .dd-item[data-id = '+order+']').attr('img-name',img_name);
		}

		function file_input_init_onload(order, image_path,is_session,from) {
			var $el2 = $("#input-706-" + order);

		    // custom footer template for the scenario
		    // the custom tags are in braces
		    var footerTemplate = '<div class="file-thumbnail-footer">\n' +
		    '   <div style="margin:5px 0">\n' +
		    '       <input class="kv-input kv-new form-control input-sm {TAG_CSS_NEW}" value="{caption}" placeholder="Enter caption...">\n' +
		    '       <input class="kv-input kv-init form-control input-sm {TAG_CSS_INIT}" value="{TAG_VALUE}" placeholder="Enter caption...">\n' +
		    '   </div>\n' +
		    '   {actions}\n' +
		    '</div>';
		    var this_path = '';
		    this_path = '/img/'+from+'/'+image_path;

		    $el2.fileinput({
		    	uploadUrl: '/pages/image-temp',
		    	uploadAsync: false,
		    	maxFilesNum: 1,
		    	maxFileCount: 1,
		    	overwriteInitial: true,
		    	layoutTemplates: {
		    		footer: footerTemplate
		    	},
		    	previewThumbTags: {
		            '{TAG_VALUE}': image_path, // no value
		            '{TAG_CSS_NEW}': 'hide', // new thumbnail input
		            '{TAG_CSS_INIT}': '' // hide the initial input
		        },
		        initialPreview: [

		        "<img src='"+this_path+"' class='file-preview-image' alt='"+image_path+"' title=''>"

		        ],
		        initialCaption: image_path,
		        initialPreviewConfig: [{
		        	caption: image_path,
		        	width: "120px",
		        	url: "/site/file-delete",
		        	key: 1
		        }],
		        initialPreviewThumbTags: [{
		        	'{TAG_VALUE}': image_path,
		        	'{TAG_CSS_NEW}': 'hide',
		        	'{TAG_CSS_INIT}': ''
		        }, {
		        	'{TAG_CSS_NEW}': 'hide',
		        	'{TAG_CSS_INIT}': ''
		        }],


		        uploadExtraData: function() { // callback example
		        	var out = {},
		        	key = "order";
		        	out[key] = order;
		        	return out;
		        }
		    }).on("filebatchselected", function(event, files) {
		        // trigger upload method immediately after files are selected
		        $el2.fileinput("upload");
		        session_reindex();
		        set_browse_btn();
		        set_image_name();
		        $('.submit-btn').addClass('disabled');
		    }).on('filebatchuploadcomplete', function(event, files, extra) {

		    	
		    });

		}
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