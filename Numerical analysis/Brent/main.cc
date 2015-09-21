/*
* Autor: Juan-pablo Barahona
* Date: 17/09/2015
*/

#include "fparser4.5.2/fparser.hh"

#include <iostream>		/* std::cout, std::cin, std::endl */
#include <cmath>		/* abs() */
#include <iomanip>		/* std::setw() */
#include <fstream>		/* std::ifstream */
#include <cstring>		/* compare, std::string, std::stod (convert string to double value *pero no funciona...), std::strcpy */
#include <cstdlib>     	/* atoi, atof (return double value) */

double f (FunctionParser fparser, double x);
double dvalue(int pos_cstr, char* cstr);
double brent(FunctionParser fparser, double xl, double xr, double errto, double imax, std::ostream& of);

int main()
{	
	std::string function;
	double xl,xr,errto,imax;
	
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
			if(line.compare(0,5,"xl = ") == 0)
		 	{
				xl = dvalue(5,cstr);
			}
			if(line.compare(0,5,"xr = ") == 0)
		 	{
				xr = dvalue(5,cstr);
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

    while(true)
    {
        int res = fparser.Parse(function, "x");
        if(res < 0) break;

        std::cout << std::string(res+7, ' ') << "^\n"
                  << fparser.ErrorMsg() << "\n\n";
    }
    
    std::ofstream of("output.txt");

    of << "\nf(x) =" << function << "\n"
			  << "xl = " << xl << "\n"
			  << "xr = " << xr << "\n"
			  << "errto = " << errto << "\n"
			  << "imax = " << imax << "\n\n";

	of << "\n" << "Numero de" << "\n" << "Iteracion" 
	        << std::setw(14) << "Xi-2(xl)" 
	        << std::setw(16) << "Xi-1(x)"
	        << std::setw(16) << "Xi(xr)"
	        << std::setw(16) << "Tolerancia"
	        << std::setw(14) << "Raiz"
	        << std::setw(16) << "f(Raiz)" << std::endl;
	double raiz = brent(fparser, xl, xr, errto, imax,of);
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

double brent(FunctionParser fparser, double xl, double xr, double errto, double imax, std::ostream& of)
{
    /*
    Brent : Retorna la raiz de la función.
 
    brent(xl, xr, errto=0.001, imax=500)
 
    * xl: Intervalo izquierdo
    * xr: Intervalo derecho
    * errto: tolerancia de error
    * imax: Número maximo de iteraciones
 
    return: raiz aproximada
    */
    double errnoo = errto + 1;
    double iterCount = 0;
    double x = xl;
    double y = xr;
    double xrold = 0;
    bool mflag = true;
    double delta = xr;
    double s;

    //::ifstream of("output.txt");

    if (f(fparser,xl) * f(fparser,xr) >= 0.0)
        return nan("");
 
    if (std::abs(f(fparser,xl)) < std::abs(f(fparser,xr)))
    {
		double aux = xl;
		xl = xr;
		xr = aux;
	}
	
	double fl;
    double fr;
    double fx;
	
    while (errnoo > errto && iterCount < imax)
    {
       fl = f(fparser,xl);
       fr = f(fparser,xr);
       fx = f(fparser,x);
 
        // Interpolación inversa cuadrática
        if (fl != fx && fr != fx)
		{
            double * delta = new double [7];
            delta[0] = 0;
            delta[1] = fl - fx;
            delta[2] = fl - fr;
            delta[3] = fx - fl;
            delta[4] = fx - fr;
            delta[5] = fr - fl;
            delta[6] = fr - fx;
 
            s = fx * fr * xl / (delta[1] * delta[2]) +
                fl * fr * x / (delta[3] * delta[4]) +
                fl * fx * xr / (delta[5] * delta[6]);
                
            delete delta;
		}
        // Secante
        else
            s = xr - fl*(xr - xl)/(fr - fl);
 
        if ((!(s > (3 * xl + xr)/4 && s < xr)) ||
            (mflag && std::abs(s - xr) >= std::abs(xr - x)/2) ||
            (!mflag && std::abs(s - xr) >= std::abs(x - y)/2) ||
            (mflag && std::abs(xr - x) < std::abs(delta)) ||
            (!mflag && std::abs(x - y) < std::abs(delta)))
            {
                // Bisección
                s = (xr + xl)/2;
                mflag = true;
            }
        else
            mflag = false;
 
        double fs = f(fparser,s);
        
        of << "  " << std::setw(3) << iterCount
				  << "  " << std::setw(14) << xl
				  << "  " << std::setw(14) << x 
				  << "  " << std::setw(14) << xr
				  << "  |" << std::setw(14) << errto 
				  << "  " << std::setw(14) << s 
				  << "  " << std::setw(14) << fs << std::endl;
        
        y = x;
        x = xr;
        
		
        if (fl * fs < 0.0)
            xr = s;
        else
            xl = s;
 
        if (std::abs(f(fparser,xl)) < std::abs(f(fparser,xr)))
        {
			double aux = xl;
			xl = xr;
			xr = aux;
		}
 
        if (fs == 0 || f(fparser,xr) == 0)
            break;
 
        if (std::abs(xr - xrold) < delta)
            delta = std::abs(xr - xrold);
 
        xrold = xr;
        iterCount += 1;
        errnoo = fabs(xr - xl);
	}

	//of.close();
    return xr;
}
