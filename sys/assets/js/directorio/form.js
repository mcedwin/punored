$(document).ready(function () {
  $("#form").submit(function () {
    $(this).mysave((data) => (document.location = data.redirect));
    return false;
  });
});
