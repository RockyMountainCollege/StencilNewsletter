$("#deleteBtn").click(function() {
    $("#action").val('delete');
    $("#reports").submit();
    $('#confirm').modal('hide');
});
