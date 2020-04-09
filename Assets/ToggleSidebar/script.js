(function() {
  var bodyElement = $('body');
  var sidebarElement = $('.sidebar');
  var sidebarContentElement = $('.sidebar-content');

  var toggleSidebarBtn = $('<button class="btn button-minimize"><i class="fa fa-bars" aria-hidden="true"></i></button>');
  var backDropElement = $('<div class="sidebar-content-overlay"></div>');

  var isSidebarElementVisible = false;

  var toggleFn = function() {
    isSidebarElementVisible = !isSidebarElementVisible;

    if ( isSidebarElementVisible === false) {
      sidebarElement.hide();
      backDropElement.hide();

      bodyElement.removeClass('toggle-sidebar--visible');

      return;
    }

    bodyElement.addClass('toggle-sidebar--visible');

    sidebarElement.show();
    backDropElement.show();

  }

  if (sidebarContentElement.length) {
    toggleSidebarBtn.click(toggleFn);
    sidebarElement.click(toggleFn);
    backDropElement.click(toggleFn)

    sidebarContentElement.prepend(toggleSidebarBtn);
    bodyElement.append(backDropElement);
  }
}());
