
    // Obtenha todos os botões "Excluir Perfil"
    const deleteButtons = document.querySelectorAll('.btn-danger');
    const count = 0;

    // Adicione um ouvinte de eventos de clique a cada botão "Excluir Perfil"
    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Abra o modal de confirmação pelo ID
            const confirmModal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
            confirmModal.show();

            // Adicione um ouvinte de eventos para o botão "Excluir" no modal
            const confirmDeleteButton = document.getElementById('confirmDelete');
            confirmDeleteButton.addEventListener('click', () => {
                // Encontre o elemento "accordion-item" pai do botão clicado
                const accordionItem = button.closest('.accordion-item');

                // Verifique se o elemento "accordion-item" foi encontrado
                if (accordionItem) {
                    // Remova o elemento "accordion-item" da tela

                    accordionItem.remove();
                    let tam = document.querySelectorAll('.accordion-item');
                    let footer = document.querySelector('footer');
                    if(tam.length==0){
                        footer.style.position = "fixed";
                    }else{
                        footer.style.position = "relative";
                    }

                }

                // Feche o modal de confirmação
                confirmModal.hide();
                alert('Perfil deletado com sucesso!');
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
    
