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