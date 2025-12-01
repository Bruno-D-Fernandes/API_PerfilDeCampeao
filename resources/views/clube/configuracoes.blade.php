<x-layouts.clube title="Configurações" :breadcrumb="[
    'Dashboard' => route('clube.dashboard'),
    'Configurações' => null
]">
    <div class="w-full h-full flex flex-col gap-4 border border-2 border-gray-200 rounded-lg p-4">
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-4">
                {{-- espaço reservado caso queira colocar algo acima depois --}}
            </div>
        </div>

        {{-- SEÇÃO: CONTA --}}
        <div class="flex flex-col gap-4">
            <span class="text-lg text-emerald-700 font-semibold">
                Conta
            </span>

            <div class="flex flex-col gap-4">
                {{-- ALTERAR CNPJ --}}
                <div
                    class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3"
                    onclick="openModal('update-cnpj')"
                >
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-icon lucide-file"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-[0.73vw] text-emerald-500 font-medium">
                                Alterar CNPJ
                            </h3>

                            <h4 class="text-[0.63vw] text-emerald-600/80 font-normal">
                                Altere o CNPJ
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                {{-- ALTERAR EMAIL --}}
                <div
                    class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3"
                    onclick="openModal('update-email')"
                >
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail-icon lucide-mail"><path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"/><rect x="2" y="4" width="20" height="16" rx="2"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-[0.73vw] text-emerald-500 font-medium">
                                Alterar email
                            </h3>

                            <h4 class="text-[0.63vw] text-emerald-600/80 font-normal">
                                Altere o email
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                {{-- ALTERAR SENHA --}}
                <div
                    class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3"
                    onclick="openModal('update-password')"
                >
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock-icon lucide-lock"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-[0.73vw] text-emerald-500 font-medium">
                                Alterar senha
                            </h3>

                            <h4 class="text-[0.63vw] text-emerald-600/80 font-normal">
                                Altere sua senha
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                {{-- EXCLUIR CONTA --}}
                <div
                    class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3"
                    onclick="openModal('delete-account')"
                >
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-icon lucide-trash"><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-[0.73vw] text-red-500 font-medium">
                                Excluir conta
                            </h3>

                            <h4 class="text-[0.63vw] text-red-600/80 font-normal">
                                Exclua sua conta
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </div>
        </div>

        {{-- SEÇÃO: SOBRE --}}
        <div class="flex flex-col gap-4">
            <span class="text-lg text-emerald-700 font-semibold">
                Sobre
            </span>

            <div class="flex flex-col gap-4">
                {{-- TERMOS E CONDIÇÕES --}}
                <div
                    class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3"
                    onclick="openModal('terms-modal')"
                >
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-paperclip-icon lucide-paperclip"><path d="m16 6-8.414 8.586a2 2 0 0 0 2.829 2.829l8.414-8.586a4 4 0 1 0-5.657-5.657l-8.379 8.551a6 6 0 1 0 8.485 8.485l8.379-8.551"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-[0.73vw] text-emerald-500 font-medium">
                                Termos e condições
                            </h3>

                            <h4 class="text-[0.63vw] text-emerald-600/80 font-normal">
                                Veja os termos e condições
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>

                {{-- POLÍTICAS DE PRIVACIDADE --}}
                <div
                    class="flex items-center justify-between cursor-pointer w-full rounded-lg h-[3.75rem] bg-white hover:bg-gray-50 transition-colors p-3"
                    onclick="openModal('privacy-modal')"
                >
                    <div class="h-full flex items-center gap-x-2">
                        <div class="h-full aspect-square flex items-center justify-center">
                            <svg class="h-5 w-5 text-emerald-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-lock-icon lucide-file-lock"><path d="M4 9.8V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.706.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2h-3"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><path d="M9 17v-2a2 2 0 0 0-4 0v2"/><rect width="8" height="5" x="3" y="17" rx="1"/></svg>
                        </div>

                        <div class="h-full flex flex-col justify-between">
                            <h3 class="text-[0.73vw] text-emerald-500 font-medium">
                                Políticas de privacidade
                            </h3>

                            <h4 class="text-[0.63vw] text-emerald-600/80 font-normal">
                                Veja as politicas de privacidade
                            </h4>
                        </div>
                    </div>

                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right-icon lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAIS --}}

    <x-modal maxWidth="xl" name="update-cnpj" title="Alterar CNPJ" titleSize="2xl" titleColor="emerald">
    <x-form id="form-update-cnpj" class="flex flex-col gap-[0.42vw]">
        @csrf

        {{-- CNPJ atual (somente leitura, sem name para não ir no payload) --}}
        <x-form-group
            label="CNPJ atual"
            name="current_cnpj"
            id="clube-cnpj-atual"
            labelColor="emerald"
            textSize="xl"
            value="{{ auth('club')->user()->cnpjClube ?? '' }}"
            readonly
        >
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <path d="M7 8h10"/>
                    <path d="M7 12h4"/>
                    <path d="M7 16h4"/>
                </svg>
            </x-slot:icon>

            <x-slot:input>
                <input
                    type="text"
                    id="clube-cnpj-atual"
                    class="w-full border-none bg-transparent text-sm focus:outline-none focus:ring-0"
                    value="{{ auth('club')->user()->cnpjClube ?? '' }}"
                    readonly
                >
            </x-slot:input>
        </x-form-group>

        {{-- Novo CNPJ (único que vai pro back) --}}
        <x-form-group
            label="Novo CNPJ"
            name="new_cnpj"
            id="clube-cnpj-novo"
            labelColor="emerald"
            textSize="xl"
            required
        >
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <path d="M7 8h10"/>
                    <path d="M7 12h6"/>
                    <path d="M7 16h6"/>
                </svg>
            </x-slot:icon>
        </x-form-group>
    </x-form>

    <x-slot:footer>
        <div class="w-full flex gap-x-[0.42vw] justify-end">
            <x-button color="gray" size="md" onclick="closeModal('update-cnpj')">
                Cancelar
            </x-button>

            <x-button color="clube" size="md" onclick="submitUpdateCnpj('form-update-cnpj')">
                Salvar
            </x-button>
        </div>
    </x-slot:footer>
