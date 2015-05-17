var wait_box = '<div class="wait-box">Processing...</div>';
var settings = {
	"image_zoom":2,
}

$(document).on('click', '.confirm', function() {
    var question = $(this).html();
    if ($(this).attr('rel') != undefined) {
        question = $(this).attr('rel');
    }
    var href = get_href($(this), false);
    if (href == false) {
        return false;
    }
    var cl = $(this).attr('class').replace('button', '').replace('confirm', '');
	$.post('/index.php?ajax=1&action=GetConfirmForm', {question:question, href:href, cl:cl}, function(data){
		$.popup({content:data});
	});
    return false;
});
/*
$(document).on('mousedown', 'a', function(){
	var cl = $(this).attr('class');
	var cl_split = cl.split(' ');
	if (!($(this).hasClass('confirm'))) {
		$.each(cl_split, function(key, val) {
			if (val.indexOf('add-var:')+1) {
				var tmp = val.split(':');
				href += '&' + tmp[1] + '=' + window[tmp[1]];
			}
		});
	}
});*/

$(document).on('click', '.ajax', function() {
    if (!($(this).hasClass('confirm'))) {
        var href = get_href($(this), true);
        var ajax_class = $(this).attr('class');
        if ($(this).hasClass('waitbox')) {
            $.popup({content:wait_box});
		}
		$.post('/' + href, function(data){
			if (ajax_class.indexOf('ajax-show')+1) {
				$.popup({content:data,
					onClosed:function(){
						if (ajax_class.indexOf('ajax-reload')+1){
							document.location.reload();
						}
					}
				});
			} else if (ajax_class.indexOf('ajax-callback')+1) {
				var ajax_callback = get_url_var(href,'ajax_callback');
				window[ajax_callback](data);
			} else if (ajax_class.indexOf('ajax-reload')+1) {
				document.location.reload();
			}
		});
	}
	return false;
});

function get_href(obj, flag_add_ajax) {
    var href = $(obj).attr('href');
	var cl = $(obj).attr('class');
	var cl_split = cl.split(' ');
	if (href.indexOf('ajax=') == -1) {
		cl_split['ajax'] = 1;
	}
    if ($(obj).hasClass('only-checked') || $(obj).hasClass('notonly-checked')) {
        var oids = [];
        $('input.chk:checked').each(function() {
            oids.push($(this).attr('id').split('-')[1]);
        });
        if ($(obj).hasClass('only-checked') && oids.length == 0) {
            return false;
        }
        if (!($(obj).hasClass('confirm'))) {
            href += '&oids=' + oids.join(',', oids);
        }
    }
	if (!($(obj).hasClass('confirm'))) {
		$.each(cl_split, function(key, val) {
			if (val.indexOf('add-var:')+1) {
				var tmp = val.split(':');
				href += '&' + tmp[1] + '=' + window[tmp[1]];
			}
		});
	}
    return href;
}

$(document).on('click', '.button-open', function(){
	if ($('input[name=file]').val() == '') {
		return false;
	}
	$('.form-bottom').css('display','none');
	$('.form-waitbox').css('display','block');
	var form = $('.form-open');
	var data = form.formSerialize();
	var options = {
		type: 'POST',
		enctype: "multipart/form-data",
		url: form.attr('action'),
		success: function(data) {
			answer = $.parseJSON(data);
			parse_ajax_answer(answer);
			$.popup.close();
		}
	};
	form.ajaxSubmit(options);
});

function parse_ajax_answer(answer) {
	if (answer.error != undefined) {
		$.popup({content:answer.error});
	} else {
		if (answer.tools_info != undefined) {
			$('.tools-info').html(answer.tools_info);
		}
		if (answer.img_src != undefined) {
			$('img#image').attr('src', answer.img_src);
		}
		if (answer.vars != undefined) {
			$.each(answer.vars, function(key, val) {
				window[key] = val;
			});
		}
	}
}

$(document).on('click', '.submit', function(){
	var form = $(this).parents('form').first();
	form.submit();
	return false;
});

var ajax_form = false;
$(document).on('submit', '.ajax-form', function(){
    ajax_form = $(this);
	var data = $(this).formSerialize();
	var options = {
		type: 'POST',
		enctype: "multipart/form-data",
		url: $(this).attr('action'),
		success: function(data) {
			if (ajax_form.hasClass('success-json')) {
				answer = $.parseJSON(data);
				parse_ajax_answer(answer);
				$.popup.close();
			} else if (ajax_form.hasClass('ajax-download')) {
            } else if (ajax_form.hasClass('ajax-show')) {
                $.popup({content:data});
			} else if (ajax_form.hasClass('ajax-reload')) {
				document.location.reload();
			}
		}
	};
	$(this).ajaxSubmit(options);
	return false;
});


$(document).on('click', '#img-edit-grid', function(){
	$('.image-layer.grid').toggle();
	if ($(this).hasClass('active')) {
		$(this).removeClass('active');
	} else {
		$(this).addClass('active');
	}
	return false;
});