<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cadastro de Clube - Formulário Unificado</title>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/cadastro.css') }}">
</head>
<body>
    <div class="site-container">
        <div class="main-content-wrapper">
            
            <!-- Barra de Progresso Melhorada -->
            <div class="progress-section">
                <div class="progress-steps">
                    <div class="step-indicator active" data-step="1">
                        <div class="step-circle">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="step-label">Informações Básicas</span>
                    </div>
                    <div class="step-indicator" data-step="2">
                        <div class="step-circle">
                            <i class="fas fa-building"></i>
                        </div>
                        <span class="step-label">Dados Institucionais</span>
                    </div>
                    <div class="step-indicator" data-step="3">
                        <div class="step-circle">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <span class="step-label">Administrador</span>
                    </div>
                </div>
                
                <div class="progress-bar-container">
                    <div class="progress-bar-fill" id="progressBar">
                        <div class="runner-icon">
                            <i class="fas fa-person-running"></i>
                        </div>
                    </div>
                    <span class="progress-percentage" id="progressPercentage">33%</span>
                </div>
            </div>

            <!-- Formulário Unificado -->
            <div class="form-section">
                <div class="header-button">
                    <button class="clube-btn">
                        <i class="fas fa-trophy"></i>
                        Cadastro de Clube
                    </button>
                </div>

                <form id="cadastroUnificado">
                    
                    <!-- PASSO 1: Informações Básicas -->
                    <div class="form-step active" id="step1">
                        <div class="step-header">
                            <h2><i class="fas fa-users"></i> Informações Básicas do Clube</h2>
                            <p>Conte-nos sobre seu clube esportivo</p>
                        </div>

                        <div class="form-group">
                            <label for="nomeClube">Nome do Clube *</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-users icon"></i>
                                <input type="text" id="nomeClube" name="nomeClube" required>
                            </div>
                            <span class="error-message" id="nomeClubeError"></span>
                        </div>

                        <div class="form-row">
                            <div class="form-group half-width">
                                <label for="anoCriacaoClube">Ano de criação *</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-calendar-alt icon"></i>
                                    <input type="date" id="anoCriacaoClube" name="anoCriacaoClube" required>
                                </div>
                                <span class="error-message" id="anoCriacaoClubeError"></span>
                            </div>
                            <div class="form-group half-width">
                                <label for="interesseClube">Interesse *</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-star icon"></i>
                                    <select id="interesseClube" name="interesseClube" required>
                                        <option value="" disabled selected hidden>Selecione o interesse</option>
                                        <option value="Recrutamento">Recrutamento</option>
                                        <option value="Competição">Competição</option>
                                        <option value="Lazer">Lazer</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                                <span class="error-message" id="interesseClubeError"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="esporteClube">Esporte *</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-trophy icon"></i>
                                <select id="esporteClube" name="esporteClube" required>
                                    <option value="" disabled selected hidden>Selecione um esporte</option>
                                    <option value="Futebol">Futebol</option>
                                    <option value="Vôlei">Vôlei</option>
                                    <option value="Basquete">Basquete</option>
                                    <option value="Tênis">Tênis</option>
                                    <option value="Natação">Natação</option>
                                    <option value="Atletismo">Atletismo</option>
                                </select>
                                <i class="fas fa-chevron-down select-arrow"></i>
                            </div>
                            <span class="error-message" id="esporteClubeError"></span>
                        </div>

                        <div class="form-row">
                            <div class="form-group half-width">
                                <label for="estadoClube">Estado *</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-map-marker-alt icon"></i>
                                    <select id="estadoClube" name="estadoClube" required>
                                        <option value="" disabled selected hidden>Selecione o estado</option>
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                                <span class="error-message" id="estadoClubeError"></span>
                            </div>
                            <div class="form-group half-width">
                                <label for="cidadeClube">Cidade *</label>
                                <div class="input-icon-wrapper">
                                    <i class="fas fa-building icon"></i>
                                    <input type="text" id="cidadeClube" name="cidadeClube" required>
                                </div>
                                <span class="error-message" id="cidadeClubeError"></span>
                            </div>
                        </div>
                    </div>

                    <!-- PASSO 2: Dados Institucionais -->
                    <div class="form-step" id="step2">
                        <div class="step-header">
                            <h2><i class="fas fa-building"></i> Dados Institucionais</h2>
                            <p>Informações legais e detalhes do clube</p>
                        </div>

                        <div class="form-group">
                            <label for="categoriaClube">Categoria do Clube *</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-layer-group icon"></i>
                                <select id="categoriaClube" name="categoriaClube" required>
                                    <option value="" disabled selected hidden>Selecione a categoria</option>
                                    <option value="Profissional">Profissional</option>
                                    <option value="Semi-profissional">Semi-profissional</option>
                                    <option value="Amador">Amador</option>
                                    <option value="Juvenil">Juvenil</option>
                                    <option value="Infantil">Infantil</option>
                                </select>
                                <i class="fas fa-chevron-down select-arrow"></i>
                            </div>
                            <span class="error-message" id="categoriaClubeError"></span>
                        </div>

                        <div class="form-group">
                            <label for="cnpjClube">CNPJ *</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-file-alt icon"></i>
                                <input type="text" id="cnpjClube" name="cnpjClube" placeholder="00.000.000/0000-00" required maxlength="18">
                                <div class="availability-check" id="cnpjCheck">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <div class="cnpj-format">Formato: XX.XXX.XXX/XXXX-XX</div>
                            <span class="error-message" id="cnpjClubeError"></span>
                            <span class="success-message" id="cnpjClubeSuccess"></span>
                        </div>

                        <div class="form-group">
                            <label for="enderecoClube">Endereço Completo *</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-map-marker-alt icon"></i>
                                <input type="text" id="enderecoClube" name="enderecoClube" placeholder="Rua, número, bairro, CEP" required maxlength="500">
                            </div>
                            <span class="error-message" id="enderecoClubeError"></span>
                        </div>

                        <div class="form-group">
                            <label for="bioClube">Biografia do Clube</label>
                            <div class="textarea-wrapper">
                                <i class="fas fa-align-left icon"></i>
                                <textarea id="bioClube" name="bioClube" placeholder="Conte um pouco sobre a história e objetivos do seu clube..." maxlength="1000"></textarea>
                                <div class="char-counter" id="bioCounter">0/1000</div>
                            </div>
                            <span class="error-message" id="bioClubeError"></span>
                        </div>
                    </div>

                    <!-- PASSO 3: Administrador -->
                    <div class="form-step" id="step3">
                        <div class="step-header">
                            <h2><i class="fas fa-user-shield"></i> Dados do Administrador</h2>
                            <p>Crie sua conta de acesso ao sistema</p>
                        </div>

                        <div class="form-group">
                            <label for="emailAdmin">Email do Administrador *</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-envelope icon"></i>
                                <input type="email" id="emailAdmin" name="emailAdmin" required>
                                <div class="availability-check" id="emailCheck">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <span class="error-message" id="emailAdminError"></span>
                            <span class="success-message" id="emailAdminSuccess"></span>
                        </div>

                        <div class="form-group">
                            <label for="senhaAdmin">Senha *</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-lock icon"></i>
                                <input type="password" id="senhaAdmin" name="senhaAdmin" required minlength="8">
                                <button type="button" class="password-toggle" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <span class="strength-text" id="strengthText">Digite uma senha</span>
                            </div>
                            <span class="error-message" id="senhaAdminError"></span>
                        </div>

                        <div class="form-group">
                            <label for="confirmarSenha">Confirmar Senha *</label>
                            <div class="input-icon-wrapper">
                                <i class="fas fa-lock icon"></i>
                                <input type="password" id="confirmarSenha" name="confirmarSenha" required>
                            </div>
                            <span class="error-message" id="confirmarSenhaError"></span>
                        </div>
                    </div>

                    <!-- Botões de Navegação -->
                    <div class="navigation-buttons">
                        <button type="button" class="prev-btn" id="prevBtn" style="display: none;">
                            <i class="fas fa-chevron-left"></i>
                            Anterior
                        </button>
                        <button type="button" class="next-btn" id="nextBtn">
                            <span class="btn-text">
                                Próximo
                                <i class="fas fa-chevron-right"></i>
                            </span>
                            <div class="btn-spinner"></div>
                        </button>
                        <button type="submit" class="finish-btn" id="finishBtn" style="display: none;">
                            <span class="btn-text">
                                <i class="fas fa-check"></i>
                                Finalizar Cadastro
                            </span>
                            <div class="btn-spinner"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="marketing-section">
            VENHA CONHECER UM MUNDO DE <span class="highlight-blue">OPORTUNIDADES</span>
        </div>
    </div>