</x-modal>

    {{-- ALTERAR EMAIL --}}
<x-modal maxWidth="xl" name="update-email" title="Alterar Email" titleSize="2xl" titleColor="emerald">
    <x-form id="form-update-email" class="flex flex-col gap-[0.42vw]">
        @csrf

        {{-- Email atual (somente leitura, sem name) --}}
        <x-form-group
    label="Email atual"
    type="email"
    name="current_email"
    id="clube-email-atual"
    labelColor="emerald"
    textSize="xl"
    value="{{ auth('club')->user()->emailClube ?? '' }}"
    readonly
>
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <polyline points="4 6 12 13 20 6"/>
                </svg>
            </x-slot:icon>

            <x-slot:input>
                <input
                    type="email"
                    id="clube-email-atual"
                    class="w-full border-none bg-transparent text-sm focus:outline-none focus:ring-0"
                    value="{{ auth('club')->user()->emailClube ?? '' }}"
                    readonly
                >
            </x-slot:input>
        </x-form-group>

        {{-- Novo email (único que vai pro back) --}}
        <x-form-group
            label="Novo email"
            type="email"
            name="new_email"
            id="clube-email-novo"
            labelColor="emerald"
            textSize="xl"
            required
        >
            <x-slot:icon>
                <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="16" rx="2"/>
                    <polyline points="4 6 12 13 20 6"/>
                    <path d="M7 16h10"/>
                </svg>
            </x-slot:icon>
        </x-form-group>
    </x-form>

    <x-slot:footer>
        <div class="w-full flex gap-x-[0.42vw] justify-end">
            <x-button color="gray" size="md" onclick="closeModal('update-email')">
                Cancelar
            </x-button>

            <x-button color="clube" size="md" onclick="submitUpdateEmail('form-update-email')">
                Salvar
            </x-button>
        </div>
    </x-slot:footer>
