#### Guía para ejecutar localmente 

Requisitos: 
- PHP >8.3
- Composer
- Symfony CLI

Clonar el repositorio y ejecutar los siguientes comandos:

- `composer install`

- `symfony server:start`

#### Base de datos

Se encuentra un dump de la base de datos en la raíz del proyecto como **dump-proyectolp.sql**.

Consideraciones: La base de datos es PSQL versión 16.

#### Back end

Los controladores se encuentran en **src/Controller/**. Los controladores con los requerimientos de cada estudiante son:
- ReservacionesController.php
- CubiculosController.php

Los detalles de estos controladores se encuentran en el informe final.

#### Front ent

En **templates/** se encuentran las vistas. Tanto **templates/reservaciones/** como **templates/cubiculos/** contienen las vistas de los requerimientos del proyecto.

#### Usuarios

Existen dos usuarios para iniciar sesión:
Administrador: admin@correo.com
Estudiante: estudiante@correo.com

Password: **12345**