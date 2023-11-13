document.addEventListener('DOMContentLoaded', function () {
    const searchBar = document.getElementById("search");
    searchBar.addEventListener('input', function () {
        filterTable(searchBar.value.toLowerCase());
    });

    function filterTable(searchText) {
        const table = document.getElementById("table");
        const rows = table.querySelectorAll('tbody tr');
        let count = parseInt(0);
        
        rows.forEach(function (row) {
            const name = row.getElementsByTagName('td')[1].textContent.toLowerCase();
            if (name.includes(searchText)) {
                row.style.display = 'table-row';
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

