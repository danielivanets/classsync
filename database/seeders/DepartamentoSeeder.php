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
            'Informatica',
            'Matematicas',
            'Fisica',
            'Biologia',
            'Historia',
            'Lenguas',
            'Economia',
            'Arquitectura',
        ];

        foreach ($departamentos as $nombre) {
            Departamento::firstOrCreate(['nombre' => $nombre]);
        }
    }
}