</x-modal>

    {{-- ALTERAR SENHA --}}
    <x-modal maxWidth="xl" name="update-password" title="Alterar Senha" titleSize="2xl" titleColor="emerald">
        <x-form id="form-update-password" class="flex flex-col gap-[0.42vw]">
            @csrf

            <x-form-group
                label="Senha atual"
                type="password"
                name="current_password"
                id="clube-senha-atual"
                labelColor="emerald"
                textSize="xl"
                required
            >
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="10" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                </x-slot:icon>
            </x-form-group>

            <x-form-group
                label="Nova senha"
                type="password"
                name="password"
                id="clube-senha-nova"
                labelColor="emerald"
                textSize="xl"
                required
            >
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="10" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        <path d="M12 15v2"/>
                    </svg>
                </x-slot:icon>
            </x-form-group>

            <x-form-group
                label="Confirmar nova senha"
                type="password"
                name="password_confirmation"
                id="clube-senha-confirmacao"
                labelColor="emerald"
                textSize="xl"
                required
            >
                <x-slot:icon>
                    <svg class="h-[0.83vw] w-[0.83vw]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="10" rx="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        <polyline points="9 16 11 18 15 14"/>
                    </svg>
                </x-slot:icon>
            </x-form-group>
        </x-form>

        <x-slot:footer>
            <div class="w-full flex gap-x-[0.42vw] justify-end">
                <x-button color="gray" size="md" onclick="closeModal('update-password')">
                    Cancelar
                </x-button>

                <x-button color="clube" size="md" onclick="submitUpdatePassword('form-update-password')">
                    Salvar
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    {{-- EXCLUIR CONTA --}}
    <x-modal maxWidth="xl" name="delete-account" title="Excluir conta" titleSize="2xl" titleColor="red">
        <div class="flex flex-col items-center justify-center gap-[0.83vw] py-[1.25vw]">
            <div class="h-[3vw] w-[3vw] rounded-full border border-red-300 flex items-center justify-center">
                <svg class="h-[1.5vw] w-[1.5vw] text-red-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                     stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                    <path d="M10 11v6"/>
                    <path d="M14 11v6"/>
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
            </div>

            <p class="text-lg font-semibold text-red-600">
                Você deseja excluir sua conta?
            </p>

            <p class="text-xs text-gray-500">
                Essa ação é irreversível.
            </p>
        </div>

        <x-slot:footer>
            <div class="w-full flex gap-x-[0.42vw] justify-end">
                <x-button color="gray" size="md" onclick="closeModal('delete-account')">
                    Cancelar
                </x-button>

                <x-button color="red" size="md" onclick="submitDeleteAccount()">
                    Excluir conta
                </x-button>
            </div>
        </x-slot:footer>
    </x-modal>

    {{-- TERMOS E CONDIÇÕES --}}
    {{-- TERMOS E CONDIÇÕES --}}
<x-modal maxWidth="xl" name="terms-modal" title="Termos e Condições" titleSize="2xl" titleColor="emerald">
    <div class="max-h-[60vh] overflow-y-auto pr-[0.42vw] text-sm leading-relaxed">
        <h3 class="font-semibold text-base mb-[0.83vw]">
            Termos e Condições de Uso – Perfil de Campeão
        </h3>

        <pre class="whitespace-pre-wrap text-justify leading-relaxed text-base">
TERMOS E CONDIÇÕES DE USO – PERFIL DE CAMPEÃO

Os presentes Termos e Condições regulam o uso da plataforma Perfil de Campeão, disponibilizada nas versões mobile e web pela Norven. Ao acessar ou utilizar o sistema, o usuário declara ter lido, compreendido e concordado com todas as regras aqui estabelecidas.


---

1. Aceitação dos Termos

O uso da plataforma implica concordância integral com estes Termos. Caso o usuário não concorde com alguma cláusula, deverá interromper o uso imediatamente.


---

2. Objetivo da Plataforma

O Perfil de Campeão tem como finalidade conectar jovens atletas a clubes, permitindo a criação de perfis esportivos, publicação de conteúdos e interação entre usuários.

A plataforma não garante contratação, testes ou convites esportivos, apenas facilita a visibilidade e conexão entre as partes.


---

3. Cadastro e Conta do Usuário

Para utilizar o sistema, o usuário deve fornecer informações verdadeiras e atualizadas.
É proibido criar perfis falsos, duplicados ou usar dados de terceiros sem autorização.

Responsabilidades do usuário:

Manter a confidencialidade da senha

Não compartilhar acesso com terceiros

Informar imediatamente qualquer uso indevido da conta


O Perfil de Campeão pode suspender ou excluir contas que violem estes Termos.


---

4. Conteúdo Publicado pelo Usuário

O usuário é totalmente responsável pelos conteúdos enviados, incluindo fotos, vídeos, estatísticas e mensagens.

É proibido publicar:

Conteúdo ofensivo, discriminatório ou ilegal

Informações falsas ou enganosas

