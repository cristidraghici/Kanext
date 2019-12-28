(function() {
  var sidebarContent = $('.sidebar-content');
  if (sidebarContent.length) {
    var toggleSidebarBtn = $('<button class="btn button-minimize"><i class="fa fa-ellipsis-v" aria-hidden="true"></i></button>');

    toggleSidebarBtn.click(function(){
      $(".sidebar").toggle();
    });

    sidebarContent.prepend(toggleSidebarBtn)
  }
}());
