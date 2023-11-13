const campo_tipo = document.querySelector("#select");
const lb_select = document.querySelector("#lb-select");

campo_tipo.addEventListener('change', 
function(event) {
    if(campo_tipo.value==''){
        lb_select.style.display = "block";
    }else{
        lb_select.style.display = "none";
    }
    event.preventDefault();
});