Material que infrinja direitos autorais ou de imagem

Conteúdos violentos, impróprios ou que desrespeitem terceiros


O Perfil de Campeão pode remover qualquer conteúdo que viole estes Termos sem aviso prévio.


---

5. Regras de Uso da Plataforma

O usuário concorda em NÃO:

Utilizar o sistema para fins ilegais

Tentar violar a segurança da plataforma

Copiar, modificar ou distribuir partes do sistema sem autorização

Usar bots, automações ou mecanismos de coleta de dados

Assediar, ameaçar ou prejudicar outros usuários

Utilizar o sistema para práticas comerciais não autorizadas



---

6. Conexão Entre Atletas e Clubes

A plataforma disponibiliza ferramentas de busca, visualização e interação.
O uso das informações encontradas deve respeitar:

A privacidade dos usuários

A legislação vigente

O propósito esportivo da plataforma


Conversas, convites ou negociações são de responsabilidade exclusiva entre as partes envolvidas.


---

7. Limitação de Responsabilidade

A Norven não se responsabiliza por:

Conteúdos publicados pelos usuários

Danos decorrentes de falhas de conexão, interrupções ou indisponibilidade da plataforma

Atos praticados por atletas, clubes ou terceiros

Expectativas de contratação, testes ou resultados esportivos


O sistema é oferecido “como está”, sem garantias de resultados específicos.


---

8. Suspensão e Exclusão da Conta

O Perfil de Campeão pode suspender ou excluir contas que:

violem estes Termos,

utilizem informações falsas,

pratiquem condutas suspeitas ou ilegais,

causem danos à plataforma ou a outros usuários.


A exclusão da conta pode ser feita também pelo próprio usuário.


---

9. Propriedade Intelectual

Todo o design, código, nome, marca, logo, interface e funcionalidades do Perfil de Campeão são de propriedade da Norven.

É proibido copiar, reproduzir, modificar ou distribuir qualquer parte da plataforma sem autorização formal.


---

10. Atualizações e Mudanças nos Termos

Os Termos podem ser atualizados periodicamente. Alterações importantes serão comunicadas dentro da plataforma.

O uso continuado após a atualização indica concordância com as novas condições.


---

11. Legislação Aplicável

Este documento é regido pelas leis brasileiras, incluindo o Código Civil, Marco Civil da Internet e LGPD.

Qualquer conflito será resolvido no foro da comarca de São Paulo – SP.


---

12. Contato

Para dúvidas ou solicitações relacionadas aos Termos:

E-mail de suporte: norven.suporte@empresa.com


---

Ao utilizar a plataforma Perfil de Campeão, o usuário declara concordar integralmente com estes Termos e Condições de Uso.
        </pre>
    </div>

    <x-slot:footer>
        <div class="w-full flex justify-end">
            <x-button color="clube" size="md" onclick="closeModal('terms-modal')">
                Fechar
            </x-button>
        </div>
    </x-slot:footer>
</x-modal>


   {{-- POLÍTICAS DE PRIVACIDADE --}}
<x-modal maxWidth="xl" name="privacy-modal" title="Políticas de Privacidade" titleSize="2xl" titleColor="emerald">
    <div class="max-h-[60vh] overflow-y-auto pr-[0.42vw] text-sm leading-relaxed">
        <h3 class="font-semibold text-base mb-[0.83vw]">
            Política de Privacidade – Perfil de Campeão
        </h3>

        <pre class="whitespace-pre-wrap text-justify leading-relaxed text-base">
POLÍTICA DE PRIVACIDADE – PERFIL DE CAMPEÃO

A presente Política de Privacidade estabelece como o Perfil de Campeão, desenvolvido pela Norven, coleta, utiliza, armazena, compartilha e protege os dados pessoais dos usuários de sua plataforma mobile e web. O uso do sistema implica plena concordância com as práticas aqui descritas.


---

1. Coleta de Informações

Coletamos diferentes tipos de dados para garantir o funcionamento adequado da plataforma:

1.1 Dados fornecidos pelo usuário:

Nome completo

E-mail

Senha (criptografada)

Data de nascimento

Foto de perfil

Informações esportivas (modalidade, posição, estatísticas, histórico)

Dados de clubes (razão social, CNPJ, localização, contatos)


1.2 Dados coletados automaticamente:

Endereço IP

Informações de dispositivo e sistema operacional

