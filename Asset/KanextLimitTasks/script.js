Kanboard.KanextLimitTasks = function(app) {
  this.app = app;
};

Kanboard.KanextLimitTasks.prototype.execute = function() {
  if (this.app.hasId("board")) {
      this.executeListeners();
      this.kanextLimitTasks();
  }
}

Kanboard.KanextLimitTasks.prototype.onBoardRendered = function() {
  if (this.app.hasId("board")) {
      this.kanextLimitTasks();
  }
}

Kanboard.KanextLimitTasks.prototype.kanextLimitTasks = function() {
  var self = this;

  $('.kanext_limit_show_more_button').each(function () {
    var el = $(this);
    var loadMoreTasks = el.find('a');

    if (el.find('i.kanext_limit_show_more_button_loader').length > 0) {
      return;
    }

    var loadingIndicator = $('<i class="fa fa-spinner fa-pulse kanext_limit_show_more_button_loader" />');

    el.append(loadingIndicator);

    loadMoreTasks.unbind('click');
    loadMoreTasks.click(function(e) {
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
          /**
           * The code below needs to be cleaned up, as it is created with trial and error
           */
          var column = loadMoreTasks.closest('.board-column-' + column_id).find('.board-task-list')[0];
          var newData = $(data)[0];

          column.replaceWith(newData);

          self.executeListeners();
        },
        error: function() {
          loadMoreTasks.show();
        },
        complete: function () {
          loadingIndicator.hide();
        }
      });
    });
  })
}

Kanboard.KanextLimitTasks.prototype.executeListeners = function() {
  for (var className in this.app.controllers) {
    var controller = this.app.get(className);

    if (typeof controller.onBoardRendered === "function") {
      controller.onBoardRendered();
    }
  }

  // Add support for drag and drop
  this.app.get('BoardDragAndDrop').dragAndDrop();
};
