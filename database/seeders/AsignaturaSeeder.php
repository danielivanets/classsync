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
            ' 2º' => [ 'Acceso a datos', 'Desarrollo de interfaces', 'Programación multimedia y dispositivos móviles', 'Programación de servicios y procesos', 'Sistemas de gestión empresarial', 'Proyecto de DAM', 'Prácticas en empresa (FCT)' ],
        ];

        // Obtenemos todos los usuarios con rol 'Profesor'
        $profesores = User::role('Profesor')->pluck('id')->toArray();
        $departamentos = Departamento::pluck('id')->toArray();

        foreach ($cursosYAsignaturas as $nombreCurso => $asignaturas) {
            // Buscar aula cuyo nombre contenga el nombre del curso
            $aula = Aula::where('nombre', 'like', "%{$nombreCurso}%")->first();
        
            if ($aula) {
                foreach ($asignaturas as $nombreAsignatura) {
                    Asignatura::create([
                        'nombre' => $nombreAsignatura,
                        'descripcion' => null,
                        'departamento_id' => Arr::random($departamentos),
                        'aula_id' => $aula->id,
                        'usuario_id' => Arr::random($profesores),
                    ]);
                }
            } else {
                // Opcional: debug para saber qué cursos no encontraron aula
                info("No se encontró aula para curso: $nombreCurso");
            }
        }
        
    }
}