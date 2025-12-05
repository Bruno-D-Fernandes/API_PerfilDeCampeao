<x-layouts.form title="Login" class="p-8">
    <x-slot name="left">
        <div id="toast-container" class="fixed top-[0.83vw] left-[0.83vw] z-50 flex flex-col gap-[0.42vw]"></div>
        
        <div class="w-full h-full flex items-center justify-center">
            <x-form-card title="Bem vindo de volta" description="Informe seu CNPJ e Senha para acessar a plataforma" color="blue">
                <x-slot:logo>
                    <div class="flex items-center gap-x-[0.42vw] h-[3.33vw]">
                        <img src="{{ asset('img/logo-admin.png') }}" alt="" class="h-full object-fit">

                        <span class="text-[1.13vw] font-semibold text-sky-600 tracking-tight">
                            Perfil de Campeão
                        </span>
                    </div>
                </x-slot:logo>

                <x-form method="POST" id="login-form-adm" action="{{ route('admin.login.submit') }}" class="w-full flex flex-col gap-[0.83vw]">
                    @csrf                    
                    <x-form-group label="Email" name="email" type="text" labelColor="blue">
                        <x-slot:icon>
                            <svg class="h-[1.04vw] w-[1.04vw]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-id-card-icon lucide-id-card"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg>
                        </x-slot:icon>
                    </x-form-group>

                    <x-form-group label="Senha" name="password" type="password" labelColor="blue">

                    </x-form-group>

                    <x-checkbox color="blue" label="Lembrar de mim"/>

                    <x-slot:actions>
                        <x-button type="submit" color="admin" size="xl" :full="true">
                            Entrar
                        </x-button>
                    </x-slot:actions>
                </x-form>
            </x-form-card>
        </div>
    </x-slot>

    <x-slot name="right">
        <div class="relative w-full h-full rounded-[1vw] overflow-hidden">
            <img src="{{ asset('img/login-admin-img.jpg') }}" class="w-full h-full object-cover" alt="" />

            <div class="absolute bottom-[1.67vw] left-[1.67vw] right-[1.67vw] flex flex-col gap-[0.83vw]">
                <h1 class="text-white text-[1.53vw] font-semibold tracking-tight">
                    Controle absoluto.
                </h1>

                <h2 class="text-white text-[1.03vw] font-medium tracking-tight">
                    O núcleo estratégico para gestão de clubes, atletas e métricas da plataforma.
                </h2>
            </div>

            <div class="absolute top-[1.67vw] right-[1.67vw] bg-black/40 rounded-[0.5vw] p-[0.83vw]">
                <p class="text-white text-[0.93vw] font-normal">
                    Acesso restrito.
                </p>
            </div>
        </div>
    </x-slot>
</x-layouts.form>