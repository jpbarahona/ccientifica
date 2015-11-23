/*
* Autor: Alfredo González
*		 Juan-pablo Barahona
* Date: 21/09/2015
*/

#include "../../fparser4.5.2/fparser.hh"
#include "../../INCLUDE/raiz.hh"

int main(int argc, char const *argv[]){

	double biseccion(FunctionParser fparser, double xi, double xf, double errto, int imax, std::ostream& of);

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
	   << "metodo = Biseccion" << "\n\n"
       << "f(x) = " << function << "\n"
	   << "Xi = " << xi << "\n"
	   << "Xf = " << xf << "\n"
	   << "errto = " << errto << "\n"
	   << "imax = " << imax << "\n";

	of << "\n" << "Numero de" << "\n" << "Iteracion" 
       << std::setw(14) << "Xi" 
       << std::setw(16) << "Xf"
       << "   |" 
       << std::setw(16) << "Raiz"
       << std::setw(20) << "Error" 
       << std::setw(16) << "Tolerancia" 
       << std::setw(18) << "f(Raiz)" << std::endl;

	double raiz = biseccion(fparser, xi, xf, errto, imax,of);
	of << "\n" << "La raíz aproximada es: "<< raiz << "\n" << std::endl;
	of.close();
}

double biseccion(FunctionParser fparser, double xi, double xf, double errto, int imax, std::ostream& of){
    double xr = 0, error = errto + 1, anterior;
    int cant_iteraciones = 0;

    do
    {
    	anterior = xr;
    	
        xr = (xi+xf)/2;

        error = fabs((xr - anterior)/xr) * 100;  // pagina 100 del libro (criterio de paro)
        cant_iteraciones++;

        of << cant_iteraciones
		   << "  " << std::setw(16) << xi
		   << "  " << std::setw(16) << xf
		   << "  |" << std::setw(16) << std::setprecision(14) << xr
		   << "  " << std::setw(20) << error 
		   << "  " << std::setw(8) << errto 
		   << "  " << std::setw(22) << f(fparser,xr) << std::endl;

        if(f(fparser,xi)*f(fparser,xr) < 0)
           xf = xr;
       	else
           xi = xr;
    }

   while((error > errto) && cant_iteraciones < imax);

   return xr;
}
