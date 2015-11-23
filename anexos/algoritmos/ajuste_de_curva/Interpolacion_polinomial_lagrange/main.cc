/*
* autor: juan-pablo Barahona.
*/

#include <iostream> 	/* std::cout */
#include <cmath> 		/* fabs() */
#include <iomanip>		/* std::setw() */
#include <cstdlib>		/* atof() */
#include <fstream>		/* atof() */
#include <cstring>		/* strlen() */
#include <sstream>      /* std::ostringstream; str()*/
#include "fparser4.5.2/fparser.hh"

double f(FunctionParser fparser, double x);
void Lagrange (FunctionParser fparser, int n, double xx, double ptosx[], std::ostream& of);

int main(int argc, char *argv[]){

	/*
	* Los datos deben ser ingresados por linea de comando:
	*	ejemplo:
	* 		./lagrange 'log(x)'  2.5 	   2 	'2;3;4' ruta/NombreArchivo.txt
	*					argv[1] argv[2] argv[3] argv[4] argv[5].
	* Corresponde a: nombre ejecutador, f(x), valor x (de f(x)), n° grados utilizados
	* para la interpolacion lagrange, array con los puntos de x(sub n) utilizados en el método,
	* ruta nombre archivo destino.
	*/

	int g;
	double xx;
	char *cptosx;

	std::string function = argv[1];
	xx = atof(argv[2]);
	g = atoi(argv[3]);
	double ptosx[g];
	cptosx = argv[4];
	int n = strlen(cptosx);

	/* separar primer caracter anterior a ';'*/
	char* token = strtok(cptosx,";");
	for (int i = 0; i < n; i++){
		/* separar los siguientes caracteres anterior a ';'*/
		ptosx[i] = atof(token);
		token = strtok(NULL,";");
		if( token == NULL || i>=g){
			g = i;
			break;
		}
	}

    FunctionParser fparser;

    fparser.AddConstant("pi", 3.1415926535897932);
    fparser.AddConstant("e", 2.718281828);

    while(true){
        int res = fparser.Parse(function, "x");
        if(res < 0) break;

        std::cout << std::string(res+7, ' ') << "^\n"
                  << fparser.ErrorMsg() << "\n\n";
    }

	std::ofstream of(argv[5]);
	
	of << "fundamento = Ajuste de curvas" << "\n"
	   << "metodo = Interpolacion de lagrange" << "\n\n"
       << "f(x) = " << function << "\n"
       << "x = " << xx << "\n";
    for (int i = 0; i <= g; ++i)
	{
		of << "X" << i << " = " << ptosx[i] << "\n";
	}
	of << "\n\n";

	of << "Iteracion"
	   << std::setw(12) << "f(Xi)"
	   << std::setw(16) << "Resultados"
	   << std::setw(120) << "Ecuacion";

	Lagrange(fparser,g,xx,ptosx,of);

	of.close();
}


double f (FunctionParser fparser, double x){
	double vals[] = { 0 };
	
    vals[0] = x;
	
	return fparser.Eval(vals);
}

void Lagrange (FunctionParser fparser, int g, double xx, double ptosx[], std::ostream& of)
{
	double sum = 0,product, error;	
	std::string str;

	for (int i = 0; i <= g; i++)
	{
		of << "\n" << i+1 << std::setw(14) << "f(" << ptosx[i] << ")";
		std::ostringstream os;
		product = f(fparser, ptosx[i]);
		for (int j = 0; j <= g; j++)
		{
			if ( i != j )
			{
				os << "(x-" << ptosx[j] << ")/(" << ptosx[i] << "-" << ptosx[j] << ")*";
				product = product*(xx-ptosx[j])/(ptosx[i]-ptosx[j]);
			}
		}
		os << f(fparser, ptosx[i]);
		str = os.str();
		of << std::setw(16) << product
		   << std::setw(150) << str;
		sum = sum + product;
	}
	error = fabs(sum*100/f(fparser,xx)-100);
	of << "\n\nResultado f(x): " << f(fparser, xx) << "\n"
	   << "Suma final metodo: " << sum << "\n"
	   << "Error: " << error << "%";

}
