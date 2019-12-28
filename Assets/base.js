(function() {
  // Close dropdown on second click
  $(document).on('click', '.dropdown-menu', function(e) {
    if (document.getElementById('dropdown') !== null) {
      e.preventDefault();
      e.stopImmediatePropagation();

      KB.trigger('dropdown.beforeDestroy');
      $("#dropdown").remove();
    }
  });

  // Close modal on overlay click
  KB.onClick('#modal-overlay', function() {
    KB.modal.close();
  });
}());
