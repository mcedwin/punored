$(document).ready(function () {
    $("#form_registrar").submit(function () {
      $(this).mysave((data) => (document.location = data.redirect));
      return false;
    });
  });
  