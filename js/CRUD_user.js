const deleteButtons = document.querySelectorAll('.btn-danger');

deleteButtons.forEach(button => {
    button.addEventListener('click', () => {
        const confirmModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
        confirmModal.show();

        const confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', () => {
            // Encontre a linha da tabela pai do botão clicado
            const tableRow = button.closest('tr');

            if (tableRow) {
                // Remove a linha da tabela
                tableRow.remove();
            }

            confirmModal.hide();
            alert('Postagem deletada com sucesso!');
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const searchBar = document.getElementById("search");
    searchBar.addEventListener('input', function () {
        filterTable(searchBar.value.toLowerCase());
    });

    function filterTable(searchText) {
        const table = document.getElementById("table");
        const table1 = document.getElementById("table1");
        const rows = table.querySelectorAll('tbody tr');
        const rows1 = table1.querySelectorAll('tbody tr');
        
        rows.forEach(function (row) {
            const name = row.getElementsByTagName('td')[0].textContent.toLowerCase();
            if (name.includes(searchText)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });

        rows1.forEach(function (row) {
            const name = row.getElementsByTagName('td')[0].textContent.toLowerCase();
            if (name.includes(searchText)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    }
});



