<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Clube Esportivo</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, rgba(0,0,0,0.5), rgba(0,0,0,0.3)), 
                        url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><rect fill="%23667788" width="1200" height="800"/></svg>');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 480px;
            position: relative;
        }

        /* Barra de progresso */
        .progress-container {
            position: relative;
            margin-bottom: 30px;
        }

        .progress-bar {
            width: 100%;
            height: 12px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #00D66B, #00FF7F);
            border-radius: 20px;
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 20px rgba(0, 214, 107, 0.5);
        }

        /* Bonequinho corredor */
        .runner {
            position: absolute;
            top: -25px;
            left: 0;
            transition: left 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
        }

        .runner svg {
            width: 40px;
            height: 40px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }

        /* Percentual */
        .progress-text {
            text-align: center;
            color: white;
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }

        /* Card do formulário */
        .form-card {
            background: white;
            border-radius: 24px;
            padding: 40px 35px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        label {
            display: block;
            color: #00D66B;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input, select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #00D66B;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: white;
            color: #333;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #00FF7F;
            box-shadow: 0 0 0 4px rgba(0, 214, 107, 0.1);
        }

        input::placeholder {
            color: #999;
        }

        select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2300D66B' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 40px;
        }

        /* Ícones nos inputs */
        .input-with-icon {
            position: relative;
        }

        .input-with-icon input,
        .input-with-icon select {
            padding-left: 44px;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #00D66B;
            font-size: 18px;
        }

        /* Botões de navegação */
        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
        }

        .btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 24px;
        }

        .btn-back {
            background: #E0E0E0;
            color: #666;
        }

        .btn-back:hover {
            background: #D0D0D0;
            transform: scale(1.05);
        }

        .btn-next {
            background: linear-gradient(135deg, #00D66B, #00FF7F);
            color: white;
            flex: 1;
            margin-left: 16px;
            border-radius: 30px;
            width: auto;
            font-size: 18px;
            font-weight: 600;
            padding: 18px 40px;
        }

        .btn-next:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 214, 107, 0.4);
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Esconder steps */
        .step {
            display: none;
        }

        .step.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mensagem de sucesso */
        .success-message {
            display: none;
            text-align: center;
            padding: 40px;
        }

        .success-message.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        .success-icon {
            font-size: 80px;
            color: #00D66B;
            margin-bottom: 20px;
        }

        .success-message h2 {
            color: #00D66B;
            margin-bottom: 10px;
        }

        .success-message p {
            color: #666;
        }

        /* Responsivo */
        @media (max-width: 600px) {
            .form-card {
                padding: 30px 25px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Barra de Progresso -->
        <div class="progress-container">
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            <div class="runner" id="runner">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="5" r="3" fill="#00D66B"/>
                    <path d="M12 8 L12 14 M12 14 L9 18 M12 14 L15 18 M12 10 L8 12 M12 10 L16 12" 
                          stroke="#00D66B" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="progress-text" id="progressText">0%</div>
        </div>

        <!-- Card do Formulário -->
        <div class="form-card">
            <form id="cadastroForm">
                <!-- Step 1: Dados Pessoais -->
                <div class="step active" data-step="1">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <div class="input-with-icon">
                            <span class="input-icon">👤</span>
                            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ano_nascimento">Ano de nascimento</label>
                        <div class="input-with-icon">
                            <span class="input-icon">📅</span>
                            <input type="text" id="ano_nascimento" name="ano_nascimento" placeholder="dd/MM/AAAA" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="esporte">Esporte</label>
                        <div class="input-with-icon">
                            <span class="input-icon">🏐</span>
                            <select id="esporte" name="esporte" required>
                                <option value="">Selecione um esporte</option>
                                <option value="volei">Vôlei</option>
                                <option value="futebol">Futebol</option>
                                <option value="basquete">Basquete</option>
                                <option value="tenis">Tênis</option>
                                <option value="natacao">Natação</option>
                                <option value="atletismo">Atletismo</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Localização -->
                <div class="step" data-step="2">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <div class="input-with-icon">
                                <span class="input-icon">📍</span>
                                <input type="text" id="estado" name="estado" placeholder="UF" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <div class="input-with-icon">
                                <span class="input-icon">🏙️</span>
                                <input type="text" id="cidade" name="cidade" placeholder="Sua cidade" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Contato -->
                <div class="step" data-step="3">
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <div class="input-with-icon">
                            <span class="input-icon">📧</span>
                            <input type="email" id="email" name="email" placeholder="seu@email.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        <div class="input-with-icon">
                            <span class="input-icon">📱</span>
                            <input type="tel" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
                        </div>
                    </div>
                </div>

                <!-- Step 4: Senha -->
                <div class="step" data-step="4">
                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <div class="input-with-icon">
                            <span class="input-icon">🔒</span>
                            <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirmar_senha">Confirmar Senha</label>
                        <div class="input-with-icon">
                            <span class="input-icon">🔒</span>
                            <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="Confirme sua senha" required>
                        </div>
                    </div>
                </div>

                <!-- Mensagem de Sucesso -->
                <div class="success-message" id="successMessage">
                    <div class="success-icon">✓</div>
                    <h2>Cadastro Concluído!</h2>
                    <p>Bem-vindo ao clube esportivo.</p>
                </div>

                <!-- Navegação -->
                <div class="navigation">
                    <button type="button" class="btn btn-back" id="btnBack">←</button>
                    <button type="button" class="btn btn-next" id="btnNext">Próximo →</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('cadastroForm');
        const steps = document.querySelectorAll('.step');
        const btnBack = document.getElementById('btnBack');
        const btnNext = document.getElementById('btnNext');
        const progressFill = document.getElementById('progressFill');
        const progressText = document.getElementById('progressText');
        const runner = document.getElementById('runner');
        const successMessage = document.getElementById('successMessage');
        
        let currentStep = 1;
        const totalSteps = 4;

        // Atualizar progresso
        function updateProgress() {
            const progress = (currentStep / totalSteps) * 100;
            progressFill.style.width = progress + '%';
            progressText.textContent = Math.round(progress) + '%';
            runner.style.left = progress + '%';
        }

        // Mostrar step atual
        function showStep(step) {
            steps.forEach(s => s.classList.remove('active'));
            const currentStepElement = document.querySelector(`[data-step="${step}"]`);
            if (currentStepElement) {
                currentStepElement.classList.add('active');
            }

            // Atualizar botões
            btnBack.disabled = step === 1;
            btnBack.style.opacity = step === 1 ? '0.3' : '1';

            if (step === totalSteps) {
                btnNext.textContent = 'Finalizar ✓';
            } else {
                btnNext.textContent = 'Próximo →';
            }

            updateProgress();
        }

        // Validar step atual
        function validateCurrentStep() {
            const currentStepElement = document.querySelector(`[data-step="${currentStep}"]`);
            const inputs = currentStepElement.querySelectorAll('input[required], select[required]');
            
            for (let input of inputs) {
                if (!input.value.trim()) {
                    input.focus();
                    return false;
                }
            }

            // Validação especial para senhas
            if (currentStep === totalSteps) {
                const senha = document.getElementById('senha').value;
                const confirmarSenha = document.getElementById('confirmar_senha').value;
                
                if (senha !== confirmarSenha) {
                    alert('As senhas não coincidem!');
                    return false;
                }
            }

            return true;
        }

        // Próximo
        btnNext.addEventListener('click', () => {
            if (!validateCurrentStep()) {
                return;
            }

            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            } else {
                // Finalizar cadastro
                finalizarCadastro();
            }
        });

        // Voltar
        btnBack.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        // Finalizar cadastro
        function finalizarCadastro() {
            const formData = new FormData(form);
            const data = Object.fromEntries(formData);
            
            console.log('Dados do cadastro:', data);
            
            // Esconder formulário e mostrar mensagem de sucesso
            steps.forEach(s => s.classList.remove('active'));
            document.querySelector('.navigation').style.display = 'none';
            successMessage.classList.add('active');
            
            // Progresso 100%
            progressFill.style.width = '100%';
            progressText.textContent = '100%';
            runner.style.left = '100%';

            // Aqui você pode fazer a requisição para o backend Laravel
            // fetch('/api/cadastro', {
            //     method: 'POST',
            //     headers: { 'Content-Type': 'application/json' },
            //     body: JSON.stringify(data)
            // });
        }

        // Máscara para telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/^(\d{2})(\d)/g, '($1) $2');
                value = value.replace(/(\d)(\d{4})$/, '$1-$2');
            }
            e.target.value = value;
        });

        // Máscara para data
        document.getElementById('ano_nascimento').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 8) {
                value = value.replace(/^(\d{2})(\d)/g, '$1/$2');
                value = value.replace(/(\d{2})(\d)/, '$1/$2');
            }
            e.target.value = value;
        });

        // Inicializar
        showStep(currentStep);
    </script>
</body>
</html>

