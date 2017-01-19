#  Métodos Numéricos CCientifica v1.0.0 Unab

Es un proyecto de 5 estudiantes de ingeniería en computación e informática de la universidad Andrés Bello, que desarrollan en lenguaje de programación C/C++ la simulación diversos métodos numéricos que hospedan en el sitio [ccientifica](https://cursos.ing.unab.cl/) brindado por la universidad, y entregando apoyo visual con tablas y gráficos a las respectivas soluciones.

En `anexos/algoritmos`, se encuentra el código fuente para los siguientes métodos:

1. Raices de Ecuaciones
  * Bisección
  * Brent
  * Regla falsa
  * Secant

2. Ajsute de Curva (analisis numéricos y regresión)
  * Lagrange (Interpolación polinomial)
  * Newton (Interpolación polinomial)
  * Spline
  * Regresión Lineal
  * Mínimo Cuarado Discreto

3. Ecuaciones Diferenciales
  * Euler

Sin embargo, es posible integrar nuevos métodos numéricos, y para ello, se explica en la última sección.

# Instalación

Los ejecutadores del código fuente deben ser generados en el equipo donde arrancará el sistema y alojarlos en `src/model/app/exe-*`, además, su uso se debe definir en `src/model/app/.cmmdexe`.

## Requerimientos

1. Sistema operativo : sólo Unix/Linux, no soporta MS-DOS.
2. Librerías : Estandares de C++.
3. Servidor : Última versión de Apache.

# ¿Cómo Agregar nuevos Métodos?

Para ellos, se debe seguir los siguientes pasos referenciales.

1. Definir métodos a ejecutar `src/model/app/.cmmdexe`.
2. Método a evaluar (entrada y salida) `webapp/static/js/ccientificaalg.js`.
3. Indicar que método recibir y donde procesar `src/controller/site.xml`.
4. Definir orden de parametros para ejecutar método `src/model/Parametros_entrada_exe.class.php`.
5. Método a procesar y devolver resultados `src/controller/algoritmoController.class.php`.

Se debe asegurar el funcionamiento correcto en la clase `src/model/Principal.class.php`, el cual enlaza las siguientes clases:

1. `src/model/Leer_archivo.class.php`.
2. `src/model/Grafico.class.php`.
3. `src/model/Crear_archivos_directorios.class.php`. (salida de resultados)

## Requerimientos

El código debe entregar de salida un archivo *.txt plano, sin mensajes de salida por linea de comando p.ej. `GitHub:~ jupaba$ Método finalizado con éxito`. Además, los parametros necesarios para su ejecución, deben ser ingresados por linea de comando y dejando como último parametro requerido el nombre del archivo de salida, p. ej. `./Brent p1 p2 p3 p4 (ruta/)nombreArchivo.txt`

## Gráfico y Tabla de resultados.

Gráficar los resultados, se utiliza la libreria de código abierto [JsGraph v4.0.1 o última versión](http://jpgraph.net/download/). Para gráficar el método ingresado, es configurado en`src/model/Grafico.class.php`, cuyos parametros provienen de `src/model/Leer_archivo.class.php`.

Tabla de resultados, provienen de la lectura de archivo de resultado de salida. Este debe ser configurado correctamente en `src/model/Leer_archivo.class.php`.

## Almacenamiento (Archivo de salida y Gráfico)

La ruta del archivo de salida, es entregado por el propio sistema, el cual es encontrado en `src/model/app/out/*`.

Por otro lado, para los gráficos, siendo estos imágenes en `src/model/img/*`.
