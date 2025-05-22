<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departamento;
    
class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $departamentos = [
            'Informática',
            'Matemáticas',
            'Física',
            'Biología',
            'Historia',
            'Lenguas',
            'Economía',
            'Arquitectura',
        ];

        foreach ($departamentos as $nombre) {
            Departamento::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
