/*
* Autor: Gonzalo Cifuentes
*	 Juan-pablo Barahona
* Date: 21/09/2015
*/

#include "../fparser4.5.2/fparser.hh"

#include <iostream>		/* std::cout, std::cin, std::endl */
#include <cmath>		/* abs() */
#include <iomanip>		/* std::setw(), std::setprecision*/
#include <fstream>		/* std::ifstream */
#include <cstring>		/* compare, std::string, std::stod (convert string to double value *pero no funciona...), std::strcpy */
#include <cstdlib>     		/* atoi, atof (return double value) */

double f(double x);
double puntoFijo(FunctionParser fparser, double xi, double xf, double errto, int imax, std::ostream& of);
double dvalue(int pos_cstr, char* cstr);

int main()
{

	std::string function;
	double xi,xf,errto,imax;
	
	//===================================================================
	//================= Leer parametros desde input.txt =================
	
	std::string line;
	char * fx = new char [25];
	std::ifstream fe ("input.txt");
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
    
    std::ofstream of("output.txt");

    of << "\nf(x) =" << function << "\n"
       << "Xi = " << xi << "\n"
       << "Xf = " << xf << "\n"
       << "errto = " << errto << "\n"
       << "imax = " << imax << "\n\n";

    of << "\n" << "Numero de" << "\n" << "Iteracion" 
       << std::setw(14) << "Xi"
       << std::setw(16) << "Raiz"
       << std::setw(20) << "Error" 
       << std::setw(20) << "Tolerancia" 
       << std::setw(18) << "f(Raiz)\n" << std::endl;

    double raiz = puntoFijo(fparser, xi, xf, errto, imax,of);
    
    of << "\n" << "La raíz aproximada es: "<< raiz << "\n" << std::endl;
    
    of.close();
}

double f (FunctionParser fparser, double x)
{
	double vals[] = { 0 };
	
    vals[0] = x;
	
	return fparser.Eval(vals);
}

double dvalue(int pos_cstr, char* cstr)
{
	int j = 0;
	char * cstrcpy = new char[25];
	
	do
	{
		cstrcpy[j]=cstr[pos_cstr];
		pos_cstr++;j++;
	}while(cstr[pos_cstr] != '\0');
	
	return atof(cstrcpy);
}

double puntoFijo(FunctionParser fparser, double xi, double xf, double errto, int imax, std::ostream& of)
{

 	int iterCount = 0;
 	double error = errto + 1, xr = 0, anterior;

	while (error > errto && iterCount < imax)
	{
		anterior = xr;
		xr = xi + f(fparser,xi);

		error = fabs((xr - anterior)/xr) * 100;
		iterCount++;

		of << "  " << std::setw(2) << iterCount
		   << "  " << std::setw(16) << xi
		   << "  |" << std::setw(16) << std::setprecision(14) << xr
		   << "  " << std::setw(20) << error 
		   << "  " << std::setw(8) << errto 
		   << "  " << std::setw(22) << f(fparser,xr) << std::endl;

		xi=xr; 
    }
return xr;
}
