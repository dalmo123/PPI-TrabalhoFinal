const campo_tipo = document.querySelector("#select");
const tel = document.querySelector("#tel");
const site = document.querySelector("#site");
const lb_tel = document.querySelector("#lb-tel");
const lb_site = document.querySelector("#lb-site");
const lb_select = document.querySelector("#lb-select");

campo_tipo.addEventListener('change', 
function(event) {
    if(campo_tipo.value==''){
        lb_select.style.display = "block";
    }else{
        lb_select.style.display = "none";
    }

    if(campo_tipo.value=='ONG'){
        lb_tel.style.display = "block";
        lb_site.style.display = "block";
        site.style.display = "block";
        tel.style.display = "block";
    }else{
        lb_tel.style.display = "none";
        lb_site.style.display = "none";
        site.style.display = "none";
        tel.style.display = "none";
    }
    event.preventDefault();
});
