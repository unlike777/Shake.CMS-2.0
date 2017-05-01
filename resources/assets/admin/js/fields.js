$(document).ready(function() {

	//добавляем еще один блок
	$('body').on('click', '#ufields__add', function() {
		var $tmp = $('.ufields__item--gag').clone().removeClass('ufields__item--gag');
		$('.ufields__item:last').after($tmp);
	});
	
	$('body').on('click', '.ufields__save', function() {
		var $this = $(this),
			$item = $this.parents('.ufields__item:first'),
			$parent = $this.parents('.ufields:first'),
			id = $item.attr('data-id'),
			parent_id = $parent.attr('data-id'),
			$form = $this.parents('form:first');
		
		
		var url = '/admin/fields/create/'+parent_id;
		
		if (id > 0) {
			url = '/admin/fields/update/'+id;
		}
		
		$form.ajaxSubmit({
			type: 'POST',
			dataType: 'json',
			url: url,
			success: function(data) {
				
				if (data.error > 0) {
					alert(data.data);
				} else {
					$('#ufields').replaceWith(data.data);
					$('.ufields__sign').fadeIn(function() {
						setTimeout(function() {
							$('.ufields__sign').fadeOut();
						}, 1200);
					});
				}
				
			},
			error: function() {
				alert('Сервер временно не доступен, обновите страницу и попробуйте снова');
			}
		});
	});
	
	$('body').on('click', '.ufields__delete', function() {
		var $this = $(this),
			$item = $this.parents('.ufields__item:first'),
			id = $item.attr('data-id');
		
		if (confirm('Вы точно хотите удалить поле?')) {
			if (id > 0) {
				$.get('/admin/fields/delete/'+id, function(data) {
					if (data.error > 0) {
						alert(data.data);
					} else {
						$('#ufields').replaceWith(data.data);
					}
				});
			} else {
				$item.remove();
			}
		}
		
	});
	
});

$(window).on('load', function() {

});
