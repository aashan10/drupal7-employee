(function ($) {
  $(document).ready(function(){
    let deleteButtons = document.getElementsByClassName('delete-employee');
    for (let i = 0; i < deleteButtons.length; i++) {
      deleteButtons[i].addEventListener('click', function (event) {
        let url = event.target.getAttribute('data-href');
        let confirmation = confirm('Are you sure you want to delete this employee?');
        if (confirmation) {
          window.location.href = url;
        }
      });
    }
  });
})(jQuery);
