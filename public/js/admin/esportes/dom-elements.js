const BEARER = '1|PgHMjEkYTPAxwTPzAMxjy23uFmCkdD8eWgsXXrNj187a5d3a';
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const esportes = document.querySelector('.esportes');

let esporteId = -1;
let posicaoId = -1;
let caracteristicaId = -1;

let readOnly = true;

const modalBackdrop = document.querySelector('.modal-backdrop');
const modalBackdropSecond = document.querySelector('.modal-backdrop.second');

const modais = {
    'esporte-modal': {
        content: document.querySelector('#esporte-modal'),
        inputs: [
            document.querySelector('#esporte-form-nome'),
            document.querySelector('#esporte-form-descricao'),
        ],
        type: 1,
    },
    'posicao-modal': {
        content: document.querySelector('#posicao-modal'),
        inputs: [
            document.querySelector('#posicao-form-nome'),
        ],
        type: 2,
    },
    'caracteristica-modal': {
        content: document.querySelector('#caracteristica-modal'),
        inputs: [
            document.querySelector('#caracteristica-form-caracteristica'),
            document.querySelector('#caracteristica-form-unidade'),
        ],
        type: 2,
    },
    'confirmar-modal': {
        content: document.querySelector('#confirmar-modal'),
        type: 3,
    },
}

const modalEsporte = modais['esporte-modal'];
const modalPosicao = modais['posicao-modal'];
const modalCaracteristica = modais['caracteristica-modal'];
const modalConfirmar = modais['confirmar-modal'];

const esporteModalTitle = modalEsporte.content.querySelector('.modal-title');
const posicaoModalTitle = modalPosicao.content.querySelector('.modal-title');
const caracteristicaModalTitle = modalCaracteristica.content.querySelector('.modal-title');
const confirmarModalTitle = modalConfirmar.content.querySelector('.modal-title');

const posicoesListContainer = modalEsporte.content.querySelector('.posicoes-list-container');
const caracteristicasListContainer = modalEsporte.content.querySelector('.caracteristicas-list-container');

const confirmarModalAlert = modalConfirmar.content.querySelector('.modal-alert');

const addEsporteBtn = document.querySelector('#esporte-add-btn');
const addPosicaoBtn = document.querySelector('#posicao-add-btn');
const addCaracteristicaBtn = document.querySelector('#caracteristica-add-btn');

const salvarEsporteBtn = document.querySelector('#esporte-salvar-btn');
const cancelarEsporteBtn = document.querySelector('#esporte-cancelar-btn');

const salvarPosicaoBtn = document.querySelector('#posicao-salvar-btn');
const cancelarPosicaoBtn = document.querySelector('#posicao-cancelar-btn');

const salvarCaracteristicaBtn = document.querySelector('#caracteristica-salvar-btn');
const cancelarCaracteristicaBtn = document.querySelector('#caracteristica-cancelar-btn');

const closeModalBtns = document.querySelectorAll('.close-modal-btn');

const modalTabs = document.querySelector('.modal-tabs');
const tabBtns = modalTabs.querySelectorAll('.tab-button');