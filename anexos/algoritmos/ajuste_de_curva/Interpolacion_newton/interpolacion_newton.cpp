#include <iostream>
#include <cmath>
#include <cstdio>
#include <cstdlib>
#include <cstring>
#include <sstream>
using namespace std;

int main(int argc,char* argv[])
{
	/*
    * Ejemplo: ./out 4 '2;3;4;5' '5;6;7;8' 5 newton.txt
    *                n  x[]       y[]      k char[]
    *                argv[1] argv[2] argv[3] argv[4] argv[5]
    */

    FILE * newton;

    int n = atoi(argv[1]); //cantidad de observaciones.
    newton = fopen(argv[5], "w");
    double k, f, f1 = 1, f2 = 0;
    int i, j = 1, cont_observaciones;
    double x[n], y[n], p[n], ys[n];
    char* token;

	/*
	while(n <= 3)
	{
    	printf("\nPor favor ingrese una cantidad mayor de observaciones: ");
		scanf("%d", &n);
	}
	*/

	token = strtok(argv[2],";");
    //printf("\nIngrese los valores de x:\n");
	for(i = 1;i <= n;i++)
	{
		x[i] = atof(token);
		token = strtok(NULL,";");
	}

    //printf("\nIngrese los correspondientes valores de y:\n");
	token = strtok(argv[3],";");
	for(i = 1;i <= n;i++)
	{
		ys[i] = y[i] = atof(token);
		token = strtok(NULL,";");
	}

	f=y[1];

    //printf("\nIngrese el valor de x para ser evaluado en la funcion: ");
	k = atof(argv[4]);
	cont_observaciones = n;

	fprintf(newton, "fundamento = Ajuste de curvas\nmetodo = Interpolacion de Newton\n");
	fprintf(newton, "\nf(x) = ");
	do
	{
		for (i=1;i<=cont_observaciones-1;i++)
		{
			fprintf(newton, "%.8lf+(x-%.8lf)*", y[i] , y[i]);
			p[i] = ((y[i+1]-y[i])/(x[i+j]-x[i]));
			y[i]=p[i];
		}

		f1=1;
		for(i=1;i<=j;i++)
		{
			f1*=(k-x[i]);
		}
		f2+=(y[1]*f1); 
		//os << "Ecuacion\n" << "f(" << k << ") =" << x[i] << "+ (x - " << x[i] << ")" << "*" << f1;
		cont_observaciones--;
		j++;
	}
	while(cont_observaciones!=1);

	fprintf(newton, "\n");
	for(i = 0; i < n; i++)
	{
		fprintf(newton, "x%d = %lf\n", i, x[i]);
	}
	for(i = 0; i < n; i++)
	{
		fprintf(newton, "y%d = %lf\n", i, ys[i]);
	}
	fprintf(newton, "\nValor_a_ser_interpolado = %.0lf\n", k);

	f+=f2;

	fprintf(newton, "Resultado = %lf\n", f);
	//fprintf(newton, os);
	fclose(newton);
	cout << "Ejecucion realizada con exito" << endl;
	cout << "Numero de observaciones = "<< n << endl;
	cout << "f(" << k << ")" << " = " << f << endl;

	return 0;
}
