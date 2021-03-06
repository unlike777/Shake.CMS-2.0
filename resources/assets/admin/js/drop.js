$(document).ready(function() {

	$('.drop__file_list').sortable({
		// group: '.drop__file_list',
		containerSelector: '.drop__file_list',
		itemSelector: '.drop__file_item',
		vertical: false,
		pullPlaceholder: true,
		placeholder: '<div class="drop__file_item drop__file_item--placeholder"></div>',
		bodyClass: '',
		onDrop: function($item, container, _super, event) {
			$item.removeClass(container.group.options.draggedClass).removeAttr("style")
			$("body").removeClass(container.group.options.bodyClass)
			
			var params = {
				'item_id': $item.attr('data-id'),
				'left_item_id': $item.prev().attr('data-id'),
			};
			
			$.post('/admin/ajax/move', params, function(data) {
				
			}, 'json').fail(function() {
				alert('Произошла ошибка, сортировка не применилась');
			});
		},
		handle: 'a',
	});
	
	
	window.files_count = 0;
	window.upload_count = 0;
	
	function getExtension(a) {
		a = a.split('.');
		a = a[a.length-1];
		a = a.toLowerCase();
		return a;
	}

	var ext_arr = ['png', 'jpg', 'jpeg', 'bmp', 'rar', 'tar', 'zip', 'gzip', 'pdf', 'mp3', 'doc', 'docx', 'xls', 'xslx'];
	var	max_file_size = 20 * 1024 * 1024;
	
	$('.drop').each(function() {
		var $drop = $(this),
			$drop_zone = $drop.find('.drop__zone');


		function uploadProgress(e) {
			//var percent = parseInt(e.loaded / e.total * 100);
			//$drop_zone.text('Загрузка: ' + percent + '%');
			//console.log(e);
		}

		function stateChange(e, file_arr, i) {
			if (e.target.readyState == 4) {
				if (e.target.status == 200) {
					
					upload_count++;

					var percent = parseInt(upload_count / files_count * 100);
					$drop_zone.text('Загрузка: ' + percent + '%');
					
					if (upload_count >= files_count) {
						$drop_zone.text('Загрузка успешно завершена!');
					} else {
						if (file_arr[i + 1]) {
							sendFile(file_arr, i + 1);
						}
					}
					
					//$drop_zone.removeClass('drop__zone--error');
					//if ($('#addto[checked]').length > 0)
					//	$drop_zone.nextAll('.dropZoneList').prepend(e.target.responseText);
					//else
					//	$drop_zone.nextAll('.dropZoneList').append(e.target.responseText);

					//console.log(e);

					var data = JSON.parse(e.target.responseText);
					
					$drop.find('.drop__file_list').append(data.data);
					
					//console.log(e.target.responseText);
				} else {
					$drop_zone.text('Произошла ошибка! Загружено файлов: '+upload_count);
					$drop_zone.addClass('drop__zone--error');
				}
			}
		}
		
		function sendFile(file_arr, i) {
			var xhr = new XMLHttpRequest();
			var file = file_arr[i];
			
			xhr.upload.addEventListener('progress', uploadProgress, false);
			xhr.onreadystatechange = function(e) {
				stateChange(e, file_arr, i);
			}; 
			xhr.open('POST', '/admin/ajax/upload');
			xhr.setRequestHeader('X-FILE-NAME', encodeURIComponent(file.name));
			// xhr.setRequestHeader('X-XSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
			var fd = new FormData;
			fd.append("file", file);
			fd.append("field", $drop.attr('data-field'));
			fd.append("model", $drop.attr('data-model'));
			fd.append("id", $drop.attr('data-id'));
			fd.append("_token", $('meta[name="csrf-token"]').attr('content'));
			xhr.send(fd);
		}
		
		
		if (typeof(window.FileReader) == 'undefined') {
			$drop_zone.text('Не поддерживается браузером!');
			$drop_zone.addClass('drop__zone--undefined');
			return false;
		}

		$drop_zone[0].ondragover = function() {
			$drop_zone.addClass('drop__zone--hover');
			return false;
		};

		$drop_zone[0].ondragleave = function() {
			$drop_zone.removeClass('drop__zone--hover');
			return false;
		};

		$drop_zone[0].ondrop = function(e) {
			e.preventDefault();
			$drop_zone.removeClass('drop__zone--hover');
			$drop_zone.removeClass('drop__zone--error');
			$drop_zone.addClass('drop__zone--drop');

			var file = e.dataTransfer.files;
			
			files_count = file.length;
			upload_count = 0;

			for (var i = 0; i < file.length; i++) {
				
				if (file[i].size > max_file_size) {
					$drop_zone.html('Один или несколько файлов слишком большие! Ограничение '+Math.floor(max_file_size/1024/1024)+'&nbsp;Мб');
					$drop_zone.addClass('drop__zone--error');
					return false;
				}

				var ext = getExtension(file[i].name);

				if (!my.in_array(ext, ext_arr)) {
					$drop_zone.text('Данный тип файлов запрещен!');
					$drop_zone.addClass('drop__zone--error');
					return false;
				}
			}

			$drop_zone.text('Загрузка: 0%');

			sendFile(file, 0);

		};
		
	});
	
	
	$('.drop__file_list').on('click', '.drop__file_item_del', function(e) {
		
		e.preventDefault();
		
		var $this = $(this),
			$parent = $this.parents('.drop__file_item:first'),
			id = $parent.attr('data-id');
		
		my.post('/admin/ajax/delete', {id: id}, function(data) {
			if (data.error == 0) {
				$parent.remove();
			}
		}, 'json')
		
		return false;
	});
	
});

$(window).on('load', function() {

});
