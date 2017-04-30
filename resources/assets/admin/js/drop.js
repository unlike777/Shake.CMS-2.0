$(document).ready(function() {

	window.files_count = 0;
	window.upload_count = 0;
	
	function getExtension(a) {
		a = a.split('.');
		a = a[a.length-1];
		a = a.toLowerCase();
		return a;
	}

	var ext_arr = ['png', 'jpg', 'jpeg', 'bmp', 'rar', 'tar', 'zip', 'gzip', 'pdf', 'mp3', 'doc', 'docx', 'xls', 'xslx'],
		max_file_size = 20*1024*1024;
	
	
	
	$('.drop').each(function() {
		var $drop = $(this),
			$drop_zone = $drop.find('.drop__zone');


		function uploadProgress(e) {
			//var percent = parseInt(e.loaded / e.total * 100);
			//$drop_zone.text('Загрузка: ' + percent + '%');
			//console.log(e);
		}

		function stateChange(e) {
			if (e.target.readyState == 4) {
				if (e.target.status == 200) {
					
					upload_count++;

					var percent = parseInt(upload_count / files_count * 100);
					$drop_zone.text('Загрузка: ' + percent + '%');
					
					if (upload_count >= files_count) {
						$drop_zone.text('Загрузка успешно завершена!');
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
			
			for (var i = 0; i < file.length; i++) {
				var xhr = new XMLHttpRequest();
			
				xhr.upload.addEventListener('progress', uploadProgress, false);
				xhr.onreadystatechange = stateChange;
				xhr.open('POST', '/admin/ajax/upload');
				xhr.setRequestHeader('X-FILE-NAME', encodeURIComponent(file[i].name));
				// xhr.setRequestHeader('X-XSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
				var fd = new FormData;
				fd.append("file", file[i]);
				fd.append("field", $drop.attr('data-field'));
				fd.append("model", $drop.attr('data-model'));
				fd.append("id", $drop.attr('data-id'));
				fd.append("_token", $('meta[name="csrf-token"]').attr('content'));
				xhr.send(fd);
			}

		};
		
	});
	
	
	$('.drop__file_list').on('click', '.drop__file_item_del', function() {
		var $this = $(this),
			$parent = $this.parents('.drop__file_item:first'),
			id = $parent.attr('data-id');
		
		my.post('/admin/ajax/delete', {id: id}, function(data) {
			if (data.error == 0) {
				$parent.remove();
			}
		}, 'json')
		
	});
	
});

$(window).on('load', function() {

});
