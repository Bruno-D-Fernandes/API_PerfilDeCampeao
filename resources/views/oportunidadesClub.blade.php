<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oportunidades</title>
    <link rel="stylesheet" href="{{ asset('css/oportunidadesClub.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- CSS CORRIGIDO PARA O MODAL -->
    <style>
        .modal-overlay.show {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background-color: rgba(0, 0, 0, 0.6) !important;
            z-index: 9999 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            backdrop-filter: blur(4px);
            animation: fadeIn 0.3s ease-out;
        }

        /* Overlay do modal - QUANDO OCULTO */
        .modal-overlay {
            display: none !important;
        }

        /* Container do modal - TEMA CLARO */
        .modal-container {
            background: #ffffff !important;
            border-radius: 16px !important;
            max-width: 600px !important;
            width: 90% !important;
            max-height: 90vh !important;
            overflow: hidden !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
            transform: scale(0.9) translateY(20px);
            animation: modalSlideIn 0.3s ease-out forwards;
            position: relative !important;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        /* Header do modal - TEMA CLARO */
        .modal-header {
            padding: 24px 24px 16px 24px !important;
            border-bottom: 1px solid #e9ecef !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            background: #ffffff !important;
            transition: all 0.3s ease;
        }

        .modal-title {
            font-size: 20px !important;
            font-weight: 600 !important;
            color: #333333 !important;
            margin: 0 !important;
            line-height: 1.3 !important;
            transition: color 0.3s ease;
        }

        .modal-close-btn {
            background: none !important;
            border: none !important;
            width: 32px !important;
            height: 32px !important;
            border-radius: 8px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            color: #6c757d !important;
            transition: all 0.2s ease !important;
            font-size: 24px !important;
            line-height: 1 !important;
        }

        .modal-close-btn:hover {
            background-color: #f0f2f5 !important;
            color: #333333 !important;
        }

        /* Body do modal - TEMA CLARO */
        .modal-body {
            padding: 24px !important;
            max-height: 60vh !important;
            overflow-y: auto !important;
            background: #ffffff !important;
            transition: all 0.3s ease;
        }

        /* Footer do modal - TEMA CLARO */
        .modal-footer {
            padding: 16px 24px 24px 24px !important;
            border-top: 1px solid #e9ecef !important;
            display: flex !important;
            gap: 12px !important;
            justify-content: flex-end !important;
            background: #ffffff !important;
            transition: all 0.3s ease;
        }

        /* =============================================== */
        /* TEMA ESCURO PARA MODAL DE OPORTUNIDADES        */
        /* =============================================== */

        body.dark-theme .modal-overlay.show {
            background-color: rgba(0, 0, 0, 0.8) !important;
        }

        body.dark-theme .modal-container {
            background: #1e1e1e !important;
            border-color: #333333 !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6) !important;
        }

        body.dark-theme .modal-header {
            background: #1e1e1e !important;
            border-bottom-color: #333333 !important;
        }

        body.dark-theme .modal-body {
            background: #1e1e1e !important;
        }

        body.dark-theme .modal-footer {
            background: #1e1e1e !important;
            border-top-color: #333333 !important;
        }

        body.dark-theme .modal-title {
            color: #e0e0e0 !important;
        }

        body.dark-theme .modal-close-btn {
            color: #a0a0a0 !important;
        }

        body.dark-theme .modal-close-btn:hover {
            background-color: #2a2a2a !important;
            color: #e0e0e0 !important;
        }

        /* =============================================== */
        /* FORMULÁRIO - TEMA CLARO E ESCURO               */
        /* =============================================== */

        .form-group {
            margin-bottom: 20px !important;
        }

        .form-group label {
            display: block !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            color: #333333 !important;
            margin-bottom: 6px !important;
            transition: color 0.3s ease;
        }

        .form-control {
            width: 100% !important;
            padding: 12px 16px !important;
            border: 1px solid #e9ecef !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            color: #333333 !important;
            background-color: #ffffff !important;
            transition: all 0.2s ease !important;
            font-family: inherit !important;
            box-sizing: border-box !important;
        }

        .form-control:focus {
            outline: none !important;
            border-color: #74d477 !important;
            box-shadow: 0 0 0 3px rgba(116, 212, 119, 0.1) !important;
        }

        .form-control::placeholder {
            color: #6c757d !important;
            transition: color 0.3s ease;
        }

        /* TEMA ESCURO PARA FORMULÁRIO */
        body.dark-theme .form-group label {
            color: #e0e0e0 !important;
        }

        body.dark-theme .form-control {
            background-color: #2a2a2a !important;
            border-color: #333333 !important;
            color: #e0e0e0 !important;
        }

        body.dark-theme .form-control:focus {
            border-color: #74d477 !important;
            box-shadow: 0 0 0 3px rgba(116, 212, 119, 0.2) !important;
            background-color: #2a2a2a !important;
        }

        body.dark-theme .form-control::placeholder {
            color: #888888 !important;
        }

        /* Textarea específico */
        textarea.form-control {
            resize: vertical !important;
            min-height: 100px !important;
        }

        /* Select específico */
        select.form-control {
            cursor: pointer !important;
        }

        /* Form row para campos lado a lado */
        .form-row {
            display: flex !important;
            gap: 16px !important;
            margin-bottom: 20px !important;
        }

        .form-row .form-group {
            flex: 1 !important;
            margin-bottom: 0 !important;
        }

        /* =============================================== */
        /* BOTÕES - TEMA CLARO E ESCURO                   */
        /* =============================================== */

        .btn {
            padding: 12px 24px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
            border: none !important;
            min-width: 100px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            text-decoration: none !important;
            font-family: inherit !important;
        }

        .btn:focus {
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #74d477, #5cb85c) !important;
            color: white !important;
            border: none !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5cb85c, #4a9a4a) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(116, 212, 119, 0.4) !important;
        }

        .btn-secondary {
            background: #f0f2f5 !important;
            color: #333333 !important;
            border: 1px solid #e9ecef !important;
        }

        .btn-secondary:hover {
            background: #f8f9fa !important;
            border-color: #666666 !important;
        }

        /* TEMA ESCURO PARA BOTÕES */
        body.dark-theme .btn-secondary {
            background: #2a2a2a !important;
            color: #e0e0e0 !important;
            border-color: #333333 !important;
        }

        body.dark-theme .btn-secondary:hover {
            background: #333333 !important;
            border-color: #555555 !important;
            color: #ffffff !important;
        }

        /* =============================================== */
        /* MODAL DE NOTIFICAÇÕES - TEMA ESCURO            */
        /* =============================================== */

        .notification-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
            opacity: 0;
            animation: fadeIn 0.3s ease-out forwards;
        }

        .notification-modal {
            background: #ffffff;
            border-radius: 16px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transform: scale(0.9) translateY(20px);
            animation: modalSlideIn 0.3s ease-out forwards;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .notification-modal-header {
            padding: 24px 24px 16px 24px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .notification-modal-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            flex-shrink: 0;
        }

        .notification-modal-icon.success { background: linear-gradient(135deg, #10b981, #059669); }
        .notification-modal-icon.error { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .notification-modal-icon.warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .notification-modal-icon.info { background: linear-gradient(135deg, #3b82f6, #2563eb); }

        .notification-modal-content {
            flex: 1;
            min-width: 0;
        }

        .notification-modal-title {
            font-size: 18px;
            font-weight: 600;
            color: #333333;
            margin: 0 0 8px 0;
            line-height: 1.3;
            transition: color 0.3s ease;
        }

        .notification-modal-message {
            font-size: 14px;
            color: #666666;
            line-height: 1.5;
            margin: 0;
            transition: color 0.3s ease;
        }

        .notification-modal-close {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
            font-size: 20px;
            line-height: 1;
            flex-shrink: 0;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notification-modal-close:hover {
            color: #333333;
            background: #f0f2f5;
        }

        .notification-modal-footer {
            padding: 16px 24px 24px 24px;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .notification-modal-btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            min-width: 80px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .notification-modal-btn.primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }

        .notification-modal-btn.primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .notification-modal-btn.secondary {
            background: #f0f2f5;
            color: #333333;
            border: 1px solid #e9ecef;
        }

        .notification-modal-btn.secondary:hover {
            background: #f8f9fa;
            border-color: #666666;
        }

        .notification-modal-btn.success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .notification-modal-btn.success:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        }

        .notification-modal-btn.danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .notification-modal-btn.danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        /* TEMA ESCURO PARA MODAL DE NOTIFICAÇÕES */
        body.dark-theme .notification-modal-overlay {
            background-color: rgba(0, 0, 0, 0.8);
        }

        body.dark-theme .notification-modal {
            background: #1e1e1e;
            border-color: #333333;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
        }

        body.dark-theme .notification-modal-header {
            background: #1e1e1e;
        }

        body.dark-theme .notification-modal-footer {
            background: #1e1e1e;
        }

        body.dark-theme .notification-modal-title {
            color: #e0e0e0;
        }

        body.dark-theme .notification-modal-message {
            color: #a0a0a0;
        }

        body.dark-theme .notification-modal-close {
            color: #a0a0a0;
        }

        body.dark-theme .notification-modal-close:hover {
            color: #e0e0e0;
            background: #2a2a2a;
        }

        body.dark-theme .notification-modal-btn.secondary {
            background: #2a2a2a;
            color: #e0e0e0;
            border-color: #333333;
        }

        body.dark-theme .notification-modal-btn.secondary:hover {
            background: #333333;
            border-color: #555555;
            color: #ffffff;
        }

        /* =============================================== */
        /* TOAST NOTIFICATIONS - TEMA ESCURO              */
        /* =============================================== */

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 2100;
            display: flex;
            flex-direction: column;
            gap: 12px;
            max-width: 400px;
        }

        .toast-notification {
            background: #ffffff;
            border-radius: 12px;
            padding: 16px 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid #e9ecef;
            border-left: 4px solid #e9ecef;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            transform: translateX(100%);
            animation: toastSlideIn 0.3s ease-out forwards;
            position: relative;
            transition: all 0.3s ease;
        }

        .toast-notification.success { border-left-color: #10b981; }
        .toast-notification.error { border-left-color: #ef4444; }
        .toast-notification.warning { border-left-color: #f59e0b; }
        .toast-notification.info { border-left-color: #3b82f6; }

        .toast-notification.hiding {
            animation: toastSlideOut 0.3s ease-out forwards;
        }

        .toast-icon {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: white;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .toast-icon.success { background: #10b981; }
        .toast-icon.error { background: #ef4444; }
        .toast-icon.warning { background: #f59e0b; }
        .toast-icon.info { background: #3b82f6; }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-size: 14px;
            font-weight: 600;
            color: #333333;
            margin: 0 0 4px 0;
            transition: color 0.3s ease;
        }

        .toast-message {
            font-size: 13px;
            color: #666666;
            line-height: 1.4;
            margin: 0;
            transition: color 0.3s ease;
        }

        .toast-close {
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 4px;
            border-radius: 4px;
            transition: all 0.2s ease;
            font-size: 16px;
            line-height: 1;
            flex-shrink: 0;
        }

        .toast-close:hover {
            color: #333333;
            background: #f0f2f5;
        }

        /* TEMA ESCURO PARA TOAST */
        body.dark-theme .toast-notification {
            background: #1e1e1e;
            border-color: #333333;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        body.dark-theme .toast-title {
            color: #e0e0e0;
        }

        body.dark-theme .toast-message {
            color: #a0a0a0;
        }

        body.dark-theme .toast-close {
            color: #a0a0a0;
        }

        body.dark-theme .toast-close:hover {
            color: #e0e0e0;
            background: #2a2a2a;
        }

        /* =============================================== */
        /* ANIMAÇÕES                                       */
        /* =============================================== */

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }

        @keyframes modalSlideIn {
            from {
                transform: scale(0.9) translateY(20px);
                opacity: 0;
            }
            to {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        @keyframes modalSlideOut {
            from {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
            to {
                transform: scale(0.9) translateY(20px);
                opacity: 0;
            }
        }

        @keyframes toastSlideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes toastSlideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        /* Animação de saída */
        .modal-overlay.hiding {
            animation: fadeOut 0.3s ease-out forwards !important;
        }

        .modal-overlay.hiding .modal-container {
            animation: modalSlideOut 0.3s ease-out forwards !important;
        }

        .notification-modal-overlay.hiding {
            animation: fadeOut 0.3s ease-out forwards;
        }

        .notification-modal-overlay.hiding .notification-modal {
            animation: modalSlideOut 0.3s ease-out forwards;
        }

        /* =============================================== */
        /* RESPONSIVIDADE                                  */
        /* =============================================== */

        @media (max-width: 768px) {
            .modal-container {
                width: 95% !important;
                margin: 20px !important;
                max-height: 95vh !important;
            }
            
            .modal-header {
                padding: 20px 20px 16px 20px !important;
            }
            
            .modal-body {
                padding: 20px !important;
                max-height: 70vh !important;
            }
            
            .modal-footer {
                padding: 16px 20px 20px 20px !important;
                flex-direction: column !important;
            }
            
            .btn {
                width: 100% !important;
                justify-content: center !important;
            }
            
            .form-row {
                flex-direction: column !important;
                gap: 0 !important;
            }
            
            .form-row .form-group {
                margin-bottom: 20px !important;
            }

            .notification-modal {
                width: 95%;
                margin: 20px;
            }
            
            .notification-modal-header {
                padding: 20px 20px 12px 20px;
            }
            
            .notification-modal-footer {
                padding: 12px 20px 20px 20px;
                flex-direction: column;
            }
            
            .notification-modal-btn {
                width: 100%;
                justify-content: center;
            }
            
            .toast-container {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }

        /* Scroll customizado */
        .modal-body::-webkit-scrollbar {
            width: 6px;
        }

        .modal-body::-webkit-scrollbar-track {
            background: #f0f2f5;
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb {
            background: #e9ecef;
            border-radius: 3px;
        }

        .modal-body::-webkit-scrollbar-thumb:hover {
            background: #6c757d;
        }

        /* Scroll customizado - tema escuro */
        body.dark-theme .modal-body::-webkit-scrollbar-track {
            background: #2a2a2a;
        }

        body.dark-theme .modal-body::-webkit-scrollbar-thumb {
            background: #333333;
        }

        body.dark-theme .modal-body::-webkit-scrollbar-thumb:hover {
            background: #555555;
        }#Logo{
        width: 150px;
        border-radius: 20px;
    }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo-section">
                <img id="Logo" src="{{ asset('img/logoPerfil.jpeg') }}" alt="Logo do Perfil">
            </div>
            
            <nav class="nav-menu">
                <ul>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="{{ asset('img/dashboard.png') }}" alt="Dashboard">
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <!-- ITEM ATIVO -->
                    <li class="nav-item active">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="{{ asset('img/oportunidades.png') }}" alt="Oportunidades">
                            <span class="nav-text">Oportunidades</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="{{ asset('img/vector.png') }}" alt="Lista">
                            <span class="nav-text">Listas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="{{ asset('img/mensagem.png') }}" alt="Mensagens">
                            <span class="nav-text">Mensagens</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="{{ asset('img/notificaçao.png') }}" alt="Notificações">
                            <span class="nav-text">Notificações</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="perfil" class="nav-link">
                            <img class="nav-icon" src="{{ asset('img/perfil.png') }}" alt="Perfil">
                            <span class="nav-text">Perfil</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="pesquisa" class="nav-link">
                            <img class="nav-icon" src="{{ asset('img/pesquisa.png') }}" alt="Pesquisa">
                            <span class="nav-text">Pesquisa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                       <a href="#" class="nav-link">
                            <img class="nav-icon" src="{{ asset('img/configuracoes.png') }}" alt="Configurações">
                            <span class="nav-text">Configurações</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <img class="nav-icon" src="{{ asset('img/sair.png') }}" alt="Sair">
                            <span class="nav-text">Sair</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="main-content">
            <h1 class="page-title">Oportunidades</h1>

            <!-- Estatísticas -->
            <div class="stats-bar" id="stats-bar" style="display: none;">
                <div class="stat-item">
                    <div class="stat-number" id="total-oportunidades">0</div>
                    <div class="stat-label">Total</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="oportunidades-ativas">0</div>
                    <div class="stat-label">Ativas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="total-interessados">0</div>
                    <div class="stat-label">Interessados</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number" id="oportunidades-recentes">0</div>
                    <div class="stat-label">Recentes</div>
                </div>
            </div>

            <div class="opportunities-container">
                <header class="opportunities-header">
                    <h2>Minhas oportunidades</h2>
                    <div class="header-controls">
                        <button class="filter-btn">
                            Ativas 
                            <span class="count-badge" id="count-badge">0</span>
                        </button>
                        <button class="new-btn" id="new-opportunity-btn">+ Novo</button>
                    </div>
                </header>

                <!-- Lista de Oportunidades -->
                <div class="opportunities-list" id="opportunities-list">
                    <!-- Oportunidades serão carregadas aqui -->
                </div>

                <!-- Paginação -->
                <div class="pagination" id="pagination" style="display: none;">
                    <!-- Paginação será gerada dinamicamente -->
                </div>
            </div>
        </main>
    </div>

    <!-- Modal de Oportunidade -->
    <div id="opportunity-modal" class="modal-overlay">
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title">Nova Oportunidade</h3>
                <button id="close-modal-btn" class="modal-close-btn">&times;</button>
            </div>
            <div class="modal-body">
                <form id="opportunity-form">
                    <div class="form-group">
                        <label for="descricaoOportunidades">Descrição da Oportunidade</label>
                        <textarea id="descricaoOportunidades" name="descricaoOportunidades" class="form-control" rows="4" required placeholder="Descreva a oportunidade..."></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="esporte_id">Esporte</label>
                            <select id="esporte_id" name="esporte_id" class="form-control" required>
                                <option value="">Selecione um esporte</option>
                                <!-- Opções carregadas dinamicamente -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="posicoes_id">Posição</label>
                            <select id="posicoes_id" name="posicoes_id" class="form-control" required>
                                <option value="">Selecione uma posição</option>
                                <!-- Opções carregadas dinamicamente -->
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="datapostagemOportunidades">Data de Postagem</label>
                        <input type="date" id="datapostagemOportunidades" name="datapostagemOportunidades" class="form-control" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="idadeMinima">Idade Mínima</label>
                            <input type="number" id="idadeMinima" name="idadeMinima" class="form-control" min="0" max="120" placeholder="Ex: 16">
                        </div>
                        <div class="form-group">
                            <label for="idadeMaxima">Idade Máxima</label>
                            <input type="number" id="idadeMaxima" name="idadeMaxima" class="form-control" min="0" max="120" placeholder="Ex: 25">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="estadoOportunidade">Estado</label>
                            <input type="text" id="estadoOportunidade" name="estadoOportunidade" class="form-control" placeholder="Ex: São Paulo">
                        </div>
                        <div class="form-group">
                            <label for="cidadeOportunidade">Cidade</label>
                            <input type="text" id="cidadeOportunidade" name="cidadeOportunidade" class="form-control" placeholder="Ex: São Paulo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="enderecoOportunidade">Endereço</label>
                        <input type="text" id="enderecoOportunidade" name="enderecoOportunidade" class="form-control" placeholder="Endereço completo (opcional)">
                    </div>

                    <div class="form-group">
                        <label for="cepOportunidade">CEP</label>
                        <input type="text" id="cepOportunidade" name="cepOportunidade" class="form-control" placeholder="00000-000">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="cancel-btn" class="btn btn-secondary">Cancelar</button>
                <button id="save-btn" type="submit" form="opportunity-form" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>

    <!-- JavaScript do Modal de Notificações -->
    <script>
        /**
         * Sistema de Notificações Modais Elegantes
         * Substitui os alerts básicos por modais bonitos e funcionais
         */
        class NotificationModal {
            constructor() {
                this.currentModal = null;
                this.toastContainer = null;
                this.initializeContainer();
            }

            initializeContainer() {
                if (!document.querySelector('.toast-container')) {
                    this.toastContainer = document.createElement('div');
                    this.toastContainer.className = 'toast-container';
                    document.body.appendChild(this.toastContainer);
                } else {
                    this.toastContainer = document.querySelector('.toast-container');
                }
            }

            show(options = {}) {
                const config = {
                    type: 'info',
                    title: 'Notificação',
                    message: 'Mensagem da notificação',
                    buttons: [
                        { text: 'OK', type: 'primary', action: 'close' }
                    ],
                    closable: true,
                    autoClose: false,
                    autoCloseDelay: 5000,
                    details: null,
                    compact: false,
                    ...options
                };

                if (this.currentModal) {
                    this.close();
                }

                const modal = this.createModal(config);
                document.body.appendChild(modal);
                this.currentModal = modal;

                setTimeout(() => {
                    modal.classList.add('show');
                }, 10);

                if (config.autoClose) {
                    setTimeout(() => {
                        this.close();
                    }, config.autoCloseDelay);
                }

                return modal;
            }

            createModal(config) {
                const overlay = document.createElement('div');
                overlay.className = `notification-modal-overlay ${config.compact ? 'compact' : ''}`;

                const modal = document.createElement('div');
                modal.className = `notification-modal ${config.compact ? 'compact' : ''}`;

                const header = document.createElement('div');
                header.className = 'notification-modal-header';

                const icon = document.createElement('div');
                icon.className = `notification-modal-icon ${config.type}`;
                icon.innerHTML = this.getIcon(config.type);

                const content = document.createElement('div');
                content.className = 'notification-modal-content';

                const title = document.createElement('h3');
                title.className = 'notification-modal-title';
                title.textContent = config.title;

                const message = document.createElement('p');
                message.className = 'notification-modal-message';
                message.textContent = config.message;

                content.appendChild(title);
                content.appendChild(message);

                let closeBtn = null;
                if (config.closable) {
                    closeBtn = document.createElement('button');
                    closeBtn.className = 'notification-modal-close';
                    closeBtn.innerHTML = '×';
                    closeBtn.onclick = () => this.close();
                }

                header.appendChild(icon);
                header.appendChild(content);
                if (closeBtn) header.appendChild(closeBtn);

                modal.appendChild(header);

                if (config.buttons && config.buttons.length > 0) {
                    const footer = document.createElement('div');
                    footer.className = 'notification-modal-footer';

                    config.buttons.forEach(buttonConfig => {
                        const button = document.createElement('button');
                        button.className = `notification-modal-btn ${buttonConfig.type || 'secondary'}`;
                        button.textContent = buttonConfig.text;

                        button.onclick = () => {
                            if (buttonConfig.loading) {
                                this.setButtonLoading(button, true);
                            }

                            if (buttonConfig.action === 'close') {
                                this.close();
                            } else if (typeof buttonConfig.action === 'function') {
                                const result = buttonConfig.action();
                                
                                if (result && typeof result.then === 'function') {
                                    result
                                        .then(() => {
                                            if (buttonConfig.closeOnSuccess !== false) {
                                                this.close();
                                            }
                                        })
                                        .catch((error) => {
                                            console.error('Erro na ação do botão:', error);
                                        })
                                        .finally(() => {
                                            this.setButtonLoading(button, false);
                                        });
                                } else {
                                    if (buttonConfig.closeOnSuccess !== false) {
                                        this.close();
                                    }
                                    this.setButtonLoading(button, false);
                                }
                            }
                        };

                        footer.appendChild(button);
                    });

                    modal.appendChild(footer);
                }

                overlay.appendChild(modal);

                // Fechar ao clicar no overlay
                overlay.onclick = (e) => {
                    if (e.target === overlay && config.closable) {
                        this.close();
                    }
                };

                // Fechar com ESC
                if (config.closable) {
                    const handleEsc = (e) => {
                        if (e.key === 'Escape') {
                            this.close();
                            document.removeEventListener('keydown', handleEsc);
                        }
                    };
                    document.addEventListener('keydown', handleEsc);
                }

                return overlay;
            }

            getIcon(type) {
                const icons = {
                    success: '✓',
                    error: '✕',
                    warning: '⚠',
                    info: 'ℹ'
                };
                return icons[type] || icons.info;
            }

            setButtonLoading(button, loading) {
                if (loading) {
                    button.disabled = true;
                    button.innerHTML = '<span class="spinner"></span> ' + button.textContent;
                } else {
                    button.disabled = false;
                    button.innerHTML = button.textContent.replace(/^.*?\s/, '');
                }
            }

            close() {
                if (this.currentModal) {
                    this.currentModal.classList.add('hiding');
                    setTimeout(() => {
                        if (this.currentModal && this.currentModal.parentNode) {
                            this.currentModal.parentNode.removeChild(this.currentModal);
                        }
                        this.currentModal = null;
                    }, 300);
                }
            }

            success(title, message, options = {}) {
                return this.show({
                    type: 'success',
                    title,
                    message,
                    ...options
                });
            }

            error(title, message, options = {}) {
                return this.show({
                    type: 'error',
                    title,
                    message,
                    ...options
                });
            }

            warning(title, message, options = {}) {
                return this.show({
                    type: 'warning',
                    title,
                    message,
                    ...options
                });
            }

            info(title, message, options = {}) {
                return this.show({
                    type: 'info',
                    title,
                    message,
                    ...options
                });
            }

            confirm(title, message, options = {}) {
                return new Promise((resolve) => {
                    this.show({
                        type: 'warning',
                        title,
                        message,
                        buttons: [
                            {
                                text: 'Cancelar',
                                type: 'secondary',
                                action: () => resolve(false)
                            },
                            {
                                text: 'Confirmar',
                                type: 'primary',
                                action: () => resolve(true)
                            }
                        ],
                        ...options
                    });
                });
            }

            toast(message, type = 'info', duration = 3000) {
                const toast = document.createElement('div');
                toast.className = `toast-notification ${type}`;

                const icon = document.createElement('div');
                icon.className = `toast-icon ${type}`;
                icon.innerHTML = this.getIcon(type);

                const content = document.createElement('div');
                content.className = 'toast-content';

                const title = document.createElement('div');
                title.className = 'toast-title';
                title.textContent = this.getToastTitle(type);

                const messageEl = document.createElement('div');
                messageEl.className = 'toast-message';
                messageEl.textContent = message;

                const closeBtn = document.createElement('button');
                closeBtn.className = 'toast-close';
                closeBtn.innerHTML = '×';
                closeBtn.onclick = () => this.removeToast(toast);

                content.appendChild(title);
                content.appendChild(messageEl);

                toast.appendChild(icon);
                toast.appendChild(content);
                toast.appendChild(closeBtn);

                this.toastContainer.appendChild(toast);

                setTimeout(() => {
                    this.removeToast(toast);
                }, duration);

                return toast;
            }

            removeToast(toast) {
                if (!toast || !toast.parentNode) return;

                toast.classList.add('hiding');
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }

            getToastTitle(type) {
                const titles = {
                    success: 'Sucesso',
                    error: 'Erro',
                    warning: 'Atenção',
                    info: 'Informação'
                };
                return titles[type] || titles.info;
            }

            clearAll() {
                this.close();
                if (this.toastContainer) {
                    this.toastContainer.innerHTML = '';
                }
            }
        }

        // Instância global
        const notification = new NotificationModal();

        // Métodos globais para facilitar o uso
        window.showNotification = (options) => notification.show(options);
        window.showSuccess = (title, message, options) => notification.success(title, message, options);
        window.showError = (title, message, options) => notification.error(title, message, options);
        window.showWarning = (title, message, options) => notification.warning(title, message, options);
        window.showInfo = (title, message, options) => notification.info(title, message, options);
        window.showConfirm = (title, message, options) => notification.confirm(title, message, options);
        window.showToast = (message, type, duration) => notification.toast(message, type, duration);
    </script>

    <!-- JavaScript principal da aplicação -->
    <script>
        // Configuração global
        const API_BASE_URL = '{{ url("/") }}';
        const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        class OportunidadeManager {
            constructor() {
                this.currentPage = 1;
                this.perPage = 15;
                this.totalPages = 1;
                this.isLoading = false;
                this.editingId = null; // IMPORTANTE: Controla se está editando ou criando
                
                this.initializeElements();
                this.bindEvents();
                this.loadInitialData();
            }

            initializeElements() {
                // Elementos principais
                this.opportunitiesList = document.getElementById('opportunities-list');
                this.pagination = document.getElementById('pagination');
                this.countBadge = document.getElementById('count-badge');
                this.statsBar = document.getElementById('stats-bar');
                
                // Elementos do modal
                this.modal = document.getElementById('opportunity-modal');
                this.modalTitle = document.getElementById('modal-title');
                this.form = document.getElementById('opportunity-form');
                this.newBtn = document.getElementById('new-opportunity-btn');
                this.closeModalBtn = document.getElementById('close-modal-btn');
                this.cancelBtn = document.getElementById('cancel-btn');
                this.saveBtn = document.getElementById('save-btn');
                
                // Campos do formulário
                this.esporteSelect = document.getElementById('esporte_id');
                this.posicaoSelect = document.getElementById('posicoes_id');
                
                // Elementos de estatísticas
                this.totalOportunidades = document.getElementById('total-oportunidades');
                this.oportunidadesAtivas = document.getElementById('oportunidades-ativas');
                this.totalInteressados = document.getElementById('total-interessados');
                this.oportunidadesRecentes = document.getElementById('oportunidades-recentes');

                console.log('Elementos inicializados:', {
                    modal: this.modal,
                    newBtn: this.newBtn,
                    form: this.form
                });
            }

            bindEvents() {
                console.log('Vinculando eventos...');
                
                // Modal events
                if (this.newBtn) {
                    this.newBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        console.log('Botão Novo clicado!');
                        this.openModal(); // Abre modal para NOVA oportunidade
                    });
                    console.log('Evento do botão Novo vinculado');
                } else {
                    console.error('Botão Novo não encontrado!');
                }

                if (this.closeModalBtn) {
                    this.closeModalBtn.addEventListener('click', () => this.closeModal());
                }

                if (this.cancelBtn) {
                    this.cancelBtn.addEventListener('click', () => this.closeModal());
                }
                
                // Form submit
                if (this.form) {
                    this.form.addEventListener('submit', (e) => {
                        e.preventDefault();
                        this.saveOportunidade();
                    });
                }
                
                // Close modal on overlay click
                if (this.modal) {
                    this.modal.addEventListener('click', (e) => {
                        if (e.target === this.modal) {
                            this.closeModal();
                        }
                    });
                }

                // ESC para fechar modal
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.modal && this.modal.classList.contains('show')) {
                        this.closeModal();
                    }
                });
            }

            // ========== ABRIR MODAL PARA NOVA OPORTUNIDADE ==========
            openModal() {
                console.log('Abrindo modal para NOVA oportunidade...');
                
                if (!this.modal) {
                    console.error('Modal não encontrado!');
                    showError('Erro', 'Modal não encontrado. Recarregue a página.');
                    return;
                }

                // RESETAR ESTADO DE EDIÇÃO
                this.editingId = null;
                this.modalTitle.textContent = 'Nova Oportunidade';
                this.form.reset();
                
                // Definir data atual
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('datapostagemOportunidades').value = today;
                
                // MOSTRAR MODAL COM CLASSE
                this.modal.classList.add('show');
                console.log('Modal aberto para NOVA oportunidade!');
                
                // Focar no primeiro campo
                setTimeout(() => {
                    document.getElementById('descricaoOportunidades').focus();
                }, 100);
            }

            // ========== ABRIR MODAL PARA EDITAR OPORTUNIDADE ==========
            async editOportunidade(id) {
                console.log(`Abrindo modal para EDITAR oportunidade ID: ${id}`);
                
                try {
                    const response = await this.makeRequest(`${API_BASE_URL}/api/oportunidades/${id}`);
                    
                    if (response.ok) {
                        const oportunidade = await response.json();
                        
                        // DEFINIR ESTADO DE EDIÇÃO
                        this.editingId = id;
                        this.modalTitle.textContent = 'Editar Oportunidade';
                        
                        // Preencher formulário
                        document.getElementById('descricaoOportunidades').value = oportunidade.descricaoOportunidades || '';
                        document.getElementById('esporte_id').value = oportunidade.esporte_id || '';
                        document.getElementById('posicoes_id').value = oportunidade.posicoes_id || '';
                        document.getElementById('datapostagemOportunidades').value = oportunidade.datapostagemOportunidades || '';
                        document.getElementById('idadeMinima').value = oportunidade.idadeMinima || '';
                        document.getElementById('idadeMaxima').value = oportunidade.idadeMaxima || '';
                        document.getElementById('estadoOportunidade').value = oportunidade.estadoOportunidade || '';
                        document.getElementById('cidadeOportunidade').value = oportunidade.cidadeOportunidade || '';
                        document.getElementById('enderecoOportunidade').value = oportunidade.enderecoOportunidade || '';
                        document.getElementById('cepOportunidade').value = oportunidade.cepOportunidade || '';
                        
                        // MOSTRAR MODAL COM CLASSE
                        this.modal.classList.add('show');
                        console.log('Modal aberto para EDITAR oportunidade!');
                    } else {
                        const errorData = await response.json();
                        showError('Erro ao Carregar', errorData.message || 'Não foi possível carregar a oportunidade para edição.');
                    }
                } catch (error) {
                    if (!error.message.includes('Sessão expirada')) {
                        showError('Erro Inesperado', 'Ocorreu um erro inesperado ao carregar a oportunidade.');
                    }
                }
            }

            closeModal() {
                console.log('Fechando modal...');
                if (this.modal) {
                    // REMOVER CLASSE PARA OCULTAR
                    this.modal.classList.remove('show');
                    this.form.reset();
                    this.editingId = null; // RESETAR ESTADO
                }
            }

            // ========== MÉTODO AUXILIAR PARA REQUISIÇÕES ==========
            async makeRequest(url, options = {}) {
                const defaultOptions = {
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        ...options.headers
                    }
                };

                const response = await fetch(url, { ...defaultOptions, ...options });
                
                // Verificar se a resposta é HTML (redirecionamento de login)
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('text/html')) {
                    showError('Sessão Expirada', 'Sua sessão expirou. Você será redirecionado para o login.', {
                        buttons: [
                            {
                                text: 'Ir para Login',
                                type: 'primary',
                                action: () => {
                                    window.location.href = '/login';
                                }
                            }
                        ]
                    });
                    throw new Error('Sessão expirada. Redirecionando para login...');
                }
                
                return response;
            }

            async loadInitialData() {
                console.log('Iniciando carregamento dos dados...');
                await Promise.all([
                    this.loadEsportes(),
                    this.loadPosicoes(),
                    this.loadOportunidades(),
                    this.loadEstatisticas()
                ]);
            }

            async loadEsportes() {
                try {
                    const response = await this.makeRequest(`${API_BASE_URL}/api/oportunidades/esportes`);
                    
                    if (response.ok) {
                        const esportes = await response.json();
                        
                        this.esporteSelect.innerHTML = '<option value="">Selecione um esporte</option>';
                        esportes.forEach(esporte => {
                            const option = document.createElement('option');
                            option.value = esporte.id;
                            option.textContent = esporte.nomeEsporte;
                            this.esporteSelect.appendChild(option);
                        });
                    } else {
                        showToast('Erro ao carregar esportes', 'error');
                    }
                } catch (error) {
                    if (!error.message.includes('Sessão expirada')) {
                        showToast('Erro ao carregar esportes', 'error');
                    }
                }
            }

            async loadPosicoes() {
                try {
                    const response = await this.makeRequest(`${API_BASE_URL}/api/oportunidades/posicoes`);
                    
                    if (response.ok) {
                        const posicoes = await response.json();
                        
                        this.posicaoSelect.innerHTML = '<option value="">Selecione uma posição</option>';
                        posicoes.forEach(posicao => {
                            const option = document.createElement('option');
                            option.value = posicao.id;
                            option.textContent = posicao.nomePosicao;
                            this.posicaoSelect.appendChild(option);
                        });
                    } else {
                        showToast('Erro ao carregar posições', 'error');
                    }
                } catch (error) {
                    if (!error.message.includes('Sessão expirada')) {
                        showToast('Erro ao carregar posições', 'error');
                    }
                }
            }

            async loadOportunidades() {
                if (this.isLoading) return;

                this.isLoading = true;
                this.showLoading();

                try {
                    const url = new URL(`${API_BASE_URL}/api/oportunidades/minhas`);
                    url.searchParams.append('page', this.currentPage);
                    url.searchParams.append('per_page', this.perPage);

                    const response = await this.makeRequest(url);
                    
                    if (!response.ok) {
                        throw new Error(`Erro HTTP: ${response.status} - ${response.statusText}`);
                    }

                    const data = await response.json();
                    
                    this.renderOportunidades(data);
                    this.updateCountBadge(data.total || 0);
                    this.renderPagination(data);

                } catch (error) {
                    if (!error.message.includes('Sessão expirada')) {
                        this.showError(`Erro ao carregar oportunidades: ${error.message}`);
                    }
                } finally {
                    this.isLoading = false;
                }
            }

            async loadEstatisticas() {
                try {
                    const response = await this.makeRequest(`${API_BASE_URL}/api/oportunidades/estatisticas`);
                    
                    if (response.ok) {
                        const stats = await response.json();
                        
                        this.totalOportunidades.textContent = stats.total_oportunidades || 0;
                        this.oportunidadesAtivas.textContent = stats.oportunidades_ativas || 0;
                        this.totalInteressados.textContent = stats.total_interessados || 0;
                        this.oportunidadesRecentes.textContent = stats.oportunidades_recentes || 0;
                        
                        this.statsBar.style.display = 'flex';
                    } else {
                        showToast('Erro ao carregar estatísticas', 'error');
                    }
                } catch (error) {
                    if (!error.message.includes('Sessão expirada')) {
                        showToast('Erro ao carregar estatísticas', 'error');
                    }
                }
            }

            // ========== SALVAR OPORTUNIDADE (CRIAR OU EDITAR) ==========
            async saveOportunidade() {
                try {
                    const currentToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    if (!currentToken) {
                        showError('Token de Segurança', 'Token de segurança não encontrado. Recarregue a página.');
                        return;
                    }

                    const formData = new FormData(this.form);
                    const data = Object.fromEntries(formData.entries());

                    // DETERMINAR SE É EDIÇÃO OU CRIAÇÃO
                    const isEditing = this.editingId !== null;
                    const url = isEditing 
                        ? `${API_BASE_URL}/api/oportunidades/${this.editingId}`
                        : `${API_BASE_URL}/api/oportunidades`;
                    
                    const method = isEditing ? 'PUT' : 'POST';

                    console.log(`Salvando oportunidade - Modo: ${isEditing ? 'EDIÇÃO' : 'CRIAÇÃO'}`);

                    const response = await this.makeRequest(url, {
                        method: method,
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': currentToken,
                        },
                        body: JSON.stringify(data)
                    });

                    if (response.ok) {
                        this.closeModal();
                        await this.loadOportunidades();
                        await this.loadEstatisticas();
                        
                        // MENSAGENS DIFERENTES PARA EDIÇÃO E CRIAÇÃO
                        if (isEditing) {
                            showSuccess(
                                'Oportunidade Atualizada!',
                                'A oportunidade foi atualizada com sucesso.',
                                {
                                    buttons: [
                                        {
                                            text: 'Ver Oportunidades',
                                            type: 'primary',
                                            action: () => {
                                                document.getElementById('opportunities-list').scrollIntoView({ behavior: 'smooth' });
                                            }
                                        }
                                    ]
                                }
                            );
                        } else {
                            showSuccess(
                                'Oportunidade Criada!',
                                'A nova oportunidade foi criada com sucesso.',
                                {
                                    buttons: [
                                        {
                                            text: 'Ver Oportunidades',
                                            type: 'primary',
                                            action: () => {
                                                document.getElementById('opportunities-list').scrollIntoView({ behavior: 'smooth' });
                                            }
                                        },
                                        {
                                            text: 'Criar Outra',
                                            type: 'secondary',
                                            action: () => {
                                                this.openModal();
                                            }
                                        }
                                    ]
                                }
                            );
                        }
                    } else {
                        const errorData = await response.json();
                        
                        showError(
                            'Erro ao Salvar',
                            errorData.message || 'Não foi possível salvar a oportunidade.',
                            {
                                details: errorData.errors ? {
                                    title: 'Detalhes do erro:',
                                    text: Object.values(errorData.errors).flat().join('\n')
                                } : null
                            }
                        );
                    }
                } catch (error) {
                    if (error.message.includes('Sessão expirada')) {
                        return;
                    }
                    
                    showError(
                        'Erro Inesperado',
                        'Ocorreu um erro inesperado ao salvar a oportunidade.',
                        {
                            details: {
                                title: 'Detalhes técnicos:',
                                text: error.message
                            }
                        }
                    );
                }
            }

            showLoading() {
                this.opportunitiesList.innerHTML = '<div class="loading">Carregando oportunidades...</div>';
            }

            showError(message) {
                this.opportunitiesList.innerHTML = `<div class="error-message">${message}</div>`;
            }

            renderOportunidades(data) {
                if (!data.data || data.data.length === 0) {
                    this.opportunitiesList.innerHTML = `
                        <div class="empty-state">
                            <h3>Nenhuma oportunidade encontrada</h3>
                            <p>Você ainda não criou nenhuma oportunidade.</p>
                            <button class="btn-create" onclick="oportunidadeManager.openModal()">Criar Primeira Oportunidade</button>
                        </div>
                    `;
                    return;
                }

                let html = '';
                data.data.forEach(oportunidade => {
                    html += this.renderOportunidadeItem(oportunidade);
                });

                this.opportunitiesList.innerHTML = html;
            }

            renderOportunidadeItem(oportunidade) {
                const dataFormatada = new Date(oportunidade.datapostagemOportunidades).toLocaleDateString('pt-BR');
                const esporte = oportunidade.esporte?.nomeEsporte || 'N/A';
                const posicao = oportunidade.posicao?.nomePosicao || 'N/A';
                const interessados = oportunidade.total_interessados || 0;

                return `
                    <div class="opportunity-item">
                        <div class="item-icon">
                            🎯
                        </div>
                        <div class="item-content">
                            <h3 class="item-title">${oportunidade.descricaoOportunidades}</h3>
                            <p class="item-date">Postado em ${dataFormatada}</p>
                            <div class="item-tags">
                                <span class="tag tag-category">${esporte}</span>
                                <span class="tag tag-position">${posicao}</span>
                                <span class="tag tag-interested">${interessados} interessado${interessados !== 1 ? 's' : ''}</span>
                                ${this.getIdadeTag(oportunidade.idadeMinima, oportunidade.idadeMaxima)}
                                ${this.getLocationTag(oportunidade.cidadeOportunidade, oportunidade.estadoOportunidade)}
                            </div>
                        </div>
                        <div class="item-actions">
                            <button class="options-btn" onclick="this.nextElementSibling.style.display = this.nextElementSibling.style.display === 'block' ? 'none' : 'block'">⋮</button>
                            <div class="options-menu">
                                <a href="#" onclick="oportunidadeManager.editOportunidade(${oportunidade.id})">Editar</a>
                                <a href="#" onclick="oportunidadeManager.deleteOportunidade(${oportunidade.id})" class="danger">Deletar</a>
                            </div>
                        </div>
                    </div>
                `;
            }

            getIdadeTag(min, max) {
                if (min && max) return `<span class="tag tag-modality">${min}-${max} anos</span>`;
                if (min) return `<span class="tag tag-modality">${min}+ anos</span>`;
                if (max) return `<span class="tag tag-modality">até ${max} anos</span>`;
                return '';
            }

            getLocationTag(cidade, estado) {
                if (cidade && estado) return `<span class="tag tag-location">${cidade}, ${estado}</span>`;
                if (cidade) return `<span class="tag tag-location">${cidade}</span>`;
                if (estado) return `<span class="tag tag-location">${estado}</span>`;
                return '';
            }

            updateCountBadge(count) {
                this.countBadge.textContent = count;
            }

            renderPagination(data) {
                if (data.last_page && data.last_page > 1) {
                    this.pagination.style.display = 'flex';
                } else {
                    this.pagination.style.display = 'none';
                }
            }

            async deleteOportunidade(id) {
                const confirmed = await showConfirm(
                    'Deletar Oportunidade',
                    'Tem certeza que deseja deletar esta oportunidade? Esta ação não pode ser desfeita.',
                    {
                        buttons: [
                            {
                                text: 'Cancelar',
                                type: 'secondary',
                                action: () => false
                            },
                            {
                                text: 'Deletar',
                                type: 'danger',
                                action: () => true
                            }
                        ]
                    }
                );

                if (!confirmed) return;

                try {
                    const response = await this.makeRequest(`${API_BASE_URL}/api/oportunidades/${id}`, {
                        method: 'DELETE'
                    });

                    if (response.ok) {
                        await this.loadOportunidades();
                        await this.loadEstatisticas();
                        
                        showToast('Oportunidade deletada com sucesso!', 'success');
                    } else {
                        const errorData = await response.json();
                        showError('Erro ao Deletar', errorData.message || 'Não foi possível deletar a oportunidade.');
                    }
                } catch (error) {
                    if (!error.message.includes('Sessão expirada')) {
                        showError('Erro Inesperado', 'Ocorreu um erro inesperado ao deletar a oportunidade.');
                    }
                }
            }
        }

        // Inicializar quando a página carregar
        let oportunidadeManager;
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM carregado, inicializando OportunidadeManager...');
            oportunidadeManager = new OportunidadeManager();
        });

        // Fechar menus ao clicar fora
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.options-btn')) {
                document.querySelectorAll('.options-menu').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });
    </script>

<script>
        // Seleciona os elementos do DOM
        const themeToggle = document.getElementById('theme-toggle');
        const themeName = document.getElementById('theme-name');
        const body = document.body;

        // Função para aplicar o tema salvo
        const applyTheme = (theme) => {
            if (theme === 'dark') {
                body.classList.add('dark-theme');
                themeName.textContent = 'Escuro';
                themeToggle.checked = true;
            } else {
                body.classList.remove('dark-theme');
                themeName.textContent = 'Claro';
                themeToggle.checked = false;
            }
        };

        // Verifica se há um tema salvo no localStorage
        const savedTheme = localStorage.getItem('theme');
        
        // Aplica o tema salvo ao carregar a página
        // Se não houver tema salvo, o padrão será 'claro'
        applyTheme(savedTheme);

        // Adiciona o evento de clique ao toggle
        themeToggle.addEventListener('change', () => {
            let newTheme;
            // Se o toggle estiver marcado, o tema é 'escuro'
            if (themeToggle.checked) {
                newTheme = 'dark';
            } else {
                newTheme = 'claro';
            }
            
            // Aplica o novo tema
            applyTheme(newTheme);
            
            // Salva a preferência no localStorage
            localStorage.setItem('theme', newTheme);
        });
    </script>

</body>
</html>
