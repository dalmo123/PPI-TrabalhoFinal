
        const campo_tipo = document.querySelector("#unidade_medida");
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
    const searchBar = document.getElementById("search");
    searchBar.addEventListener('input', function () {
        filterTable(searchBar.value.toLowerCase());
    });

    // Obtém a data atual
    var dataAtual = new Date();

    // Adiciona dois dias à data atual
    dataAtual.setDate(dataAtual.getDate() + 2);

    // Formata a data mínima no formato YYYY-MM-DD
    var minDate = dataAtual.toISOString().split('T')[0];

    // Define a data mínima no campo de data
    document.getElementById('data_validade').setAttribute('min', minDate);


    function filterTable(searchText) {
        const table = document.querySelectorAll(".table");
        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(function (row) {
            const name = row.getElementsByTagName('td')[0].textContent.toLowerCase();
            if (name.includes(searchText)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    }
});