/*
* Autor: Juan-pablo Barahona
* Date: 17/09/2015
*/

#include "../../fparser4.5.2/fparser.hh"
#include "../../INCLUDE/raiz.hh"

int main(){

	double brent(FunctionParser fparser, double xi, double xf, double errto, int imax, std::ostream& of);

	std::string function;
	double xi,xf,errto,imax;

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
    
	char * file = fichero("out", "cc", "er", "br","out","txt",100);

    std::ofstream of(file);

    of << "\nf(x) = " << function << "\n"
			  << "xi = " << xi << "\n"
			  << "xf = " << xf << "\n"
			  << "errto = " << errto << "\n"
			  << "imax = " << imax << "\n\n";

	of << "\n" << "Numero de" << "\n" << "Iteracion" 
	        << std::setw(14) << "Xi-2(xi)" 
	        << std::setw(16) << "Xi-1(x)"
	        << std::setw(16) << "Xi(xf)"
	        << std::setw(20) << "Raiz"
	   		<< std::setw(20) << "Error"
	        << std::setw(16) << "Tolerancia"
	        << std::setw(18) << "f(Raiz)\n" << std::endl;
	double raiz = brent(fparser, xi, xf, errto, imax,of);
	of << "\n" << "La raíz aproximada es: "<< raiz << "\n" << std::endl;
	of.close();
	free(file);
}

double brent(FunctionParser fparser, double xi, double xf, double errto, int imax, std::ostream& of)
{
    /*
    Brent : Retorna la raiz de la función.
 
    * xi: Intervalo izquierdo
    * xf: Intervalo derecho
    * errto: tolerancia de error
    * imax: Número maximo de iteraciones
 
    * return: raiz aproximada
    */
    double errnoo = errto + 1;
    double iterCount = 0;
    double x = xi;
    double y = xf;
    double xfold = 0;
    bool mflag = true;
    double delta = xf;
    double s = 0;

    if (f(fparser,xi) * f(fparser,xf) >= 0.0)
        return nan("");
 
    if (std::abs(f(fparser,xi)) < std::abs(f(fparser,xf)))
    {
	double aux = xi;
	xi = xf;
	xf = aux;
    }
	
    double fl;
    double fr;
    double fx;
	
    while (errnoo > errto && iterCount < imax)
    {
       xfold = s;
       fl = f(fparser,xi);
       fr = f(fparser,xf);
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
 
            s = fx * fr * xi / (delta[1] * delta[2]) +
                fl * fr * x / (delta[3] * delta[4]) +
                fl * fx * xf / (delta[5] * delta[6]);
                
            delete delta;
		}
        // Secante
        else
            s = xf - ((xi - xf)/(fl - fr)*fr);
 
        if ((!(s > (3 * xi + xf)/4 && s < xf)) ||
            (mflag && std::abs(s - xf) >= std::abs(xf - x)/2) ||
            (!mflag && std::abs(s - xf) >= std::abs(x - y)/2) ||
            (mflag && std::abs(xf - x) < std::abs(delta)) ||
            (!mflag && std::abs(x - y) < std::abs(delta)))
            {
                // Bisección
                s = (xf + xi)/2;
                mflag = true;
            }
        else
            mflag = false;
 
        double fs = f(fparser,s);

        iterCount += 1;

        errnoo = fabs((s - xfold)/s) * 100;
        
        of << "  " << std::setw(2) << iterCount
	   << "  " << std::setw(16) << xi
	   << "  " << std::setw(16) << x 
	   << "  " << std::setw(16) << xf
 	   << "  |" << std::setw(16) << std::setprecision(14) << s 
 	   << "  " << std::setw(20) << errnoo 
 	   << "  " << std::setw(8) << errto
 	   << "  " << std::setw(22) << fs << std::endl;
        
        y = x;
        x = xf;
		
        if (fl * fs < 0.0)
            xf = s;
        else
            xi = s;
 
        if (std::abs(f(fparser,xi)) < std::abs(f(fparser,xf)))
        {
	    double aux = xi;
	    xi = xf;
	    xf = aux;
	}
 
        if (fs == 0 || f(fparser,xf) == 0)
            break;
	}
    return xf;
}
