<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aula;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = [
            'ESO 1º',
            'ESO 2º',
            'ESO 3º',
            'ESO 4º',
            'Bachillerato 1º',
            'Bachillerato 2º',
            'FPB - Informática y Oficina',
            'GM - Gestión Administrativa 1º',
            'GM - Gestión Administrativa 2º',
            'GM - SMR 1º',
            'GM - SMR 2º',
            'GS - Administración y Finanzas 1º',
            'GS - Administración y Finanzas 2º',
            'GS - DAM 1º',
            'GS - DAM 2º',
        ];

        foreach ($cursos as $index => $curso) {
            // Generar número de aula: 001, 101, 201, etc.
            // Alternancia: primeras 5 empiezan con 0, siguientes con 1, últimas con 2
            $grupo = intdiv($index, 5); // 0, 1, 2 según el grupo
            $numeroAula = $grupo . str_pad(($index % 5) + 1, 2, '0', STR_PAD_LEFT); // 001, 102, 203, etc.

            Aula::create([
                'nombre'     => $numeroAula . ' - ' . $curso,
                'capacidad'  => rand(20, 35),
                'tipo'       => 'aula',
                'ubicacion'  => 'Planta ' . $grupo,
                'disponible' => true,
            ]);
        }
    }
}