Cookies e identificadores únicos

Dados de navegação e interações dentro do aplicativo e site

Registros de acesso


1.3 Conteúdos enviados pelo usuário:

Postagens, vídeos, fotos, mensagens e demais informações publicadas no perfil.



---

2. Uso das Informações

As informações coletadas são utilizadas para:

Criar e gerenciar contas de usuários (atletas e clubes)

Permitir buscas e conexões entre atletas e clubes

Exibir o perfil esportivo ao público permitido

Melhorar a experiência de uso e personalizar funcionalidades

Garantir segurança, monitoramento e prevenção de fraudes

Cumprir obrigações legais e regulatórias

Realizar análises internas de desempenho e usabilidade



---

3. Compartilhamento de Informações

Os dados dos usuários não são vendidos. O compartilhamento pode ocorrer nas seguintes situações:

Com clubes registrados, quando o atleta escolhe tornar seu perfil público

Com serviços de hospedagem, segurança e infraestrutura tecnológica

Com autoridades, mediante obrigação legal ou ordem judicial

Em casos de prevenção a fraudes ou ameaças à segurança


Apenas o mínimo necessário de dados é compartilhado.


---

4. Armazenamento e Proteção dos Dados

Utilizamos medidas técnicas e administrativas para proteger os dados, incluindo:

Criptografia de senhas

Servidores seguros

Comunicação criptografada (HTTPS)

Controles de acesso

Monitoramento e auditorias internas


Os dados são armazenados pelo tempo necessário às finalidades propostas ou conforme exigência legal.


---

5. Direitos do Usuário (LGPD)

O usuário pode, a qualquer momento:

Confirmar a existência de tratamento de dados

Solicitar acesso, correção ou atualização

Solicitar exclusão de dados ou da conta

Solicitar portabilidade

Solicitar anonimização

Revogar consentimento

Receber informações sobre compartilhamentos realizados


Solicitações podem ser feitas pelo canal de suporte do Perfil de Campeão.


---

6. Exclusão da Conta e Dados

Ao solicitar a exclusão:

Dados pessoais são permanentemente removidos

Conteúdos podem ser anonimizados por motivos de integridade do sistema

Alguns dados podem ser retidos para cumprimento de obrigações legais



---

7. Uso por Menores de Idade

O uso por menores de 13 anos exige autorização expressa de um responsável.

Para adolescentes entre 13 e 18 anos, recomenda-se supervisão.



---

8. Cookies e Tecnologias de Rastreamento

Utilizamos cookies e tecnologias similares para:

Lembrar preferências do usuário

Garantir funcionalidades essenciais

Realizar análises de desempenho

Melhorar a usabilidade


O usuário pode desativar cookies no navegador, mas algumas funções poderão ser afetadas.


---

9. Alterações na Política

A Política de Privacidade poderá ser atualizada quando necessário. Alterações relevantes serão comunicadas dentro da plataforma.


---

10. Contato

Para dúvidas, solicitações ou exercício dos direitos do titular de dados:

E-mail de suporte: norven.suporte@empresa.com


---

Ao utilizar a plataforma Perfil de Campeão, o usuário concorda com esta Política de Privacidade.
        </pre>
    </div>

    <x-slot:footer>
        <div class="w-full flex justify-end">
            <x-button color="clube" size="md" onclick="closeModal('privacy-modal')">
                Fechar
            </x-button>
        </div>
    </x-slot:footer>
