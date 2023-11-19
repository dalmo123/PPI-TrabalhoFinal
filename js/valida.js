const deleteButtons = document.querySelectorAll('.btn-danger');
const acceptButtons = document.querySelectorAll('.btn-success');


document.addEventListener('DOMContentLoaded', function () {

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
        let footer = document.querySelector('footer');

        if(count==0){
            footer.style.position = "fixed"
        }else{
            footer.style.position = "relative"
        }
    }
});
