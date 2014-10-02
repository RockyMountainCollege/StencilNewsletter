$.fn.editable.defaults.mode = 'inline';

$(document).ready(function() {
    $('#table a').editable({
        url: document.URL
    });
});

$(".delete").click(function () {
    $(this).parent().parents('tr').remove();
    $.post(document.URL, {'delete': this.id});
});
