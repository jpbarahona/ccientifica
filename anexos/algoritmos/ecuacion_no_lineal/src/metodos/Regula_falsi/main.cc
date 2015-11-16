/*
* Autor: Matias Greco
*		 Juan-pablo Barahona
* Date: 21/09/2015
*/

#include "../../fparser4.5.2/fparser.hh"
#include "../../INCLUDE/raiz.hh"

int main(int argc, char const *argv[])
{
	double ReglaFalsa(FunctionParser fparser,double xi, double xf, double errto,double imax, std::ostream& of);

	std::string function = argv[1];
	double xi = atof(argv[2]),xf = atof(argv[3]),errto = atof(argv[4]),imax = atoi(argv[5]);

    FunctionParser fparser;

    fparser.AddConstant("pi", 3.1415926535897932);
    fparser.AddConstant("e", 2.718281828);

    while(true)
    {
        int res = fparser.Parse(function, "x");
        if(res < 0) break;

        std::cout << std::string(res+7, ' ') << "^\n"
                  << fparser.ErrorMsg() << "\n\n";
    }
    
    char *file = (char*)malloc(sizeof(char)*strlen(argv[6])+1);
    strcpy(file,argv[6]);

    std::ofstream of(file);

    of << "fundamento = Ecuacion de raices" << "\n"
       << "metodo = Regla falsa" << "\n\n"
       << "f(x) = " << function << "\n"
	     << "Xi = " << xi << "\n"
	     << "Xf = " << xf << "\n"
	     << "errto = " << errto << "\n"
	     << "imax = " << imax << "\n\n";

	of << "\n" << "Numero de" << "\n" << "Iteracion" 
       << std::setw(14) << "Xi" 
       << std::setw(16) << "Xf"
       << "   |"
       << std::setw(16) << "Raiz"
       << std::setw(20) << "Error" 
       << std::setw(16) << "Tolerancia" 
       << std::setw(18) << "f(Raiz)" << std::endl;

	double raiz = ReglaFalsa(fparser, xi, xf, errto, imax,of);
	of << "\n" << "La raíz aproximada es: "<< raiz << "\n" << std::endl;
	of.close();
}

double ReglaFalsa(FunctionParser fparser,double xi, double xf, double errto,double imax, std::ostream& of)
{
	/*
	 *	xi: inicio intervalo
	 *	xf: fin intervalo
	 *	xr: raiz (en esa iteracion)
	 *	errto (porcentaje de error maximo, como criterio de paro)
	*/

    int iteracion = 0;
    double xr = 0, error = errto + 1, anterior;

    double fxi,fxf,fxr;

    while (error > errto && iteracion < imax) {
        anterior = xr;
        fxf = f(fparser,xf);
        fxi = f(fparser,xi);

        xr = xf -((fxf*(xi-xf)))/(fxi-fxf);

        fxr = f(fparser,xr);

        //error = (sqrt((xr-anterior)*(xr-anterior)))/xr;
        error = fabs((xr - anterior)/xr) * 100;  // pagina 100 del libro (criterio de paro)
        iteracion++;

        of << iteracion
		   << "  " << std::setw(16) << xi
		   << "  " << std::setw(16) << xf
		   << "  |" << std::setw(16) << std::setprecision(14) << xr
		   << "  " << std::setw(20) << error 
		   << "  " << std::setw(8) << errto 
		   << "  " << std::setw(22) << fxr << std::endl;

        if(fxi*fxr < 0)
           xf = xr;
       	else
           xi = xr;
    }

    return xr;

}
