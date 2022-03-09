$(document).ready(function() {
    $("button[id^='puntos']").click(function() {
      // if (userId === "") {
      //     window.location.replace(`${base_url}/Login`);
      //     return false;
      // }

      // if ($(this).attr("id") == "puntosMas") { }
      // if ($(this).attr("id") == "puntosMenos") { }
      $this = $(this);
      $this.myprocess(function (data) {
        console.log(data);
      });

      // return false;
  });

  
   $("a#eliminar").click(function () {
     $this = $(this);
     $.bsAlert.confirm("¿Desea eliminar el registro?", function () {
       $this.myprocess(function () {
         $this.closest("#Noticia").fadeOut();
       });
     });
     return false;
  });
});
