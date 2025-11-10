const BEARER = '2|uWQtFbYcxrIEr7KC9H5FNAUbbN9mhA5jfUtDRXfz88f7a9d8';
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const container = document.querySelector('.profile-container');
const usuarioId = container.dataset.usuarioId;
const storageUrl = container.dataset.storageUrl;

const modalBackdrop = document.querySelector('.modal-backdrop');
const modalBackdropSecond = document.querySelector('.modal-backdrop.second'); 

const modais = {
    'listas-modal': {
        content: document.querySelector('#listas-modal'),
        inputs: [], 
        type: 1,
    },
    'criar-lista-modal': {
        content: document.querySelector('#criar-lista-modal'),
        inputs: [
            document.querySelector('#criar-lista-form-nome'),
            document.querySelector('#criar-lista-form-descricao')
        ],
        type: 2,
    },
}

const modalListas = modais['listas-modal'];
const modalCriarLista = modais['criar-lista-modal'];

const listasModalTitle = modalListas.content.querySelector('.modal-title');
const criarListaModalTitle = modalCriarLista.content.querySelector('.modal-title');

const listasContainer = modalListas.content.querySelector('#listas-view'); 

const abrirListasBtn = document.querySelector('#add-to-list-btn'); 

const addListaBtn = modalListas.content.querySelector('#add-lista-btn'); 

const criarListaSalvarBtn = modalCriarLista.content.querySelector('#criar-lista-salvar-btn');
const criarListaCancelarBtn = modalCriarLista.content.querySelector('#criar-lista-cancelar-btn');

const closeModalBtns = document.querySelectorAll('.close-modal-btn');

const mainTabs = document.querySelector('.profile-tabs'); 
const mainTabBtns = mainTabs.querySelectorAll('.tab-btn');

const mainTabContents = document.querySelectorAll('.tab-content');
const subTabBtns = document.querySelectorAll('.sub-tab-btn');
const subTabContents = document.querySelectorAll('.sub-tab-content');