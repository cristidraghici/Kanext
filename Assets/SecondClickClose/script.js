(function() {
  $(document).on('click', '.dropdown-menu', function(e) {
    if (document.getElementById('dropdown') !== null) {
      e.preventDefault();
      e.stopImmediatePropagation();

      KB.trigger('dropdown.beforeDestroy');
      $("#dropdown").remove();
    }
  });
}());
