#ifndef REGRESIONLINEAL_H
#define REGRESIONLINEAL_H

#include <iostream>
#include <cstdio>
#include <cstdlib>
#include <cstring>
#include <sstream>
using namespace std;

class regresion_lineal {
    int cantidad_puntos;
    int acumulacion_pendiente;
    float valor_pendiente;
    float sumaX;
    float sumaY;
    float sumaXX;
    float sumaXY;


public:

    regresion_lineal() {
        cantidad_puntos = 0;
        sumaX = 0;
        sumaY = 0;
        sumaXX = 0;
        sumaXY = 0;
        acumulacion_pendiente = false;
        valor_pendiente = 0;
    }

    void agregar_puntos(float nuevoX, float nuevoY) {
        sumaX += nuevoX;
        sumaY += nuevoY;
        sumaXX += (nuevoX * nuevoX);
        sumaXY += (nuevoX * nuevoY);
        cantidad_puntos += 1;
        acumulacion_pendiente = false;
    }

    float encontrar_pendiente() {
        if (acumulacion_pendiente == false) {
            float parteA, parteB;

            parteA = (cantidad_puntos * sumaXY) - (sumaX * sumaY);
            parteB = (cantidad_puntos * sumaXX) - (sumaX * sumaX);
            if (parteB == 0.0f) {
                valor_pendiente = 0;
            } else {
                valor_pendiente = (parteA / parteB);
            }
            acumulacion_pendiente = true;
        }
        return valor_pendiente;
    };


    float encontrar_interceccion() {
        return (sumaY - (this->encontrar_pendiente()*sumaX)) / cantidad_puntos;
    }

    void resultado(FILE * txtregresion_lineal) {
        using std::cout;
        using std::endl;
        
        cout << "Ejecucion realizada con exito" << endl;
        cout <<"Numero de observaciones: " << cantidad_puntos << endl;
        //cout << "Cantidad de puntos: " << cantidad_puntos << endl;
        //fprintf(txtregresion_lineal, "Cantidad de puntos: %d\n", cantidad_puntos);
        //cout << "Suma de todas las X: " << sumaX << endl;
        fprintf(txtregresion_lineal, "\n\nSuma_de_todas_las_X = %.1lf\n", sumaX);
        //cout << "Suma de todas las Y: " << sumaY << endl;
        fprintf(txtregresion_lineal, "Suma_de_todas_las_Y = %.1lf\n", sumaY);
        //cout << "Suma de todos los X*X: " << sumaXX << endl;
        fprintf(txtregresion_lineal, "Suma_de_todos_los_X*X = %.1lf\n", sumaXX);
        //cout << "Suma de todos los X*Y: " << sumaXY << endl;
        fprintf(txtregresion_lineal, "Suma_de_todos_los_X*Y = %.1lf\n", sumaXY);
        //cout << "Pendiente de la recta: " << this->encontrar_pendiente() << endl;
        fprintf(txtregresion_lineal, "Pendiente_de_la_recta = %.1lf\n", this->encontrar_pendiente());
        //cout << "Interceccion de los puntos: " << this->encontrar_interceccion() << endl;
        fprintf(txtregresion_lineal, "Interceccion_de_los_puntos = %.1lf\n", this->encontrar_interceccion());

    }
};


#endif // REGRESIONLINEAL_H