<x-layouts.form title="Login" class="p-8">
    <x-slot name="left">
        <div class="w-full h-full flex items-center justify-center">
            <x-form-card title="Bem vindo de volta" description="Informe seu CNPJ e Senha para acessar a plataforma" color="green">
                <x-form class="w-full flex flex-col gap-4">
                    <x-form-group label="CNPJ" name="cnpjClube" type="text" labelColor="green">
                        <x-slot:icon>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-id-card-icon lucide-id-card"><path d="M16 10h2"/><path d="M16 14h2"/><path d="M6.17 15a3 3 0 0 1 5.66 0"/><circle cx="9" cy="11" r="2"/><rect x="2" y="5" width="20" height="14" rx="2"/></svg>
                        </x-slot:icon>
                    </x-form-group>

                    <x-form-group label="Senha" name="senhaClube" type="password" labelColor="green">

                    </x-form-group>

                    <div class="flex justify-between">
                        <x-checkbox color="green" label="Lembrar de mim"/>

                        <a href="" class="text-md font-medium text-emerald-600/70 underline">
                            Esqueceu sua senha?
                        </a>
                    </div>

                    <x-slot:actions>
                        <x-button type="submit" color="clube" size="xl" :full="true">
                            Entrar
                        </x-button>
                    </x-slot:actions>

                    <x-slot:link>
                        <span class="inline-flex gap-x-1">
                            <span class="text-gray-600 font-medium text-md">
                                Não tem uma conta ainda?
                            </span>

                            <a href="" class="text-emerald-500 font-medium text-md">
                                Cadastrar-se
                            </a>
                        </span>
                    </x-slot:link>
                </x-form>
            </x-form-card>
        </div>
    </x-slot>

    <x-slot name="right">
        <div class="relative w-full h-full rounded-3xl overflow-hidden">
            <img src="{{ asset('img/login-clube-img.jpg') }}" class="w-full h-full object-cover" alt="" />

            <div class="absolute bottom-8 left-8 right-8 flex flex-col gap-4">
                <h1 class="text-white text-4xl font-semibold tracking-tight">
                    O jogo começa aqui.
                </h1>

                <h2 class="text-white text-xl font-medium tracking-tight">
                    Junte-se à plataforma que está revolucionando a forma como clubes e atletas se conectam.
                </h2>
            </div>

            <div class="absolute top-8 right-8 bg-black/40 rounded-[2.5rem] p-4">
                <p class="text-white text-lg font-normal">
                    Transforme potencial em vitória.
                </p>
            </div>
        </div>
    </x-slot>
</x-layouts.form>