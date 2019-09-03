<script type="text/javascript">
    var element = $('#confirmСancelConfirm'),
        form = null;
    // CONFIRMATION DELETE MODAL
    element.on('show.bs.modal', function (e) {
        var message = $(e.relatedTarget).attr('data-message');
        var title = $(e.relatedTarget).attr('data-title');
        form = $(e.relatedTarget).closest('form');
        var cancelInfo = form.find('[name=cancel_info]').val();

        $(this).find('.modal-body p').text(message);
        $(this).find('.modal-body textarea#cancel_info').val(cancelInfo);
        $(this).find('.modal-title').text(title);
        $(this).find('.modal-footer #confirm').data('form', form);
        $(this).find('#modal-form-cancel').attr('action', form.attr('action'));
    });

    // element.find('.modal-footer #confirm').on('click', function () {
    //     var cancelInfoTextarea = $('#confirmСancel #cancel_info').val(),
    //         cancelInfoInput = $('<input>').attr('name', 'cancel_info').val(cancelInfoTextarea);
    //
    //     form.append(cancelInfoInput);
    //     form.submit();
    // });

</script>