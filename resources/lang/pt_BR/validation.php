<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'email'    => 'Informe um e-mail válido.',
    'unique'   => 'O campo :attribute já está em uso.',
    'date'     => 'O campo :attribute deve ser uma data válida.',
    'string'   => 'O campo :attribute deve ser um texto.',
    'integer'  => 'O campo :attribute deve ser um número inteiro.',
    'min'      => [
        'numeric' => 'O campo :attribute deve ser no mínimo :min.',
    ],
    'max'      => [
        'string'  => 'O campo :attribute pode ter no máximo :max caracteres.',
        'numeric' => 'O campo :attribute deve ser no máximo :max.',
    ],
    'size'     => [
        'string'  => 'O campo :attribute deve ter exatamente :size caracteres.',
    ],
    'exists'   => 'O :attribute informado não foi encontrado.',
    'gte'      => 'O campo :attribute deve ser maior ou igual a :value.',

    // Nomes "bonitos" dos campos (ajuste conforme seus nomes)
    'attributes' => [
        // Oportunidades
        'descricaoOportunidades'    => 'descrição da oportunidade',
        'datapostagemOportunidades' => 'data de postagem',
        'esporte_id'                => 'esporte',
        'posicoes_id'               => 'posição',
        'idadeMinima'               => 'idade mínima',
        'idadeMaxima'               => 'idade máxima',
        'estadoOportunidade'        => 'UF',
        'cidadeOportunidade'        => 'cidade',
        'enderecoOportunidade'      => 'endereço',
        'cepOportunidade'           => 'CEP',

        // Usuário
        'nomeCompletoUsuario'       => 'nome completo',
        'emailUsuario'              => 'e-mail',
        'senhaUsuario'              => 'senha',
        'dataNascimentoUsuario'     => 'data de nascimento',
        'generoUsuario'             => 'gênero',
        'estadoUsuario'             => 'estado',
        'cidadeUsuario'             => 'cidade',
        'alturaCm'                  => 'altura (cm)',
        'pesoKg'                    => 'peso (kg)',
        'peDominante'               => 'pé dominante',
        'maoDominante'              => 'mão dominante',
    ],
];
