(function() {
  var bodyElement = $('body');
  var sidebarElement = $('.sidebar');
  var sidebarContentElement = $('.sidebar-content');

  var toggleSidebarBtn = $('<button class="btn button-minimize"><i class="fa fa-bars" aria-hidden="true"></i></button>');
  var backDropElement = $('<div class="sidebar-content-overlay"></div>');

  var toggleFn = function(){
    sidebarElement.toggle(300);
    backDropElement.toggle();
  }

  if (sidebarContentElement.length) {
    toggleSidebarBtn.click(toggleFn);
    sidebarElement.click(toggleFn);
    backDropElement.click(toggleFn)

    sidebarContentElement.prepend(toggleSidebarBtn);
    bodyElement.append(backDropElement);
  }
}());
