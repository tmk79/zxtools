var tool_name = 'ChunkSpriter8x8';

var sprites_size_x = 1;
var sprites_size_y = 1;
var sprites_mode = 0;
var sprites_capture = {"x":0,"y":0}
var sprites_capture_begin = {"x":0,"y":0}
var work_mode = false;
var chunks_used_coords;

var selected_sprite_id = false;
var selected_chunk_id = false;

$(document).on('click', '#capture-sprite', function(){
	if ($(this).hasClass('active')) {
		$(this).removeClass('active');
		$('.capture').css('display', 'none');
		work_mode = false;
	} else {
		$(this).addClass('active');
		var cx = sprites_size_x==0 ? 8 * settings.image_zoom : sprites_size_x * 8 * settings.image_zoom;
		var cy = sprites_size_y==0 ? 8 * settings.image_zoom : sprites_size_y * 8 * settings.image_zoom;
		$('.capture').css('width', cx);
		$('.capture').css('height', cy);
		$('.capture').css('display', 'block');
		work_mode = 'capture';
	}
});

$(document).on('click', '#sprites-new', function(){
	work_mode = false;
	$('.capture').css('display', 'none');
	sprites_size_x = $('select[name="new[sprites_size_x]"]').val();
	sprites_size_y = $('select[name="new[sprites_size_y]"]').val();
	$.post('index.php?mode=' + tool_name + '&action=New',
		{"new[sprites_size_x]":sprites_size_x, "new[sprites_size_y]":sprites_size_y},
		function(data){
			answer = $.parseJSON(data);
			parse_ajax_answer(answer);
		}
	);
	$.popup.close();
});

$(document).on('mousemove', '.image', function(e){
	sprites_capture.x = Math.floor((e.pageX - $('.image').position().left) / (8 * settings.image_zoom));
	if (sprites_capture.x + sprites_size_x > 31) {
		//sprites_capture.x = 32 - sprites_size_x;
	}
	sprites_capture.y = Math.floor((e.pageY - $('.image').position().top) / (8 * settings.image_zoom)) ;
	if (sprites_capture.y + sprites_size_y > 23) {
		//sprites_capture.y = 24 - sprites_size_y;
	}
	if (work_mode == 'capture_end') {
		var x = sprites_capture.x - sprites_capture_begin.x + 1;
		var y = sprites_capture.y - sprites_capture_begin.y + 1;
		if (x < 1) { x = 1;}
		if (y < 1) { y = 1;}
		x = sprites_size_x==0 ? x : sprites_size_x;
		y = sprites_size_y==0 ? y : sprites_size_y;
		$('.capture').css('width', x * 8 * settings.image_zoom);
		$('.capture').css('height', y * 8 * settings.image_zoom);
	} else {
		$('.capture').css('left', sprites_capture.x * 8 * settings.image_zoom);
		$('.capture').css('top', sprites_capture.y * 8 * settings.image_zoom);
	}
});

$(document).on('click', '.image', function(e){
	if (work_mode == 'capture' || work_mode == 'capture_end') {
		if (work_mode == 'capture' && (sprites_size_x == 0 || sprites_size_y == 0)) {
			sprites_capture_begin.x = sprites_capture.x;
			sprites_capture_begin.y = sprites_capture.y	;
			work_mode = 'capture_end';
			return;
		}
		var capture_x = sprites_capture.x;
		var capture_y = sprites_capture.y;
		var size_x = sprites_size_x;
		var size_y = sprites_size_y;
		if (work_mode == 'capture_end') {
			capture_x = sprites_capture_begin.x;
			capture_y = sprites_capture_begin.y;
			size_x = sprites_capture.x - sprites_capture_begin.x + 1;
			size_y = sprites_capture.y - sprites_capture_begin.y + 1;
			if (size_x < 1) { size_x = 1;}
			if (size_y < 1) { size_y = 1;}	
		}

		$.post('index.php?mode=' + tool_name + '&action=Capture',
			{capture_x:capture_x, capture_y:capture_y, size_x:size_x, size_y:size_y},
			function(data){
				answer = $.parseJSON(data);
				parse_ajax_answer(answer);
			}
		);
		work_mode = 'capture';
		$('.capture').css('display', 'none');
		$('#capture-sprite').removeClass('active');
	}
});

$(document).on('click', '.chunk', function(){
	$('div.sprite-pointer').remove();
	$('div.chunk').removeClass('selected');
	$(this).addClass('selected');
	selected_chunk_id = $(this).attr('id').split('-')[1];
	var used = chunks_used_coords[selected_chunk_id];
	$.each(used, function(key, val){
		$('#sprite-' + val.sprite_id).append('<div class="sprite-pointer" style="top:' + (val.y * 16) + 'px; left:' + (val.x * 16) + 'px;"></div>');
	});
});

$(document).on('click', '.sprite', function(){
	$('div.sprite').removeClass('selected');
	$(this).addClass('selected');
	selected_sprite_id = $(this).attr('id').split('-')[1];
});