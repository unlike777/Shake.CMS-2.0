/**
 * Created by unlike on 12.02.2017.
 */

jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    var $error = $('#shake_message');
    if ($error.length) {
        $error.modal('show');
    }
    
    $('.js_delete_confirm').on('click', function() {
    	if (!confirm('Вы точно хотите удалить запись?')) {return false;}
	});
});


