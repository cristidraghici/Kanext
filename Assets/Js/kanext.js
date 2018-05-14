(function () {
    // Close modal on overlay click
    KB.onClick('#modal-overlay', function () {
        KB.modal.close();
    });

    // Close dropdown on second click
    $(document).on('click', '.dropdown-menu', function(e) {
      if (document.getElementById('dropdown') !== null) {
        e.preventDefault();
        e.stopImmediatePropagation();

        KB.trigger('dropdown.beforeDestroy');
        $("#dropdown").remove();
      }
    });
}());

// Transform table-list-row into link
$(document).ready(function(){
    $(".table-list-row").each(function(index, value) {
      var row = $(value);
      var child = row.find('.table-list-title > a');

      if (child.length === 1) {
        if (child.attr('href')) {
          row.unbind('click')
          row.bind('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            location.href = child.attr('href');
          })
          row.css('cursor', 'pointer');
        }
      }
    });
});
