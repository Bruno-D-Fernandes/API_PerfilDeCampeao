<x-layouts.clube title="Pesquisa" :breadcrumb="[
    'Dashboard' => route('admin-clubes'),
    'Pesquisa' => null,
]">
    <div class="flex gap-6 w-full h-[calc(100vh-11rem)]">
        <div class="flex flex-col justify-between gap-2 bg-emerald-500 h-full w-1/4 rounded-lg p-6">
            <x-search-input placeholder="Buscar por nome" />

            <div class="w-full border border-t border-white/20 mt-0.5"></div>

            <div class="flex flex-col gap-2 max-h-full overflow-y-auto scrollbar-custom pr-4">
                <x-form-group label="Modalidade" name="qualquerumai" type="select" id="oquesobraprobeta" labelColor="white">
                    <option>
                        Futebol
                    </option>

                    <option>
                        Basquete
                    </option>

                    <option>
                        Vôlei
                    </option>

                    <option>
                        Tênis de Mesa
                    </option>

                    <option>
                        Natação
                    </option>
                </x-form-group>

                <x-form-group label="Posição" name="qualquerumai" type="select" id="oquesobraprobeta" labelColor="white">
                    <option>
                        Zagueiro
                    </option>

                    <option>
                        Lateral
                    </option>

                    <option>
                        Meia
                    </option>

                    <option>
                        Goleiro
                    </option>

                    <option>
                        Atacante
                    </option>
                </x-form-group>

                <div class="px-2.5">
                    <x-range-slider label="Idade" nameMin="idade_menor" nameMax="idade_maior" :min="14" :max="18" :step="1" unit="anos" id="podeseroquevocequiser" color="white"></x-range-slider>

                    <x-range-slider label="Altura" nameMin="altura_menor" nameMax="altura_maior" :min="50" :max="240" :step="1" unit="cm" id="podeseroquevocequiser1" color="white"></x-range-slider>

                    <x-range-slider label="Peso" nameMin="peso_menor" nameMax="peso_maior" :min="40" :max="200" :step="1" unit="kg" id="podeseroquevocequiser2" color="white"></x-range-slider>
                </div>

                <div class="flex flex-col gap-2">
                    <h3 class="block text-md font-medium text-white">
                        Pé dominante
                    </h3>

                    <div class="flex items-center justify-center gap-x-4">
                        <x-radio name="itookapillinibiza" label="Destro" id="obrigado" value="ty" color="white" />

                        <x-radio name="itookapillinibiza2" label="Canhoto" id="obrigado1" value="ty" color="white" />
                    </div>
                </div>

                <x-form-group label="Estado" name="qualquerumai" type="select" id="oquesobraprobeta" labelColor="white">
                    <option>
                        Zagueiro
                    </option>

                    <option>
                        Lateral
                    </option>

                    <option>
                        Meia
                    </option>

                    <option>
                        Goleiro
                    </option>

                    <option>
                        Atacante
                    </option>
                </x-form-group>

                <x-form-group label="Cidade" name="qualquerumai" type="select" id="oquesobraprobeta" labelColor="white">
                    <option>
                        Zagueiro
                    </option>

                    <option>
                        Lateral
                    </option>

                    <option>
                        Meia
                    </option>

                    <option>
                        Goleiro
                    </option>

                    <option>
                        Atacante
                    </option>
                </x-form-group>
            </div>

            <div class="w-full border border-t border-white/20 mt-0.5"></div>

            <div class="flex gap-x-4 mt-1">
                <x-button color="none" :full="true" class="border-none bg-transparent    text-emerald-800">
                    Limpar
                </x-button>

                <x-button color="none" :full="true" class="border-none bg-white text-emerald-500">
                    Filtrar
                </x-button>
            </div>
        </div>

        <div class="flex flex-col gap-2 bg-white h-full w-3/4">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-medium text-gray-800">
                    30 atletas encontrados
                </h3>

                <div>
                    <x-select name="itpii" id="ibiz" class="pr-8">
                        <option>
                            Ordenar por
                        </option>
                    </x-select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <x-athlete-card :athlete="null" />
            </div>
        </div>
    </div>
</x-layouts.clube>