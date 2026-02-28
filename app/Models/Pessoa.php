<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pessoa extends Model
{
    // 'image_path' permitir o salvamento da imagem
    protected $fillable = ['name', 'birth', 'idade', 'gender', 'image_path'];

    // 2. Adicione 'age' para que ela apareça sempre que você carregar o modelo
    protected $appends = ['image', 'age'];

    public function getImageAttribute()
    {
        // 3. Lógica Prioritária: Se tiver foto da câmera, use ela!
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }

        // 4. se não, mantém o sorteio do Pravatar
        $homens = [3, 6, 7, 8, 11, 12, 13, 14, 15, 17, 18, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 64, 65, 66, 67, 68, 69, 70];
        $mulheres = [19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49];

        $imgNumber = $this->gender === 'masculino' ? $homens[array_rand($homens)] : $mulheres[array_rand($mulheres)];

        return "https://i.pravatar.cc/300?img={$imgNumber}";
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth)->age;
    }
}
