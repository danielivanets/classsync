
<img src="public/vendor/adminlte/dist/img/ClassSyncLogo.png" width="200" alt="ClassSync

# 📚 ClassSync

**ClassSync** es una aplicación web desarrollada para mejorar la organización y gestión de horarios escolares en institutos. Está pensada especialmente para facilitar el trabajo del profesorado, la administración del centro y la consulta por parte de usuarios invitados.


---

## 🚀 Características principales

- 🔒 Inicio de sesión con roles diferenciados (Profesor, Administrador, Invitado)
- 🗓️ Consulta y gestión de horarios de clase
- 🏫 Visualización de aulas y asignaturas asignadas
- 📝 Gestión de notas de clase por los profesores
- 👥 Administración de usuarios, roles y permisos
- 📊 Panel moderno basado en **AdminLTE** (Bootstrap)
- 📂 Exportación e interacción de datos con **DataTables**

---

## 🛠️ Tecnologías utilizadas

| Tecnología | Descripción |
|------------|-------------|
| **Laravel** | Framework backend (PHP) con estructura MVC |
| **MySQL** | Sistema gestor de base de datos relacional |
| **Blade** | Motor de plantillas nativo de Laravel |
| **AdminLTE** | Plantilla de panel administrativo basada en Bootstrap |
| **jQuery** + **DataTables** | Plugins para mejorar la interacción en el frontend |

---

## 🧑‍💻 Roles de usuario

- 👨‍🏫 **Profesor**: Gestiona sus asignaturas, notas y horarios.
- 🛠️ **Administrador**: Tiene control completo sobre usuarios, roles, aulas y horarios.
- 👥 **Invitado**: Puede consultar información pública como aulas o profesorado.

---

## 📂 Estructura del proyecto (resumida)

ClassSync/
├── app/ # Lógica principal de Laravel
│ ├── Models/ # Modelos de base de datos
│ ├── Http/Controllers/ # Controladores de la app
├── resources/views/ # Vistas con Blade
├── routes/web.php # Rutas de la aplicación
├── public/ # Recursos públicos
└── database/ # Migraciones y seeds


---

## 📸 Capturas de pantalla

<!-- Añade tus capturas aquí o en un directorio y enlázalas -->
- Página de inicio
- Panel del profesor
- Gestión de aulas y asignaturas
- Vista de horario con DataTables

---

## 📝 Posibles mejoras

- Adjuntar archivos en notas de clase
- Mensajería interna entre docentes
- Historial de cambios (auditoría)
- Calendario visual con detección de solapamientos
- Adaptación completa para móviles

---

## ⚙️ Instalación

```bash
git clone https://github.com/tuusuario/classsync.git
cd classsync
composer install
cp .env.example .env
php artisan key:generate
# Configura tu base de datos en .env
php artisan migrate --seed
php artisan serve


🤝 Contribuciones
¿Quieres colaborar? ¡Genial! Abre un issue o un pull request con tus mejoras. Toda ayuda es bienvenida.

📄 Licencia
Este proyecto está licenciado bajo la MIT License.

👨‍💻 Autor
Proyecto desarrollado por Daniel Ivanets Ivanets
2º DAM — Proyecto de Fin de Ciclo
2024 / 2025
