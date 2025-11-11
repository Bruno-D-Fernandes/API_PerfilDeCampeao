const BEARER = '1|PgHMjEkYTPAxwTPzAMxjy23uFmCkdD8eWgsXXrNj187a5d3a';
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const listasContainer = document.querySelector('.listas');
const storageUrl = listasContainer.dataset.storageUrl;

let listaId = -1;

const modalBackdrop = document.querySelector('.modal-backdrop');

const modais = {
    'lista-modal': {
        content: document.querySelector('#lista-modal'),
        inputs: [],
        type: 1,
    },
    'confirmar-modal': {
        content: document.querySelector('#confirmar-modal'),
        inputs: [],
        type: 3,
    },
}

const modalLista = modais['lista-modal'];
const modalConfirmar = modais['confirmar-modal'];

const listaModalTitle = modalLista.content.querySelector('.modal-title');

const spanModalListaNome = modalLista.content.querySelector('h3');
const spanModalListaClube = modalLista.content.querySelector('span:nth-of-type(1)');
const spanModalListaDescricao = modalLista.content.querySelector('span:nth-of-type(2)');
const spanModalListaUserCount = modalLista.content.querySelector('.users-list span');
const usersListContainer = modalLista.content.querySelector('.users-list-container');

const confirmarModalTitle = modalConfirmar.content.querySelector('.modal-title');
const confirmarModalAlert = modalConfirmar.content.querySelector('.modal-alert');
const salvarConfirmarBtn = document.querySelector('#save-confirm-btn');
const cancelarConfirmarBtn = document.querySelector('#cancel-confirm-btn');

const closeModalBtns = document.querySelectorAll('.close-modal-btn');