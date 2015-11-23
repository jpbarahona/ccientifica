#include "regresion_lineal.h"

int main(int argc,char* argv[])
{
	/*
    * Ejemplo: ./out 3 '1;3;9' '3;9;18' regresion_lineal.txt
    *                n  x[]       y[]    char[]
    *                argv[1] argv[2] argv[3] argv[4]
    */

    regresion_lineal recta;
    FILE * txtregresion_lineal;
	//txtregresion_lineal = fopen("txtregresion_lineal.txt", "w");
    int observaciones = atoi(argv[1]);
    txtregresion_lineal = fopen(argv[4], "w");
    int i;
    float x[observaciones], y[observaciones];
    char* token;
	/*cout << "Ingrese la cantidad de puntos: ";
	/cin >> observaciones;
	cout << "Ingrese los pares ordenados (x, y): \n";
	for(int i=0;i<= observaciones-1; i++)
	{
	cout << "x" << i << " = ";
	cin >> x[i];
	cout << "y" << i << " = ";
	cin >> y[i];
	recta.agregar_puntos(x[i], y[i]);
	*/
	token = strtok(argv[2],";");
    //printf("\nIngrese los valores de x:\n");
	for(i = 0;i < observaciones;i++)
	{
		x[i] = atof(token);
		token = strtok(NULL,";");
	}

    //printf("\nIngrese los correspondientes valores de y:\n");
	token = strtok(argv[3],";");
	for(i = 0;i < observaciones;i++)
	{
		y[i] = atof(token);
		token = strtok(NULL,";");
	}

	fprintf(txtregresion_lineal, "fundamento = Ajuste de curvas\nmetodo = Regresion lineal\n");
	fprintf(txtregresion_lineal, "\nf(x) = %.1lf+(%.1lf-%.1lf)*(x-%.1lf)/(%.1lf-%.1lf)", y[0], y[1], y[0], x[0], x[1], x[0]);

	for(i = 0; i < observaciones; i++)
	{
		fprintf(txtregresion_lineal, "\nx%d = %.1lf", i, x[i]);
		fprintf(txtregresion_lineal, "\ny%d = %.1lf", i, y[i]);
		recta.agregar_puntos(x[i], y[i]);
	}

	recta.resultado(txtregresion_lineal);
	fclose(txtregresion_lineal);

	return 0;
}