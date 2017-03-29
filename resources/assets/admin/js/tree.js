$(document).ready(function() {
	
    $('.dd').nestable({
        expandBtnHTML: '<button data-action="expand"><i class="fa fa-fw fa-plus"></i></button>',
        collapseBtnHTML : '<button data-action="collapse"><i class="fa fa-fw fa-minus"></i></button>',
        onEndEvent: function() {
			var $this = $(this),
				id = $this.attr('data-id'),
				$parent = $this.parents('li:first'),
				$prev = $this.prev('.dd-item');
			
			var parent_id = 0,
				before_id = 0;
			
			if ($parent.length) {
				parent_id = $parent.attr('data-id');
				$.cookie( 'admin_pages['+parent_id+']', '1', { path: '/' });
			}
			
			if ($prev.length) {
				before_id = $prev.attr('data-id');
			}
			
			$.post('/admin/pages/position', {id: id, parent_id: parent_id, before_id: before_id}, function(data) {
				if (data.error) {
					alert(data.error.text);
				}
			}, 'json');
		}
    });
	
	$('.tree .eye_btn').on('click', function(e) {
		e.preventDefault();
		
		var $this = $(this),
			$parent = $this.parents('.dd-item:first'),
			id = $parent.attr('data-id');
		
		$.post('/admin/pages/active', {objects: [id]}, function(data) {
			if (data.error) {
				alert(data.error.text);
			} else {
				
				if ($this.hasClass('glyphicon-eye-open')) {
					$this.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
				} else {
					$this.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
				}
				
			}
		}, 'json');
	});
    
    $('.tree').on('click', 'button[data-action="collapse"]', function() {
        var $this = $(this);
        var parent_id = $this.parents('.dd-item').attr('data-id');
        // console.log($.removeCookie('admin_pages['+parent_id+']'));
		$.cookie( 'admin_pages['+parent_id+']', '', { path: '/' });
    });

    $('.tree').on('click', 'button[data-action="expand"]', function() {
        var $this = $(this);
        var parent_id = $this.parents('.dd-item').attr('data-id');
        $.cookie( 'admin_pages['+parent_id+']', '1', { path: '/' });
    });
    
    var open_pages = $.cookie('admin_pages') || [];
	
    $('.tree .dd-item').each(function() {
    	var $this = $(this);
        var id = $this.attr('data-id');
		
		if (!$.cookie('admin_pages['+id+']')) {
			var $button = $this.find('button[data-action="collapse"]:first');
			if ($button.length) {
				$button.click();			
			}
		}
    });
});


