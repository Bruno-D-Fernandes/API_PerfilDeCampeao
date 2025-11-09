const BEARER = 'Bearer 2|GVu44dtOoByXjcPzmA94RL9dg9RwG7HScU4MSG4y4929a7ee';
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const container = document.querySelector('.container');

let oportunidadeId = -1;
let readOnly = true;

const storageUrl = container.dataset.storageUrl;

const modalBackdrop = document.querySelector('.modal-backdrop');

const modais = {
    'oportunidade-modal': {
        content: document.querySelector('#oportunidade-modal'),
        inputs: [
            document.querySelector('#oportunidade-form-descricao'),
            document.querySelector('#oportunidade-form-data'),
            document.querySelector('#oportunidade-form-esporte'),
            document.querySelector('#oportunidade-form-posicao'),
            document.querySelector('#oportunidade-form-idade-minima'),
            document.querySelector('#oportunidade-form-idade-maxima'),
            document.querySelector('#oportunidade-form-endereco'),
            document.querySelector('#oportunidade-form-cidade'),
            document.querySelector('#oportunidade-form-estado'),
            document.querySelector('#oportunidade-form-cep'),
        ],
        type: 1,
    }, 
    'adicionar-membro-modal': {
        content: document.querySelector('#adicionar-membro-modal'),
        inputs: [
            document.querySelector('#user-search-input'),
            document.querySelector('#adicionar-membro-form-esporte'),
            document.querySelector('#adicionar-membro-form-funcao'),
        ],
        type: 1,
    },
    'confirmar-modal': {
        content: document.querySelector('#confirmar-modal'),
        type: 3,
    },
    'inscritos-modal': {
        content: document.querySelector('#inscritos-modal'),
        type: 2,
    },
    'clube-modal': {
        content: document.querySelector('#clube-modal'),
        inputs: [
            document.querySelector('#clube-form-nome'),
            document.querySelector('#clube-form-data'),
            document.querySelector('#clube-form-endereco'),
            document.querySelector('#clube-form-cidade'),
            document.querySelector('#clube-form-estado'),
            document.querySelector('#clube-form-bio'),
            document.querySelector('#clube-form-categoria'),
            document.querySelector('#clube-form-esporte'),
            document.querySelector('#clube-form-foto'),
            document.querySelector('#clube-form-banner')
        ],
        type: 1,
    },
}

const modalAdicionarMembro = modais['adicionar-membro-modal'];
const modalOportunidade = modais['oportunidade-modal'];
const modalConfirmar = modais['confirmar-modal'];
const modalInscritos = modais['inscritos-modal'];
const modalClube = modais['clube-modal'];

const oportunidadeModalTitle = modalOportunidade.content.querySelector('.modal-title');
const confirmarModalTitle = modalConfirmar.content.querySelector('.modal-title');

const confirmarModalAlert = modalConfirmar.content.querySelector('.modal-alert');

const tabBtns = document.querySelectorAll('.tabs button');

const closeModalBtns = document.querySelectorAll('.close-modal-btn');

const seeDetailsBtns = document.querySelectorAll('.see-details-btn');

const opportunityOptions = document.querySelectorAll('.opportunity-options');

const oportunidades = document.querySelector('#opportunities');

const addOportunidadeBtn = document.querySelector('#oportunidade-add-btn');

const salvarOportunidadeBtn = document.querySelector('#oportunidade-salvar-btn');
const cancelarOportunidadeBtn = document.querySelector('#oportunidade-cancelar-btn');

const membersDataContainer = document.querySelector('.members-list-group');

const searchInput = document.querySelector('#member-search-input');
const clubeId = container.dataset.clubeId;

const clearSearchBtns = document.querySelectorAll('.clear-search-btn');

const searchUserInput = document.querySelector('#user-search-input');
const searchUserContainer = document.querySelector('.search-user-container');

const addMembroBtn = document.querySelector('#add-member-btn');

const userNeededInfo = document.querySelectorAll('.user-needed');

const salvarMembroBtn = document.querySelector('#adicionar-membro-salvar-btn');
const cancelarMembroBtn = document.querySelector('#adicionar-membro-cancelar-btn');

const clubeEditarBtn = document.querySelector('#clube-editar-btn');

const salvarClubeBtn = document.querySelector('#clube-salvar-btn');
const cancelarClubeBtn = document.querySelector('#clube-cancelar-btn');

const previewImagem = modalClube.content.querySelector('.foto-preview');
const previewImagemBanner = modalClube.content.querySelector('.banner-preview');
const inputImagem = modalClube.content.querySelector('#clube-form-foto');
const inputImagemBanner = modalClube.content.querySelector('#clube-form-banner');

let esportesData = null;

const oportunidadeEsporteSelect = document.querySelector('#oportunidade-form-esporte');