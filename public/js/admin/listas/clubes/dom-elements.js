const BEARER = '3|iA9K9nhso0buphu3Qa2dpWLQTXeNv9lpwPnyBV7l8e675c82';
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const clubes = document.querySelector('.clubes');

const storageUrl = clubes.dataset.storageUrl;

let clubeId = -1;

let readOnly = true;

const modalBackdrop = document.querySelector('.modal-backdrop');

const modais = {
    'clube-modal': {
        content: document.querySelector('#clube-modal'),
        inputs: [
            document.querySelector('#clube-form-nome'),
            document.querySelector('#clube-form-email'),
            document.querySelector('#clube-form-cnpj'),
            document.querySelector('#clube-form-data'),
            document.querySelector('#clube-form-endereco'),
            document.querySelector('#clube-form-cidade'),
            document.querySelector('#clube-form-estado'),
            document.querySelector('#clube-form-bio'),
            document.querySelector('#clube-form-categoria'),
            document.querySelector('#clube-form-esporte'),
            document.querySelector('#clube-form-foto'),
            document.querySelector('#clube-form-banner'),
        ],
        type: 1,
    },
    'confirmar-modal': {
        content: document.querySelector('#confirmar-modal'),
        type: 3,
    },
}

const modalClube = modais['clube-modal'];
const modalConfirmar = modais['confirmar-modal'];

const clubeModalTitle = modalClube.content.querySelector('.modal-title');
const confirmarModalTitle = modalConfirmar.content.querySelector('.modal-title');

const confirmarModalAlert = modalConfirmar.content.querySelector('.modal-alert');

const addClubeBtn = document.querySelector('#clube-add-btn');

const salvarClubeBtn = document.querySelector('#clube-salvar-btn');
const cancelarClubeBtn = document.querySelector('#clube-cancelar-btn');

const closeModalBtns = document.querySelectorAll('.close-modal-btn');

const inputImagemBanner = document.querySelector('#clube-form-banner');
const previewImagemBanner = document.querySelector('.banner-preview');

const inputImagem = document.querySelector('#clube-form-foto');
const previewImagem = document.querySelector('.foto-preview');