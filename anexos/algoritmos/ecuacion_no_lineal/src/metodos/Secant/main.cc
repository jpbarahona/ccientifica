/*
* Autor: Antonio Lefimil 
*		 Juan-pablo Barahona
* Date: 17/09/2015
*/

#include "../../fparser4.5.2/fparser.hh"
#include "../../INCLUDE/raiz.hh"

int main (int argc, char const *argv[]){

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
       << "metodo = Secante" << "\n\n"
	   << "f(x) = " << function << "\n"
	   << "Xi = " << xi << "\n"
	   << "Xf = " << xf << "\n"
	   << "errto = " << errto << "\n"
	   << "imax = " << imax << "\n\n";

	of << "\n" << "Numero de" << "\n" << "Iteracion" 
       << std::setw(15) << "Xi" 
	   << std::setw(18) << "Xf"
	   << "  |" 
	   << std::setw(16) << "Raiz"
	   << std::setw(20) << "Error"
       << std::setw(14) << "Tolerancia"
       << std::setw(18) << "f(Raiz)" << std::endl;
	
	double xr = 0,error = 1,anterior;
	int cont = 0;
	double fxr = 0;
	
	while(error > errto && cont < imax)
	{
		anterior = xr;
		
		xr = (xf-((xi - xf)/(f(fparser,xi)-f(fparser,xf))*f(fparser,xf)));

		error = fabs((xr - anterior)/xr) * 100;	
	    cont++;

	    fxr = f(fparser,xr);

		of   << cont << "  "
			 << "  " << std::setw(16) << xi
			 << "  " << std::setw(16) << xf
			 << "  |" << std::setw(16) << std::setprecision(14) << xr
			 << "  " << std::setw(20) << error
			 << "  " << std::setw(8) << errto 
			 << "  " << std::setw(22) << fxr<< std::endl;

		xi=xf;
		xf=xr;
	}
	
	of << "\n" << "La raíz aproximada es: "<< xr << "\n" << std::endl;
	return 0;
}
