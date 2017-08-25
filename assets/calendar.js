$(function () {
    var createForm = $('#create-event');
    $('form', createForm).submit(function () {
        $.post(this.action, $(this).serialize(), function (data) {
            alert(data['result']);
            $('#calendar-table').html(data['html']);
        });
        return false;
    });
    $('#print-events').submit(function () {
        $.post(this.action, $(this).serialize(), function (data) {
            if (data === '') {
                alert('Нет данных для печати');
                return false;
            }
            $('body').addClass('printSelected').append('<div class="printSelection">' + data + '</div>');
            window.print();
            window.setTimeout(function () {
                $('body').removeClass('printSelected');
                $('.printSelection').remove();
            }, 0);
        });
        return false;
    });
    $(document).on('click', '.post-data', function () {
        var $this = $(this);
        if ($this.hasClass('delete')) {
            if (!confirm('Вы уверены?')) {
                return false;
            }
        }
        $.post($this.data('url'), function (data) {
            if ($this.hasClass('show-modal')) {
                var modalEvents = $('#modal-events');
                $('.modal-body', modalEvents).html(data);
                modalEvents.modal('show');
            }
            if ($this.hasClass('delete')) {
                location.reload();
            }
        });
    });
});
