(function() {
  $('.kanext_limit_show_more_button').each(function () {
    var el = $(this);

    var loadMoreTasks = el.find('a');
    var loadingIndicator = $('<i class="fa fa-spinner fa-pulse kanext_limit_show_more_button_loader" />');

    el.append(loadingIndicator);

    loadMoreTasks.click(function (e) {
      e.preventDefault();

      var url = loadMoreTasks.attr('href');
      var column_id = loadMoreTasks.data('column-id');

      $.ajax({
        cache: false,
        url: url,
        beforeSend: function () {
          loadMoreTasks.hide();
          loadingIndicator.show();
        },
        success: function(data) {
          loadMoreTasks
            .closest('.board-column-' + column_id)
            .find('.board-task-list')
            .replaceWith(data);
        },
        error: function() {
          loadMoreTasks.show();
        },
        complete: function () {
          loadingIndicator.hide();
        }
      });
    });
  });
}());
