<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aula;
use App\Models\Asignatura;
use App\Models\User;
use Illuminate\Support\Arr;
use App\Models\Departamento;

class AsignaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            // Lenguas
            'Lengua Castellana y Literatura' => 'Lenguas',
            'Inglés' => 'Lenguas',
            'Inglés técnico' => 'Lenguas',
            'Redacción de documentos' => 'Lenguas',

            // Matemáticas
            'Matemáticas' => 'Matematicas',
            'Matemáticas I' => 'Matematicas',
            'Matemáticas II' => 'Matematicas',
            'Técnica contable' => 'Matematicas',
            'Contabilidad y fiscalidad' => 'Matematicas',
            'Gestión financiera' => 'Matematicas',

            // Ciencias
            'Ciencias Sociales' => 'Historia',
            'Geografía e Historia' => 'Historia',
            'Historia del Mundo Contemporáneo' => 'Historia',
            'Historia de España' => 'Historia',

            'Ciencias Naturales' => 'Biologia',
            'Biología y Geología' => 'Biologia',

            'Física y Química' => 'Fisica',

            // Filosofía
            'Filosofía' => 'Filosofia',

            // Educación Física
            'Educación Física' => 'Educacion Fisica',

            // Tecnología / Informática
            'Tecnología' => 'Informatica',
            'Tecnologías de la Información y la Comunicación' => 'Informatica',
            'TIC II' => 'Informatica',
            'Tratamiento de datos y hojas de cálculo' => 'Informatica',
            'Procesadores de textos' => 'Informatica',
            'Aplicaciones ofimáticas' => 'Informatica',
            'Redes locales' => 'Informatica',
            'Sistemas operativos monopuesto' => 'Informatica',
            'Sistemas operativos en red' => 'Informatica',
            'Servicios en red' => 'Informatica',
            'Aplicaciones web' => 'Informatica',
            'Montaje y mantenimiento de equipos' => 'Informatica',
            'Seguridad informática' => 'Informatica',
            'Sistema operativo' => 'Informatica',
            'Sistemas informáticos' => 'Informatica',
            'Bases de datos' => 'Informatica',
            'Programación' => 'Informatica',
            'Lenguajes de marcas y sistemas de gestión de información' => 'Informatica',
            'Entornos de desarrollo' => 'Informatica',
            'Acceso a datos' => 'Informatica',
            'Desarrollo de interfaces' => 'Informatica',
            'Programación multimedia y dispositivos móviles' => 'Informatica',
            'Programación de servicios y procesos' => 'Informatica',
            'Sistemas de gestión empresarial' => 'Informatica',

            // Artes
            'Música' => 'Artes',
            'Plástica' => 'Artes',
            'Educación Plástica' => 'Artes',

            // Religión / Ética
            'Religión / Valores Éticos' => 'Religion',

            // Tutoría
            'Tutoría' => 'Orientacion',

            // Economía / Empresa
            'Economía' => 'Economia',
            'Empresa y Diseño de Modelos de Negocio' => 'Economia',
            'Comunicación empresarial' => 'Economia',
            'Comunicación empresarial y atención al cliente' => 'Economia',
            'Operaciones administrativas de compra-venta' => 'Economia',
            'Empresa y administración' => 'Economia',
            'Tratamiento informático de la información' => 'Economia',
            'Gestión de recursos humanos' => 'Economia',
            'Gestión logística y comercial' => 'Economia',
            'Empresa en el aula' => 'Economia',
            'Simulación empresarial' => 'Economia',
            'Proyecto de administración y finanzas' => 'Economia',
            'Empresa e iniciativa emprendedora' => 'Economia',
            'Proyecto de DAM' => 'Economia',

            // FOL
            'Formación y Orientación Laboral' => 'FOL',
            'Prácticas en empresa' => 'FOL',
            'Prácticas en empresa (FCT)' => 'FOL',

            // Otros
            'Gestión de la documentación jurídica y empresarial' => 'Administracion',
            'Recursos humanos y responsabilidad social corporativa' => 'Administracion',
            'Ofimática y proceso de la información' => 'Administracion',
            'Proceso integral de la actividad comercial' => 'Administracion',
            'Comunicación y atención al cliente' => 'Administracion',
        ];

        // Crear todos los departamentos incluidos "Otros"
        $departamentosUsados = array_unique(array_merge(array_values($departamentoPorAsignatura), ['Otros']));
        foreach ($departamentosUsados as $nombre) {
            Departamento::firstOrCreate(['nombre' => $nombre]);
        }

        // Mapa rápido de nombre => ID
        $departamentosPorNombre = Departamento::pluck('id', 'nombre')->toArray();

        // Profesores
        $profesores = User::role('Profesor')->pluck('id')->toArray();

        foreach ($cursosYAsignaturas as $nombreCurso => $asignaturas) {
            $aula = Aula::where('nombre', 'like', "%{$nombreCurso}%")->first();

            if ($aula) {
                foreach ($asignaturas as $nombreAsignatura) {
                    $nombreDepto = $departamentoPorAsignatura[$nombreAsignatura] ?? 'Otros';
                    // Convertir a minúsculas para coincidir con el formato del correo
                    $nombreDeptoLower = strtolower($nombreDepto);

                    // Buscar un profesor cuyo email comience por el nombre del departamento
                    $profesor = User::role('Profesor')
                        ->where('email', 'like', "{$nombreDeptoLower}_%@edu.gva.es")
                        ->inRandomOrder()
                        ->first();

                    $departamentoId = $departamentosPorNombre[$nombreDepto] ?? null;

                    if (!$profesor) {
                        // Elegir cualquier profesor aleatorio como último recurso
                        $profesor = User::role('Profesor')->inRandomOrder()->first();
                        $departamentoId = null;
                    }
                    Asignatura::create([
                        'nombre' => $nombreAsignatura,
                        'descripcion' => null,
                        'departamento_id' => $departamentoId,
                        'aula_id' => $aula?->id,
                        'usuario_id' => $profesor?->id,
                    ]);
                }
            } else {
                info("No se encontró aula para curso: $nombreCurso");
            }
        }
        
    }
}