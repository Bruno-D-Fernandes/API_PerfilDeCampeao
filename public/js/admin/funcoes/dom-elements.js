const BEARER = '1|PgHMjEkYTPAxwTPzAMxjy23uFmCkdD8eWgsXXrNj187a5d3a';
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const funcoes = document.querySelector('.funcoes');

let funcaoId = -1;

let readOnly = true;

const modalBackdrop = document.querySelector('.modal-backdrop');

const modais = {
    'funcao-modal': {
        content: document.querySelector('#funcao-modal'),
        inputs: [
            document.querySelector('#funcao-form-nome'),
            document.querySelector('#funcao-form-descricao'),
        ],
        type: 1,
    },
    'confirmar-modal': {
        content: document.querySelector('#confirmar-modal'),
        type: 3,
    },
}

const modalFuncao = modais['funcao-modal'];
const modalConfirmar = modais['confirmar-modal'];

const funcaoModalTitle = modalFuncao.content.querySelector('.modal-title');
const confirmarModalTitle = modalConfirmar.content.querySelector('.modal-title');

const confirmarModalAlert = modalConfirmar.content.querySelector('.modal-alert');

const addFuncaoBtn = document.querySelector('#funcao-add-btn');

const salvarFuncaoBtn = document.querySelector('#funcao-salvar-btn');
const cancelarFuncaoBtn = document.querySelector('#funcao-cancelar-btn');

const closeModalBtns = document.querySelectorAll('.close-modal-btn');