</x-modal>


    @push('scripts')
        <script>
            const csrfTokenConfig = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            function ensureToastContainer() {
                let container = document.getElementById('toast-container');

                if (!container) {
                    container = document.createElement('div');
                    container.id = 'toast-container';
                    container.className = 'fixed top-4 right-4 flex flex-col items-end space-y-2';
                    // força z-index alto, independente do que tiver no modal
                    container.style.zIndex = '99999';
                    document.body.appendChild(container);
                } else {
                    // se já existe, garante o zIndex alto mesmo assim
                    container.style.zIndex = '99999';
                }

                return container;
            }


            function showToastSafe(message, type = 'success') {
    const container = ensureToastContainer();

    // mensagem padrão caso venha undefined/null
    const finalMessage =
        message || (type === 'error'
            ? 'Ocorreu um erro. Tente novamente.'
            : 'Alterado com sucesso.');

   if (window.showToast) {
        try {
            // title, description, type (description vazio pra não aparecer "undefined")
            window.showToast(type, '', finalMessage);
            return;
        } catch (e) {
            console.error('Erro no showToast global, usando fallback.', e);
        }
    }

    // fallback simples
    const toast = document.createElement('div');
    toast.className =
        'mb-2 rounded-md px-4 py-2 text-sm text-white ' +
        (type === 'error' ? 'bg-red-600' : 'bg-emerald-600');
    toast.textContent = finalMessage;

    container.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}

            async function submitUpdateCnpj(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    const payload = {
        new_cnpj: form.new_cnpj.value,
    };

    try {
        const response = await fetch("{{ url('/api/clube/cnpj') }}", {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfTokenConfig,
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        });

        const data = await response.json().catch(() => ({}));

        if (!response.ok) {
            if (data.errors) {
                const firstField = Object.keys(data.errors)[0];
                const firstMsg = data.errors[firstField][0];
                showToastSafe(firstMsg || 'Erro ao atualizar CNPJ.', 'error');
            } else {
                const message = data.message || 'Erro ao atualizar CNPJ.';
                showToastSafe(message, 'error');
            }
            return;
        }

        showToastSafe(data.message || 'CNPJ atualizado com sucesso.', 'success');
        closeModal('update-cnpj');
        form.new_cnpj.value = '';
    } catch (error) {
        console.error(error);
        showToastSafe('Erro inesperado ao atualizar CNPJ.', 'error');
    }
}

async function submitUpdateEmail(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    const payload = {
        new_email: form.new_email.value,
    };

    try {
        const response = await fetch("{{ url('/api/clube/email') }}", {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfTokenConfig,
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        });

        const data = await response.json().catch(() => ({}));

        if (!response.ok) {
            console.log('Erro ao atualizar email (response 4xx):', data);

            if (data.errors) {
                const firstField = Object.keys(data.errors)[0];
                const firstMsg = data.errors[firstField][0];
                showToastSafe(firstMsg || 'Erro ao atualizar email.', 'error');
            } else {
                const message = data.message || 'Erro ao atualizar email.';
                showToastSafe(message, 'error');
            }

            return;
        }

        showToastSafe(data.message || 'Email atualizado com sucesso.', 'success');
        closeModal('update-email');
        form.new_email.value = '';
    } catch (error) {
        console.error('Erro inesperado ao atualizar email:', error);
        showToastSafe('Erro inesperado ao atualizar email.', 'error');
    }
}

            async function submitUpdatePassword(formId) {
                const form = document.getElementById(formId);
                if (!form) return;

                const payload = {
                    current_password: form.current_password.value,
                    password: form.password.value,
                    password_confirmation: form.password_confirmation.value,
                };

                try {
                    const response = await fetch("{{ url('/api/clube/senha') }}", {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfTokenConfig,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(payload),
                    });

                    const data = await response.json().catch(() => ({}));

                    if (!response.ok) {
                        const message = data.message || 'Erro ao atualizar senha.';
                        showToastSafe(message, 'error');
                        return;
                    }

                    showToastSafe(data.message || 'Senha atualizada com sucesso.', 'success');
                    closeModal('update-password');

                    // limpa os campos
                    form.current_password.value = '';
                    form.password.value = '';
                    form.password_confirmation.value = '';
                } catch (error) {
                    console.error(error);
                    showToastSafe('Erro inesperado ao atualizar senha.', 'error');
                }
            }

            async function submitDeleteAccount() {
                if (!confirm('Tem certeza que deseja excluir sua conta?')) {
                    return;
                }

                try {
                    const response = await fetch("{{ url('/api/clube/conta') }}", {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': csrfTokenConfig,
                            'Accept': 'application/json',
                        },
                    });

                    if (response.status === 204) {
                        showToastSafe('Conta excluída com sucesso.', 'success');
                        // redireciona para a tela de login do clube (ajuste se o nome da rota for diferente)
                        window.location.href = "{{ route('clube.login') }}";
                        return;
                    }

                    const data = await response.json().catch(() => ({}));
                    const message = data.message || data.error || 'Erro ao excluir conta.';
                    showToastSafe(message, 'error');
                } catch (error) {
                    console.error(error);
                    showToastSafe('Erro inesperado ao excluir conta.', 'error');
                }
            }
        </script>
    @endpush
</x-layouts.clube>