dasdasdsadas
    <!-- Notificações -->
    <div class="notification-container" id="notificationContainer"></div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <p>Processando seu cadastro...</p>
        </div>
    </div>

    <script>
        class CadastroUnificado {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 3;
        this.formData = {};
        this.debounceTimers = {};
        this.isSubmitting = false;
        
        this.elements = {
            form: document.getElementById('cadastroUnificado'),
            prevBtn: document.getElementById('prevBtn'),
            nextBtn: document.getElementById('nextBtn'),
            finishBtn: document.getElementById('finishBtn'),
            progressBar: document.getElementById('progressBar'),
            progressPercentage: document.getElementById('progressPercentage'),
            loadingOverlay: document.getElementById('loadingOverlay'),
            notificationContainer: document.getElementById('notificationContainer')
        };
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadSavedData();
        this.updateProgress();
        this.setupPasswordStrength();
        this.setupCharCounter();
    }

    setupEventListeners() {
        // Navegação
        this.elements.nextBtn.addEventListener('click', () => this.nextStep());
        this.elements.prevBtn.addEventListener('click', () => this.prevStep());
        this.elements.finishBtn.addEventListener('click', () => this.submitForm());

        // Validação em tempo real
        this.setupRealTimeValidation();
        
        // Formatação de campos
        this.setupFieldFormatting();
        
        // Toggle de senha
        this.setupPasswordToggle();
        
        // Prevenção de submit padrão
        this.elements.form.addEventListener('submit', (e) => e.preventDefault());
    }

    setupRealTimeValidation() {
        const fields = [
            'nomeClube', 'anoCriacaoClube', 'interesseClube', 'esporteClube', 
            'estadoClube', 'cidadeClube', 'categoriaClube', 'cnpjClube', 
            'enderecoClube', 'emailAdmin', 'senhaAdmin', 'confirmarSenha'
        ];

        fields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.addEventListener('input', () => {
                    this.clearFieldError(fieldId);
                    this.saveFieldData(fieldId, field.value);
                });
                
                field.addEventListener('blur', () => {
                    this.validateField(fieldId);
                });
            }
        });

        // Validações específicas com debounce
        const cnpjField = document.getElementById('cnpjClube');
        if (cnpjField) {
            cnpjField.addEventListener('input', (e) => {
                this.formatCNPJ(e.target);
                this.debounceValidation('cnpj', () => {
                    this.checkCnpjAvailability();
                }, 800);
            });
        }

        const emailField = document.getElementById('emailAdmin');
        if (emailField) {
            emailField.addEventListener('input', () => {
                this.debounceValidation('email', () => {
                    this.checkEmailAvailability();
                }, 600);
            });
        }

        const senhaField = document.getElementById('senhaAdmin');
        if (senhaField) {
            senhaField.addEventListener('input', () => {
                this.updatePasswordStrength();
                this.validatePasswordMatch();
            });
        }

        const confirmarSenhaField = document.getElementById('confirmarSenha');
        if (confirmarSenhaField) {
            confirmarSenhaField.addEventListener('input', () => {
                this.validatePasswordMatch();
            });
        }
    }

    setupFieldFormatting() {
        // Formatação de CNPJ já implementada no setupRealTimeValidation
    }

    setupPasswordToggle() {
        const toggleBtn = document.getElementById('togglePassword');
        const senhaField = document.getElementById('senhaAdmin');
        
        if (toggleBtn && senhaField) {
            toggleBtn.addEventListener('click', () => {
                const type = senhaField.getAttribute('type') === 'password' ? 'text' : 'password';
                senhaField.setAttribute('type', type);
                
                const icon = toggleBtn.querySelector('i');
                icon.className = type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
            });
        }
    }

    setupPasswordStrength() {
        this.strengthFill = document.getElementById('strengthFill');
        this.strengthText = document.getElementById('strengthText');
    }

    setupCharCounter() {
        const bioField = document.getElementById('bioClube');
        const counter = document.getElementById('bioCounter');
        
        if (bioField && counter) {
            bioField.addEventListener('input', () => {
                const length = bioField.value.length;
                const maxLength = 1000;
                
                counter.textContent = `${length}/${maxLength}`;
                
                counter.className = 'char-counter';
                if (length > maxLength * 0.8) {
                    counter.classList.add('warning');
                }
                if (length > maxLength * 0.95) {
                    counter.classList.add('danger');
                }
            });
        }
    }

    // Navegação entre passos
    nextStep() {
        if (this.validateCurrentStep()) {
            if (this.currentStep < this.totalSteps) {
                this.currentStep++;
                this.updateStepDisplay();
                this.updateProgress();
            }
        }
    }

    prevStep() {
        if (this.currentStep > 1) {
            this.currentStep--;
            this.updateStepDisplay();
            this.updateProgress();
        }
    }

    updateStepDisplay() {
        // Esconder todos os passos
        document.querySelectorAll('.form-step').forEach(step => {
            step.classList.remove('active');
        });
        
        // Mostrar passo atual
        document.getElementById(`step${this.currentStep}`).classList.add('active');
        
        // Atualizar indicadores de passo
        document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
            indicator.classList.remove('active', 'completed');
            
            if (index + 1 === this.currentStep) {
                indicator.classList.add('active');
            } else if (index + 1 < this.currentStep) {
                indicator.classList.add('completed');
            }
        });
        
        // Atualizar botões
        this.elements.prevBtn.style.display = this.currentStep > 1 ? 'flex' : 'none';
        this.elements.nextBtn.style.display = this.currentStep < this.totalSteps ? 'flex' : 'none';
        this.elements.finishBtn.style.display = this.currentStep === this.totalSteps ? 'flex' : 'none';
        
        // Scroll para o topo
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    updateProgress() {
        const percentage = Math.round((this.currentStep / this.totalSteps) * 100);
        this.elements.progressBar.style.width = `${percentage}%`;
        this.elements.progressPercentage.textContent = `${percentage}%`;
    }

    // Validação
    validateCurrentStep() {
        const stepFields = this.getStepFields(this.currentStep);
        let isValid = true;

        stepFields.forEach(fieldId => {
            if (!this.validateField(fieldId)) {
                isValid = false;
            }
        });

        if (!isValid) {
            this.showNotification('Por favor, preencha todos os campos obrigatórios corretamente.', 'error');
        }

        return isValid;
    }

    getStepFields(step) {
        const stepFields = {
            1: ['nomeClube', 'anoCriacaoClube', 'interesseClube', 'esporteClube', 'estadoClube', 'cidadeClube'],
            2: ['categoriaClube', 'cnpjClube', 'enderecoClube'],
            3: ['emailAdmin', 'senhaAdmin', 'confirmarSenha']
        };
        
        return stepFields[step] || [];
    }

    validateField(fieldId) {
        const field = document.getElementById(fieldId);
        if (!field) return true;
        
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        
        // Limpar erros anteriores
        this.clearFieldError(fieldId);
        
        // Verificar se é obrigatório e está vazio
        if (isRequired && !value) {
            const label = field.closest('.form-group').querySelector('label').textContent.replace('*', '').trim();
            this.showFieldError(fieldId, `${label} é obrigatório.`);
            return false;
        }
        
        // Validações específicas
        if (value) {
            switch (fieldId) {
                case 'anoCriacaoClube':
                    const selectedDate = new Date(value);
                    const currentDate = new Date();
                    if (selectedDate > currentDate) {
                        this.showFieldError(fieldId, 'A data não pode ser no futuro.');
                        return false;
                    }
                    break;
                    
                case 'cnpjClube':
                    if (!this.validateCNPJ(value)) {
                        this.showFieldError(fieldId, 'CNPJ inválido.');
                        return false;
                    }
                    break;
                    
                case 'emailAdmin':
                    if (!this.validateEmail(value)) {
                        this.showFieldError(fieldId, 'Email inválido.');
                        return false;
                    }
                    break;
                    
                case 'senhaAdmin':
                    if (value.length < 8) {
                        this.showFieldError(fieldId, 'A senha deve ter pelo menos 8 caracteres.');
                        return false;
                    }
                    break;
                    
                case 'confirmarSenha':
                    const senha = document.getElementById('senhaAdmin').value;
                    if (value !== senha) {
                        this.showFieldError(fieldId, 'As senhas não coincidem.');
                        return false;
                    }
                    break;
            }
        }
        
        return true;
    }

    // Utilitários de validação
    validateCNPJ(cnpj) {
        cnpj = cnpj.replace(/[^\d]+/g, '');
        
        if (cnpj.length !== 14) return false;
        
        // Elimina CNPJs inválidos conhecidos
        if (/^(\d)\1+$/.test(cnpj)) return false;
        
        // Valida DVs
        let tamanho = cnpj.length - 2;
        let numeros = cnpj.substring(0, tamanho);
        let digitos = cnpj.substring(tamanho);
        let soma = 0;
        let pos = tamanho - 7;
        
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        
        let resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0)) return false;
        
        tamanho = tamanho + 1;
        numeros = cnpj.substring(0, tamanho);
        soma = 0;
        pos = tamanho - 7;
        
        for (let i = tamanho; i >= 1; i--) {
            soma += numeros.charAt(tamanho - i) * pos--;
            if (pos < 2) pos = 9;
        }
        
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        return resultado == digitos.charAt(1);
    }

    validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Formatação
    formatCNPJ(input) {
        let value = input.value.replace(/\D/g, '');
        
        if (value.length <= 14) {
            value = value.replace(/^(\d{2})(\d)/, '$1.$2');
            value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
            value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
            value = value.replace(/(\d{4})(\d)/, '$1-$2');
        }
        
        input.value = value;
    }

    // Verificações de disponibilidade
    debounceValidation(key, callback, delay = 500) {
        clearTimeout(this.debounceTimers[key]);
        this.debounceTimers[key] = setTimeout(callback, delay);
    }

    async checkCnpjAvailability() {
        const cnpjField = document.getElementById('cnpjClube');
        const cnpjCheck = document.getElementById('cnpjCheck');
        const cnpj = cnpjField.value.trim();

        if (cnpj.length !== 18) {
            cnpjCheck.className = 'availability-check';
            return;
        }

        if (!this.validateCNPJ(cnpj)) {
            cnpjCheck.className = 'availability-check unavailable';
            cnpjCheck.innerHTML = '<i class="fas fa-times"></i>';
            this.showFieldError('cnpjClube', 'CNPJ inválido');
            return;
        }

        cnpjCheck.className = 'availability-check checking';
        cnpjCheck.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        try {
            // Simular verificação de disponibilidade
            await new Promise(resolve => setTimeout(resolve, 1000));
            
            // Por enquanto, sempre retorna disponível
            cnpjCheck.className = 'availability-check available';
            cnpjCheck.innerHTML = '<i class="fas fa-check"></i>';
            this.showFieldSuccess('cnpjClube', 'CNPJ disponível');
            this.clearFieldError('cnpjClube');
            
        } catch (error) {
            cnpjCheck.className = 'availability-check unavailable';
            cnpjCheck.innerHTML = '<i class="fas fa-times"></i>';
            this.showFieldError('cnpjClube', 'Erro ao verificar CNPJ');
        }
    }

    async checkEmailAvailability() {
        const emailField = document.getElementById('emailAdmin');
        const emailCheck = document.getElementById('emailCheck');
        const email = emailField.value.trim();

        if (!email || !this.validateEmail(email)) {
            emailCheck.className = 'availability-check';
            return;
        }

        emailCheck.className = 'availability-check checking';
        emailCheck.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

        try {
            // Simular verificação de disponibilidade
            await new Promise(resolve => setTimeout(resolve, 800));
            
            // Por enquanto, sempre retorna disponível
            emailCheck.className = 'availability-check available';
            emailCheck.innerHTML = '<i class="fas fa-check"></i>';
            this.showFieldSuccess('emailAdmin', 'Email disponível');
            this.clearFieldError('emailAdmin');
            
        } catch (error) {
            emailCheck.className = 'availability-check unavailable';
            emailCheck.innerHTML = '<i class="fas fa-times"></i>';
            this.showFieldError('emailAdmin', 'Erro ao verificar email');
        }
    }

    // Força da senha
    updatePasswordStrength() {
        const senha = document.getElementById('senhaAdmin').value;
        const strength = this.calculatePasswordStrength(senha);
        
        this.strengthFill.style.width = `${strength.percentage}%`;
        this.strengthFill.style.backgroundColor = strength.color;
        this.strengthText.textContent = strength.text;
        this.strengthText.style.color = strength.color;
    }

    calculatePasswordStrength(password) {
        if (!password) {
            return { percentage: 0, color: '#ddd', text: 'Digite uma senha' };
        }
        
        let score = 0;
        const checks = {
            length: password.length >= 8,
            lowercase: /[a-z]/.test(password),
            uppercase: /[A-Z]/.test(password),
            numbers: /\d/.test(password),
            special: /[^A-Za-z0-9]/.test(password)
        };
        
        score = Object.values(checks).filter(Boolean).length;
        
        const levels = [
            { min: 0, max: 1, percentage: 20, color: '#e3342f', text: 'Muito fraca' },
            { min: 2, max: 2, percentage: 40, color: '#ffc107', text: 'Fraca' },
            { min: 3, max: 3, percentage: 60, color: '#fd7e14', text: 'Regular' },
            { min: 4, max: 4, percentage: 80, color: '#20c997', text: 'Forte' },
            { min: 5, max: 5, percentage: 100, color: '#28a745', text: 'Muito forte' }
        ];
        
        return levels.find(level => score >= level.min && score <= level.max) || levels[0];
    }

    validatePasswordMatch() {
        const senha = document.getElementById('senhaAdmin').value;
        const confirmar = document.getElementById('confirmarSenha').value;
        
        if (confirmar && senha !== confirmar) {
            this.showFieldError('confirmarSenha', 'As senhas não coincidem.');
        } else if (confirmar && senha === confirmar) {
            this.clearFieldError('confirmarSenha');
            this.showFieldSuccess('confirmarSenha', 'Senhas coincidem');
        }
    }

    // Gerenciamento de dados
    saveFieldData(fieldId, value) {
        this.formData[fieldId] = value;
        localStorage.setItem('cadastro_unificado', JSON.stringify(this.formData));
    }

    loadSavedData() {
        try {
            const savedData = localStorage.getItem('cadastro_unificado');
            if (savedData) {
                this.formData = JSON.parse(savedData);
                
                Object.keys(this.formData).forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field && this.formData[fieldId]) {
                        field.value = this.formData[fieldId];
                    }
                });
            }
        } catch (error) {
            console.error('Erro ao carregar dados salvos:', error);
        }
    }

    // Submissão do formulário
    async submitForm() {
        if (this.isSubmitting) return;
        
        if (!this.validateCurrentStep()) {
            return;
        }
        
        this.isSubmitting = true;
        this.showLoading(true);
        
        try {
            // Coletar todos os dados do formulário
            const formData = new FormData(this.elements.form);
            const data = Object.fromEntries(formData.entries());
            
            // Adicionar dados salvos
            Object.assign(data, this.formData);
            
            // Tentar enviar para a API
            const response = await fetch('/register', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]')?.getAttribute('content') || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            });
            
            if (response.ok) {
                const result = await response.json();
                
                if (result.success) {
                    this.showNotification('Cadastro realizado com sucesso!', 'success');
                    
                    // Limpar dados salvos
                    localStorage.removeItem('cadastro_unificado');
                    
                    // Redirecionar após sucesso
                    setTimeout(() => {
                        window.location.href = result.redirect || '/dashboard';
                    }, 2000);
                    
                    return;
                } else {
                    throw new Error(result.message || 'Erro no cadastro');
                }
            } else {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || 'Erro na comunicação com o servidor');
            }
            
        } catch (error) {
            console.error('Erro no cadastro:', error);
            this.showNotification(
                error.message || 'Erro ao processar cadastro. Tente novamente.',
                'error'
            );
        } finally {
            this.isSubmitting = false;
            this.showLoading(false);
        }
    }

    // Interface de usuário
    showFieldError(fieldId, message) {
        const errorElement = document.getElementById(fieldId + 'Error');
        const inputWrapper = document.getElementById(fieldId)?.closest('.input-icon-wrapper');
        
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.add('show');
        }
        
        if (inputWrapper) {
            inputWrapper.classList.add('error');
            inputWrapper.classList.remove('success');
        }
    }

    showFieldSuccess(fieldId, message) {
        const successElement = document.getElementById(fieldId + 'Success');
        const inputWrapper = document.getElementById(fieldId)?.closest('.input-icon-wrapper');
        
        if (successElement) {
            successElement.textContent = message;
            successElement.classList.add('show');
        }
        
        if (inputWrapper) {
            inputWrapper.classList.add('success');
            inputWrapper.classList.remove('error');
        }
    }

    clearFieldError(fieldId) {
        const errorElement = document.getElementById(fieldId + 'Error');
        const successElement = document.getElementById(fieldId + 'Success');
        const inputWrapper = document.getElementById(fieldId)?.closest('.input-icon-wrapper');
        
        if (errorElement) {
            errorElement.classList.remove('show');
        }
        
        if (successElement) {
            successElement.classList.remove('show');
        }
        
        if (inputWrapper) {
            inputWrapper.classList.remove('error', 'success');
        }
    }

    showNotification(message, type = 'info', duration = 4000) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        
        const icon = this.getNotificationIcon(type);
        notification.innerHTML = `
            <i class="${icon}"></i>
            <span>${message}</span>
        `;

        this.elements.notificationContainer.appendChild(notification);

        // Animar entrada
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);

        // Remover após duração especificada
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                if (this.elements.notificationContainer.contains(notification)) {
                    this.elements.notificationContainer.removeChild(notification);
                }
            }, 300);
        }, duration);
    }

    getNotificationIcon(type) {
        const icons = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle',
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };
        return icons[type] || icons.info;
    }

    showLoading(show) {
        this.elements.loadingOverlay.style.display = show ? 'flex' : 'none';
    }
}

// Inicializar quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', () => {
    new CadastroUnificado();
});

// Prevenir perda de dados ao sair da página
window.addEventListener('beforeunload', (e) => {
    const hasUnsavedData = localStorage.getItem('cadastro_unificado');
    if (hasUnsavedData) {
        e.preventDefault();
        e.returnValue = 'Você tem dados não salvos. Tem certeza que deseja sair?';
    }
});

    </script>
</body>
</html>
