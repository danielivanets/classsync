<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Aula;
use App\Models\Asignatura;
use App\Models\Horario;
use Illuminate\Support\Arr;
use App\Models\Departamento;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*$dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
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
        }*/
        $cursosYAsignaturas = [
            'ESO 1º' => [ 'Lengua Castellana y Literatura', 'Matemáticas', 'Ciencias Sociales', 'Ciencias Naturales', 'Educación Física', 'Inglés', 'Tecnología', 'Música', 'Religión / Valores Éticos', 'Tutoría' ],
            'ESO 2º' => [ 'Lengua Castellana y Literatura', 'Matemáticas', 'Geografía e Historia', 'Física y Química', 'Biología y Geología', 'Educación Física', 'Inglés', 'Tecnología', 'Plástica', 'Religión / Valores Éticos', 'Tutoría' ],
            'ESO 3º' => [ 'Lengua Castellana y Literatura', 'Matemáticas', 'Física y Química', 'Biología y Geología', 'Educación Física', 'Inglés', 'Tecnología', 'Educación Plástica', 'Religión / Valores Éticos', 'Tutoría' ],
            'ESO 4º' => [ 'Lengua Castellana y Literatura', 'Matemáticas Académicas', 'Física y Química', 'Biología y Geología', 'Geografía e Historia', 'Educación Física', 'Inglés', 'Economía', 'Tecnología', 'Religión / Valores Éticos', 'Tutoría' ],
            'Bachillerato 1º' => [ 'Lengua Castellana y Literatura', 'Inglés', 'Filosofía', 'Matemáticas I', 'Historia del Mundo Contemporáneo', 'Economía', 'Tecnologías de la Información y la Comunicación', 'Educación Física', 'Tutoría' ],
            'Bachillerato 2º' => [ 'Lengua Castellana y Literatura', 'Inglés', 'Historia de España', 'Filosofía', 'Matemáticas II', 'Empresa y Diseño de Modelos de Negocio', 'TIC II', 'Tutoría' ],
            'FPB - Informática y Oficina' => [ 'Tratamiento de datos y hojas de cálculo', 'Redacción de documentos', 'Mantenimiento de equipos', 'Sistema operativo', 'Procesadores de textos', 'Comunicación empresarial', 'Formación y Orientación Laboral', 'Prácticas en empresa' ],
            'GM - Gestión Administrativa 1º' => [ 'Comunicación empresarial y atención al cliente', 'Operaciones administrativas de compra-venta', 'Empresa y administración', 'Tratamiento informático de la información', 'Técnica contable', 'Formación y orientación laboral', 'Inglés técnico' ],
            'GM - Gestión Administrativa 2º' => [ 'Operaciones auxiliares de gestión de tesorería', 'Gestión de recursos humanos', 'Contabilidad y fiscalidad', 'Empresa en el aula', 'Prácticas en empresa (FCT)' ],
            'GM - SMR 1º' => [ 'Montaje y mantenimiento de equipos', 'Aplicaciones ofimáticas', 'Redes locales', 'Sistemas operativos monopuesto', 'Formación y orientación laboral', 'Inglés técnico' ], //Sistemas Microinformáticos y Redes
            'GM - SMR 2º' => [ 'Sistemas operativos en red', 'Seguridad informática', 'Servicios en red', 'Aplicaciones web', 'Empresa e iniciativa emprendedora', 'Prácticas en empresa (FCT)' ],
            'GS - Administración y Finanzas 1º' => [ 'Gestión de la documentación jurídica y empresarial', 'Recursos humanos y responsabilidad social corporativa', 'Ofimática y proceso de la información', 'Proceso integral de la actividad comercial', 'Comunicación y atención al cliente', 'Inglés técnico', 'Formación y orientación laboral' ],
            'GS - Administración y Finanzas 2º' => [ 'Gestión financiera', 'Contabilidad y fiscalidad', 'Gestión logística y comercial', 'Simulación empresarial', 'Proyecto de administración y finanzas', 'Prácticas en empresa (FCT)' ],
            'GS - DAM 1º' => [ 'Sistemas informáticos', 'Bases de datos', 'Programación', 'Lenguajes de marcas y sistemas de gestión de información', 'Entornos de desarrollo', 'Formación y orientación laboral' ], //Grado Superior - Desarrollo de Aplicaciones Multiplataforma
            'GS - DAM 2º' => [ 'Acceso a datos', 'Desarrollo de interfaces', 'Programación multimedia y dispositivos móviles', 'Programación de servicios y procesos', 'Sistemas de gestión empresarial', 'Proyecto de DAM', 'Prácticas en empresa (FCT)' ],
        ];
        $departamentoPorAsignatura = [
            // Mapear asignaturas comunes a departamentos
            'Lengua Castellana y Literatura' => 'Lenguas',
            'Inglés' => 'Lenguas',
            'Filosofía' => 'Historia',
            'Geografía e Historia' => 'Historia',
            'Historia del Mundo Contemporáneo' => 'Historia',
            'Historia de España' => 'Historia',
            'Matemáticas' => 'Matemáticas',
            'Matemáticas I' => 'Matemáticas',
            'Matemáticas II' => 'Matemáticas',
            'Física y Química' => 'Física',
            'Biología y Geología' => 'Biología',
            'Economía' => 'Economía',
            'Empresa y Diseño de Modelos de Negocio' => 'Economía',
            'TIC II' => 'Informática',
            'Tecnologías de la Información y la Comunicación' => 'Informática',
            'Tratamiento de datos y hojas de cálculo' => 'Informática',
            'Redacción de documentos' => 'Lenguas',
            'Mantenimiento de equipos' => 'Informática',
            'Sistema operativo' => 'Informática',
            'Procesadores de textos' => 'Informática',
            'Comunicación empresarial' => 'Lenguas',
            'Formación y Orientación Laboral' => 'Economía',
            'Prácticas en empresa' => 'Economía',
            'Comunicación empresarial y atención al cliente' => 'Economía',
            'Operaciones administrativas de compra-venta' => 'Economía',
            'Empresa y administración' => 'Economía',
            'Tratamiento informático de la información' => 'Informática',
            'Técnica contable' => 'Economía',
            'Inglés técnico' => 'Lenguas',
            'Operaciones auxiliares de gestión de tesorería' => 'Economía',
            'Gestión de recursos humanos' => 'Economía',
            'Contabilidad y fiscalidad' => 'Economía',
            'Empresa en el aula' => 'Economía',
            'Montaje y mantenimiento de equipos' => 'Informática',
            'Aplicaciones ofimáticas' => 'Informática',
            'Redes locales' => 'Informática',
            'Sistemas operativos monopuesto' => 'Informática',
            'Sistemas operativos en red' => 'Informática',
            'Seguridad informática' => 'Informática',
            'Servicios en red' => 'Informática',
            'Aplicaciones web' => 'Informática',
            'Empresa e iniciativa emprendedora' => 'Economía',
            'Gestión de la documentación jurídica y empresarial' => 'Economía',
            'Recursos humanos y responsabilidad social corporativa' => 'Economía',
            'Ofimática y proceso de la información' => 'Informática',
            'Proceso integral de la actividad comercial' => 'Economía',
            'Comunicación y atención al cliente' => 'Lenguas',
            'Gestión financiera' => 'Economía',
            'Gestión logística y comercial' => 'Economía',
            'Simulación empresarial' => 'Economía',
            'Sistemas informáticos' => 'Informática',
            'Bases de datos' => 'Informática',
            'Programación' => 'Informática',
            'Lenguajes de marcas y sistemas de gestión de información' => 'Informática',
            'Entornos de desarrollo' => 'Informática',
            'Acceso a datos' => 'Informática',
            'Desarrollo de interfaces' => 'Informática',
            'Programación multimedia y dispositivos móviles' => 'Informática',
            'Programación de servicios y procesos' => 'Informática',
            'Sistemas de gestión empresarial' => 'Informática',
            'Proyecto de DAM' => 'Informática',
            'Tutoría' => 'Lenguas',
            'Educación Física' => 'Biología',
            'Tecnología' => 'Arquitectura',
            'Plástica' => 'Arquitectura',
            'Educación Plástica' => 'Arquitectura',
            'Música' => 'Lenguas',
            'Religión / Valores Éticos' => 'Historia',
        ];
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];
        $horas = [
            ['08:00', '08:55'],
            ['08:55', '09:50'],
            ['09:50', '10:45'],
            ['11:15', '12:10'],
            ['12:10', '13:05'],
            ['13:05', '14:00'],
        ];
        foreach ($cursosYAsignaturas as $curso => $asignaturas) {
            $aula = Aula::where('nombre', 'like', "%$curso%")->first();
            if (!$aula) continue;

            $asignaturaIds = [];
            foreach ($asignaturas as $nombreAsignatura) {
                $nombreDepartamento = $departamentoPorAsignatura[$nombreAsignatura] ?? 'Lenguas';
                $departamento = Departamento::where('nombre', $nombreDepartamento)->first();

                if (!$departamento) continue;

                $asignatura = Asignatura::firstOrCreate(
                    ['nombre' => $nombreAsignatura],
                    ['departamento_id' => $departamento->id]
                );

                $asignaturaIds[] = $asignatura->id;
            }

            // Total de slots disponibles: 5 días × 6 horas = 30
            $totalSlots = count($diasSemana) * count($horas);
            $slots = [];

            // Repartimos asignaturas por orden, rotando
            $index = 0;
            for ($d = 0; $d < count($diasSemana); $d++) {
                for ($h = 0; $h < count($horas); $h++) {
                    $dia = $diasSemana[$d];
                    [$inicio, $fin] = $horas[$h];

                    // Asignatura actual por rotación
                    $asignaturaId = $asignaturaIds[$index % count($asignaturaIds)];
                    $index++;

                    

                    Horario::create([
                        'dia' => $dia,
                        'hora_inicio' => $inicio,
                        'hora_fin' => $fin,
                        'asignatura_id' => $asignaturaId,
                        'aula_id' => $aula->id,
                        'visible' => true,
                    ]);
                }
            }
        }
    }
    
}
