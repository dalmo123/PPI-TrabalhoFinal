const campo_tipo = document.querySelector("#select");
const lb_select = document.querySelector("#lb-select");

campo_tipo.addEventListener('change', 
function(event) {
    if(campo_tipo.value==''){
        lb_select.style.display = "block";
    }else{
        lb_select.style.display = "none";
    }
});


document.addEventListener('DOMContentLoaded', function () {
    // Obtém a data atual
    var dataAtual = new Date();

    // Adiciona dois dias à data atual
    dataAtual.setDate(dataAtual.getDate() + 2);

    // Formata a data mínima no formato YYYY-MM-DD
    var minDate = dataAtual.toISOString().split('T')[0];

    // Define a data mínima no campo de data
    document.getElementById('floatingInput3').setAttribute('min', minDate);
});