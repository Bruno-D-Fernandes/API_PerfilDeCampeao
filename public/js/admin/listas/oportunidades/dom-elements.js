const BEARER = localStorage.getItem('adm_token');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const oportunidadesContainer = document.querySelector('.oportunidades');

let oportunidadeId = -1

const modalBackdrop = document.querySelector('.modal-backdrop');

const modais = {
    'oportunidade-modal': {
        content: document.querySelector('#oportunidade-modal'),
        inputs: [], 
        type: 1,
    },
    'status-modal': {
        content: document.querySelector('#status-modal'),
        inputs: [
            document.querySelector('#rejeicao-status')
        ],
        type: 1,
    },
    'confirmar-modal': {
        content: document.querySelector('#confirmar-modal'),
        type: 3,
    },
}

const modalOportunidade = modais['oportunidade-modal'];
const modalStatus = modais['status-modal'];
const modalConfirmar = modais['confirmar-modal'];

const oportunidadeModalTitle = modalOportunidade.content.querySelector('.modal-title');

const tabButtons = modalOportunidade.content.querySelectorAll('.tab-button');
const tabDetalhes = modalOportunidade.content.querySelector('#detalhes-tab');
const tabInscritos = modalOportunidade.content.querySelector('#inscritos-tab');

const inscritosListContainer = modalOportunidade.content.querySelector('.inscritos-list-container');

const spanDataPostagem = modalOportunidade.content.querySelector('.detalhe-group:nth-child(1) span');
const spanDescricao = modalOportunidade.content.querySelector('.detalhe-group:nth-child(2) span');
const spanRequisitos = modalOportunidade.content.querySelector('.detalhe-group:nth-child(3) span');
const spanLocalizacao = modalOportunidade.content.querySelector('.detalhe-group:nth-child(4) span');
const spanContexto = modalOportunidade.content.querySelector('.detalhe-group:nth-child(5) span');

const statusModalTitle = modalStatus.content.querySelector('.modal-title');
const salvarStatusBtn = document.querySelector('#save-status-btn');
const cancelarStatusBtn = document.querySelector('#cancel-status-btn');

const confirmarModalTitle = modalConfirmar.content.querySelector('.modal-title');
const confirmarModalAlert = modalConfirmar.content.querySelector('.modal-alert');

const closeModalBtns = document.querySelectorAll('.close-modal-btn');