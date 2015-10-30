/*
* Autor: Antonio Lefimil 
*		 Juan-pablo Barahona
* Date: 17/09/2015
*/

#include "../../fparser4.5.2/fparser.hh"
#include "../../INCLUDE/raiz.hh"

int main ()
{

	std::string function;
	double xi = 0,xf = 0,errto = 0,imax = 0;
	
	//===================================================================
	//================= Leer parametros desde input.txt =================
	
	std::string line;
	char * fx = new char [25];
	std::ifstream fe ("inputs/input.txt");
	int i = 0,j;
	if (fe == NULL) perror ("Error abrir archivo");
	else
	{
		while(getline (fe,line))
		{	
			char * cstr = new char [line.length()+1];
			std::strcpy (cstr, line.c_str());
		 	if(line.compare(0,7,"F(x) = ") == 0)
		 	{
				j = 0;i = 7;
				
				do
				{
					fx[j] = cstr[i];
					i++;j++;
				}while(cstr[i] != '\0');
				
				std::string sfx(fx);
				function = sfx;
			}
			if(line.compare(0,5,"xi = ") == 0)
		 	{
				xi = dvalue(5,cstr);
			}
			if(line.compare(0,5,"xf = ") == 0)
		 	{
				xf = dvalue(5,cstr);
			}
			if(line.compare(0,8,"errto = ") == 0)
		 	{
				errto = dvalue(8,cstr);
			}
			if(line.compare(0,7,"imax = ") == 0)
		 	{
				imax = dvalue(7,cstr);
			}
		}
	}
	
	fe.close();
	
	//================================================================
	
	
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
	
    char * file = fichero("out", "cc", "er", "se","out","txt",100);

	std::ofstream of(file);
	
	of << "\nf(x) = " << function << "\n"
	   << "Xi = " << xi << "\n"
	   << "Xf = " << xf << "\n"
	   << "errto = " << errto << "\n"
	   << "imax = " << imax << "\n\n";

	of << "\n" << "Numero de" << "\n" << "Iteracion" 
       << std::setw(14) << "Xi" 
	   << std::setw(16) << "Xf"
	   << std::setw(16) << "Raiz"
	   << std::setw(20) << "Error"
       << std::setw(20) << "Tolerancia"
       << std::setw(18) << "f(Raiz)\n" << std::endl;
	
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

		of   << "  " << std::setw(2) << cont << "  "
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

	free(file);
	return 0;
}
