<x-layouts.form title="Login" class="p-8">
    <x-slot name="left">
        
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

            <div class="absolute top-8 right-8 bg-black/20 rounded-[2.5rem] p-4">
                <p class="text-white text-lg font-normal">
                    Transforme potencial em vitória.
                </p>
            </div>
        </div>
    </x-slot>
</x-layouts.form>