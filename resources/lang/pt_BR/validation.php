<?php

return [
    "required"                          => "O campo :attribute é obrigatório",
    "date"                              => "O campo :attribute precisa ser uma data válida",
    "string"                            => "O campo :attribute precisa ser um texto",
    "exists"                            => "O campo :attribute não existe no sistema",
    "after"                             => "O campo :attribute precisa ser uma data posterior a :date",
    "integer"                           => "O campo :attribute precisa ser um número inteiro",
    "unique"                            => "O campo :attribute precisa ser único",
    "decimal"                           => "O campo :attribute precisa ter entre :min e :max casas decimais",
    "required_without"                  => "O campo :attribute precisa ser informado quando :values não estiver presente",
    "required_without_all"              => "O campo :attribute precisa ser informado quando nenhum dos :values estão presentes",
    "email"                             => "O campo :attribute precisa ser um e-mail válido",
    "confirmed"                         => "O campo :attribute de confirmação não confere",
    "min"                               => [
        "numeric" => "O campo :attribute precisa ser no mínimo :min",
        "string" => "O campo :attribute precisa ter no mínimo :min caracteres",
    ],
    "max"                               => [
        "numeric" => "O campo :attribute precisa ser no máximo :max",
        "string" => "O campo :attribute precisa ter no máximo :max caracteres",
    ],
];
