const BEARER = localStorage.getItem('adm_token');
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const perfilContainer = document.querySelector('.perfil');
const storageUrl = perfilContainer.dataset.storageUrl;
const adminId = perfilContainer.dataset.adminId;

const displayNome = document.querySelector('.admin .nome');
const displayFotoContainer = document.querySelector('.profile-picture');
const displayEmail = document.querySelector('.personal-info-group.email span');
const displayTelefone = document.querySelector('.personal-info-group.telefone span');
const displayEndereco = document.querySelector('.personal-info-group.endereco span');
const displayData = document.querySelector('.personal-info-group.data span');

const modalBackdrop = document.querySelector('.modal-backdrop');

const modais = {
    'perfil-modal': {
        content: document.querySelector('#perfil-modal'),
        inputs: [
            document.querySelector('#perfil-form-nome'),
            document.querySelector('#perfil-form-foto')
        ],
        type: 1,
    },
    'informacoes-modal': {
        content: document.querySelector('#informacoes-modal'),
        inputs: [
            document.querySelector('#informacoes-form-email'),
            document.querySelector('#informacoes-form-telefone'),
            document.querySelector('#informacoes-form-endereco'),
            document.querySelector('#informacoes-form-data')
        ],
        type: 1,
    },
    'confirmar-modal': {
        content: document.querySelector('#confirmar-modal'),
        type: 3,
    },
}

const modalPerfil = modais['perfil-modal'];
const modalInformacoes = modais['informacoes-modal'];
const modalConfirmar = modais['confirmar-modal'];

const perfilModalTitle = modalPerfil.content.querySelector('.modal-title');
const informacoesModalTitle = modalInformacoes.content.querySelector('.modal-title');
const confirmarModalTitle = modalConfirmar.content.querySelector('.modal-title');

const confirmarModalAlert = modalConfirmar.content.querySelector('.modal-alert');

const editarPerfilBtn = document.querySelector('#editar-perfil-btn');
const editarInformacoesBtn = document.querySelector('#editar-informacoes-btn');

const perfilSalvarBtn = document.querySelector('#perfil-salvar-btn');
const perfilCancelarBtn = document.querySelector('#perfil-cancelar-btn');

const informacoesSalvarBtn = document.querySelector('#informacoes-salvar-btn');
const informacoesCancelarBtn = document.querySelector('#informacoes-cancelar-btn');

const confirmarSalvarBtn = document.querySelector('#save-confirm-btn');
const confirmarCancelarBtn = document.querySelector('#cancel-confirm-btn');

const closeModalBtns = document.querySelectorAll('.close-modal-btn');

const inputFoto = document.querySelector('#perfil-form-foto');
const previewFoto = document.querySelector('#perfil-modal .foto-preview');