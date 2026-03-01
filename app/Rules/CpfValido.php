<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CpfValido implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Tira tudo que não for número (pontos e traços)
        $cpf = preg_replace('/[^0-9]/is', '', $value);

        // 2. Verifica se tem 11 números ou se é uma sequência repetida (ex: 11111111111)
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            $fail('O CPF informado não é válido.');
            return;
        }

        // 3. Faz o cálculo matemático para validar os dois últimos dígitos
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $fail('O CPF informado não é válido.');
                return;
            }
        }
    }
}