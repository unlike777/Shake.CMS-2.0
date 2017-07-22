$(document).ready(function() {

	//добавляем еще один блок
	$('body').on('click', '#ufields__add', function() {
		var $tmp = $('.ufields__item--gag').clone().removeClass('ufields__item--gag');
		$('.ufields__item:last').parents('form:first').after($tmp);
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
					var changed_item = $(data.data).find('.ufields__form--changed');
					$form.replaceWith(changed_item);
					$('.ufields__form--changed').removeClass('ufields__form--changed');
					$('.ufields__sign').fadeIn(function() {
						setTimeout(function() {
							$('.ufields__sign').fadeOut(function() {
								$('.ufields__sign').remove();
							});
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

		if (id > 0) {
			if (confirm('Вы точно хотите удалить поле?')) {
				$.get('/admin/fields/delete/'+id, function(data) {
					if (data.error > 0) {
						alert(data.data);
					} else {
						$('#ufields').replaceWith(data.data);
					}
				});
			}
		} else {
			$item.remove();
		}
		
	});
	
	$('body').on('click', '.ufields__change', function() {
		var $this = $(this);
		var $item = $this.parents('.ufields__item:first');
		
		$this.hide();
		$item.find('.ufields__input input').removeAttr('disabled');
		$item.find('.ufields__delete').show();
	});
	
});

$(window).on('load', function() {

});
