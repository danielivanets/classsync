<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aula;
use App\Models\Asignatura;
use App\Models\Horario;
use Illuminate\Support\Arr;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        $horas = [
            ['08:00', '08:55'],
            ['08:55', '09:50'],
            ['09:50', '10:45'],
            ['11:15', '12:10'],
            ['12:10', '13:05'],
            ['13:05', '14:00'],
        ];

        $aulas = Aula::visible()->pluck('id')->toArray(); // Solo aulas visibles
        $asignaturas = Asignatura::visible()->get();

        foreach ($asignaturas as $asignatura) {
            $diasUsados = [];

            for ($i = 0; $i < 3; $i++) { // 3 clases por asignatura
                $dia = Arr::random(array_diff($dias, $diasUsados));
                $diasUsados[] = $dia;

                $hora = Arr::random($horas);
                $aulaId = Arr::random($aulas);

                Horario::create([
                    'dia' => $dia,
                    'hora_inicio' => $hora[0],
                    'hora_fin' => $hora[1],
                    'asignatura_id' => $asignatura->id,
                    'aula_id' => $aulaId,
                    'visible' => true,
                ]);
            }
        }
    }

    
}
