/*
* Autor: Juan-pablo Barahona
* 		 Antonio Lefimil
* Date: 17/09/2015
*/

#include "fparser4.5.2/fparser.hh"

#include <iostream>
#include <cstdio>
#include <cmath>		/* abs () */
#include <fstream>		/* std::ifstream */
#include <cstring>		/* compare, std::string, std::stod (convert string to double value *pero no funciona...), std::strcpy */
#include <cstdlib>     	/* atoi, atof (return double value) */
#include <iomanip>		/* std::setw() */

float fun(FunctionParser fparser,float x);
double dvalue(int pos_cstr, char* cstr);

int main ()
{

	std::string function;
	double xl = 0,xr = 0,errto = 0,imax = 0;
	
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

	of  << "\n" << "Numero de" << "\n" << "Iteracion" 
		<< std::setw(12) << "xl" 
		<< std::setw(14) << "xr"
		<< std::setw(14) << "raiz"
		<< std::setw(14) << "Error"
		<< std::setw(14) << "Tolerancia\n" << std::endl;
	
	float z,error = errto+1;
	int cont = 1;
	
	while(error > errto && cont < imax)
	{
		z = (xr-((xl-xr)/(fun(fparser,xl)-fun(fparser,xr))*fun(fparser,xr)));
		of   << std::setw(5) << cont << "  "
			 << std::setw(14) << xl
			 << std::setw(14) << xr
			 << std::setw(14) << z
			 << std::setw(14) << error
			 << std::setw(14) << errto << std::endl;
		error=(fabs(xr-z));	
		xl=xr;
		xr=z;
	        cont++;
	}
	
	of << "\n" << "La raíz aproximada es: "<< z << "\n" << std::endl;
	return 0;
}

float fun(FunctionParser fparser,float x){
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
