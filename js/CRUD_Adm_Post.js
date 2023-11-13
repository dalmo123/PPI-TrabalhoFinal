const deleteButtons = document.querySelectorAll('.btn-danger');
const acceptButtons = document.querySelectorAll('.btn-success');

deleteButtons.forEach(button => {
    button.addEventListener('click', () => {
        const confirmModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
        confirmModal.show();

        const confirmDeleteButton = document.getElementById('confirmDelete');
        confirmDeleteButton.addEventListener('click', () => {
            const tableRow = button.closest('tr');

            if (tableRow) {
                tableRow.remove();
            }

            confirmModal.hide();
            alert('Postagem deletada com sucesso!');
        });
    });
});

acceptButtons.forEach(button => {
    button.addEventListener('click', () => {
        const confirmAcceptModal = new bootstrap.Modal(document.getElementById('confirmAcceptModal'));
        confirmAcceptModal.show();

        const confirmAcceptButton = document.getElementById('confirmAccept');
        confirmAcceptButton.addEventListener('click', () => {
            const tableRow = button.closest('tr');

            if (tableRow) {
                tableRow.remove();
            }

            confirmAcceptModal.hide();
            alert('Postagem publicada com sucesso!');
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
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
