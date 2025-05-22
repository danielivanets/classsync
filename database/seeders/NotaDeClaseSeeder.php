<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\Asignatura;
use App\Models\User;
use App\Models\NotaDeClase;

class NotaDeClaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $asignaturas = Asignatura::all();
        $profesores = User::role('Profesor')->get();

        // Verificamos que haya profesores disponibles
        if ($profesores->isEmpty()) {
            $this->command->warn('No hay usuarios con rol "Profesor". Seeder NotaDeClase detenido.');
            return;
        }

        // Horarios por defecto si no existen horarios reales
        $defaultHoraInicio = '08:00';
        $defaultHoraFin = '08:55';

        foreach ($asignaturas as $asignatura) {
            // Obtener horarios visibles asociados a la asignatura
            $horarios = method_exists($asignatura, 'horarios')
                ? $asignatura->horarios()->visible()->get()
                : collect(); // vacío si no tiene relación

            for ($i = 0; $i < 5; $i++) {
                $fecha = Carbon::now()->subDays(rand(1, 30));

                // Selección de hora
                if ($horarios->isNotEmpty()) {
                    $horario = $horarios->random();
                    $horaInicio = $horario->hora_inicio;
                    $horaFin = $horario->hora_fin;
                } else {
                    $horaInicio = $defaultHoraInicio;
                    $horaFin = $defaultHoraFin;
                }

                NotaDeClase::create([
                    'fecha' => $fecha->toDateString(),
                    'hora_inicio' => $horaInicio,
                    'hora_fin' => $horaFin,
                    'contenido' => $faker->paragraph(),
                    'tema' => $faker->sentence(),
                    'observaciones' => $faker->optional()->sentence(),
                    'usuario_id' => $asignatura->usuario_id ?: $profesores->random()->id,
                    'asignatura_id' => $asignatura->id,
                    'visible' => true,
                ]);
            }
        }
    }
}
