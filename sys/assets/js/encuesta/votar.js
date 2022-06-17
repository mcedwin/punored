const options = document.querySelectorAll("label");
for (let i = 0; i < options.length; i++) {
    options[i].addEventListener("click", () => {
        for (let j = 0; j < options.length; j++) {
            options[j].classList.remove("selected");
        }

        options[i].classList.add("selected");
        for (let k = 0; k < options.length; k++) {
            options[k].classList.add("selectall");
        }

        let forVal = options[i].getAttribute("for");
        let selectInput = document.querySelector("#" + forVal);
        let getAtt = selectInput.getAttribute("type");
    });
}

const urlVotar = base_url + '/Encuestas/voto';
$("section#encuesta label[for^='opt-']").click(function() {
    $encuesta = $(this).closest('#encuesta');
    $btnVotar = $encuesta.find("#votar");
    $btnVotar.attr("href", urlVotar + "/" + $(this).data("id"));
})

$("#votar").click(function() {
    $this = $(this);
    if ($this.attr('href') == '') return false;
    $this.myprocess(function (data) {
        console.log(data);
        location.reload()
    })
    return false;
})
