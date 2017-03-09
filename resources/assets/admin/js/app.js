/**
 * Created by unlike on 12.02.2017.
 */

$(document).ready(function() {
    $('.dd').nestable({
        expandBtnHTML: '<button data-action="expand"><i class="fa fa-fw fa-plus"></i></button>',
        collapseBtnHTML : '<button data-action="collapse"><i class="fa fa-fw fa-minus"></i></button>',
    });
    
    var $error = $('#shake_message');
    if ($error.length) {
        $error.modal('show');
    }
});


