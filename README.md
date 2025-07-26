# PROYECTO INTEGRADOR: Eccomerce The Owl

## DESCRIPCION
Aplicacion Web desarrollada con PHP, Javascript, MySql, HTML, CSS, Bootstrap 5, Cloudinary y Stripe API.

## AUTORES
- Marco Gonzalez
- Emily Chiriboga
- Doris Lopez

## ARQUITECTURA DEL PROYECTO
Monolítica en capas, Aplicando patron MVC junto con principios de Clean Architecture

## REQUISITOS PARA EJECUTAR ESTE PROYECTO
1. Tener instalado XAMPP.
2. PHP version 7.4 o superior (XAMPP ya incluye PHP)
3. Tener instalado composer

## INSTRUCCIONES DE INSTALACION Y EJECUCIÓN
1. Abrir la linea de comandos y correr: `composer install`
2. Extraer el ZIP adjunto de este proyecto dentro de la carpeta o clonar el repositorio dentro de la carpeta:
   `C:\xampp\htdocs`
3. Abrir el Panel de Control de XAMPP y activar:
   - El servidor de Apache
   - MySQL
4. Abrir http://localhost/phpmyadmin/
5. Crear una base de datos con el nombre: `the_owl_proyecto_integrador`
6. Importar el archivo: `/db/the_owl_proyecto_integrador.sql`
7. Crear una cuenta gratuita en: https://cloudinary.com y obtener el cloud name, api key y api secret
8. Crear un archivo `.env` como se encuentra en `/theowl/.env.example`
   ```
   # Configuracion de la base de datos y Cloudinary
   # Si la base de datos no tiene contraseña dejar vacía la variable de entorno
   DB_HOST=
   DB_NAME=
   DB_PASS=
   CLOUDINARY_CLOUD_NAME=
   CLOUDINARY_API_KEY=
   CLOUDINARY_API_SECRET=
   ```
9. Ir a la ubicacion del navegador http://localhost:8080/theowl/public/ para ver el punto de entrada de la aplicación

## Link de Github
https://github.com/Marco-Gonzalez26/the_owl_proyecto_integrador

## Notas
Editar composer.json para adaptar los namespace al gusto del desarrollador
