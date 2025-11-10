function createListaRow(lista) {
    const div = document.createElement('div');

    div.className = "lista-item"; 
    div.dataset.listaId = lista.id;

    div.innerHTML = `
        <input type="checkbox" id="lista-${lista.id}" name="listas_usuario[]" value="${lista.id}">
        <label for="lista-${lista.id}">${lista.nome}</label> 
    `;
    
    return div;
}