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
