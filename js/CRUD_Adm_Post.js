const deleteButtons = document.querySelectorAll('.btn-danger');
const acceptButtons = document.querySelectorAll('.btn-success');


document.addEventListener('DOMContentLoaded', function () {
    // Obtém a data atual
    var dataAtual = new Date();

    // Adiciona dois dias à data atual
    dataAtual.setDate(dataAtual.getDate() + 2);

    // Formata a data mínima no formato YYYY-MM-DD
    var minDate = dataAtual.toISOString().split('T')[0];

    // Define a data mínima no campo de data
    document.getElementById('floatingInput3').setAttribute('min', minDate);

    const searchBar = document.getElementById('search');
    searchBar.addEventListener('input', function () {
        filterTable(searchBar.value.toLowerCase());
    });

    function filterTable(searchText) {
        const rows = document.querySelectorAll('.accordion-item');
        let count = parseInt(0);

        rows.forEach(function (row) {
            const name = row.querySelector('.name').textContent.toLowerCase();
            if (name.includes(searchText)) {
                row.style.display = 'block';
            } else {
                row.style.display = 'none';
            }
        });

        rows.forEach(function (row) {
            if(row.style.display=="block"){
                count++;
            }
        });
        console.log(count);
        let footer = document.querySelector('footer');

        if(count==0){
            footer.style.position = "fixed"
        }else{
            footer.style.position = "relative"
        }
    }
});


