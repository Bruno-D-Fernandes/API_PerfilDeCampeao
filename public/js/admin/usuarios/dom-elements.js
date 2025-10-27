const BEARER = '4|0C5uK0x5dgj7Kq2duezc1n2nqOeUFVZpMszzH7ym6a42ef00';
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const usuarios = document.querySelector('.usuarios');

let usuarioId = -1;

let readOnly = true;

const modalBackdrop = document.querySelector('.modal-backdrop');

const modais = {
    'usuario-modal': {
        content: document.querySelector('#usuario-modal'),
        inputs: [
            document.querySelector('#usuario-form-nome'),
            document.querySelector('#usuario-form-email'),
            document.querySelector('#usuario-form-genero'),
            document.querySelector('#usuario-form-data'),
            document.querySelector('#usuario-form-cidade'),
            document.querySelector('#usuario-form-estado'),
            document.querySelector('#usuario-form-altura'),
            document.querySelector('#usuario-form-peso'),
            document.querySelector('#usuario-form-pe'),
            document.querySelector('#usuario-form-mao'),
            document.querySelector('#usuario-form-foto'),
            document.querySelector('#usuario-form-banner'),
        ],
        type: 1,
    },
    'confirmar-modal': {
        content: document.querySelector('#confirmar-modal'),
        type: 3,
    },
}

const modalUsuario = modais['usuario-modal'];
const modalConfirmar = modais['confirmar-modal'];

const usuarioModalTitle = modalUsuario.content.querySelector('.modal-title');
const confirmarModalTitle = modalConfirmar.content.querySelector('.modal-title');

const confirmarModalAlert = modalConfirmar.content.querySelector('.modal-alert');

const addUsuarioBtn = document.querySelector('#usuario-add-btn');

const salvarUsuarioBtn = document.querySelector('#usuario-salvar-btn');
const cancelarUsuarioBtn = document.querySelector('#usuario-cancelar-btn');

const closeModalBtns = document.querySelectorAll('.close-modal-btn');

const inputImagemBanner = document.querySelector('#usuario-form-banner');
const previewImagemBanner = document.querySelector('.banner-preview');

const inputImagem = document.querySelector('#usuario-form-foto');
const previewImagem = document.querySelector('.foto-preview');