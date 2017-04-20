$(function() {

    $('.table__row_delete').on('click', function () {
        return confirm('Вы точно хотите удалить объект?') ? true : false;
    });

    $('.table__check_all').on('click', function () {
        var $this = $(this),
            $objects = $('.table__checkbox');

        if ($this.is(':checked')) {
            $objects.attr('checked', 'checked');
        } else {
            $objects.removeAttr('checked');
        }
    });


    $('.table__multi_delete').on('click', function() {
        var $this= $(this),
            $objects = $('.table__checkbox:checked');

        if ($objects.length == 0) {
            my.alert('Нужно отметить хотябы один объект');
        } else {
            if (confirm('Вы точно хотите удалить выбранные объекты?')) {

                var arr = [];
                $objects.each(function () {
                    arr.push($(this).parents('tr:first').attr('data-id'));
                });
                
                my.post($this.attr('data-route'), {objects: arr}, function(data) {
                    if (!data.error) {
                        $objects.each(function() {
                            $(this).parents('tr:first').remove();
                        });
                    }
                }, 'json');

            }
        }

        return false;
    });



    $('.table__row_eye').on('click', function () {
        var $this = $(this),
            $parent = $this.parents('tr:first');

        my.post($this.attr('data-route'), {objects: [$parent.attr('data-id')]}, function(data) {

            if (data.error == 0) {
                if ($this.hasClass('glyphicon-eye-open')) {
                    $this.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
                } else {
                    $this.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
                }
            }

        }, 'json');
    });

    $('.table__multi_active').on('click', function() {
        var $this= $(this),
            $objects = $('.table__checkbox:checked');

        if ($objects.length == 0) {
            my.alert('Нужно отметить хотябы один объект');
        } else {

            var arr = [];
            $objects.each(function () {
                arr.push($(this).parents('tr:first').attr('data-id'));
            });

            my.post($this.attr('data-route'), {objects: arr}, function(data) {
                if (data.error == 0) {
                    $objects.each(function() {
                        var $eye = $(this).parents('tr:first').find('.table__row_eye');
                        if ($eye.hasClass('glyphicon-eye-open')) {
                            $eye.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
                        } else {
                            $eye.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
                        }
                    });
                }
            }, 'json');

        }

        return false;
    });

    $('.table__row').on('dblclick', function(e) {
        var $this = $(this),
            url = $this.attr('data-edit');

        if (url) {
            location.href = url;
        }
    });
    
});
