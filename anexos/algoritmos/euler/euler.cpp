#include <cstdlib>
#include <iostream>
#include <stdio.h>
#include <math.h>
#include <fstream>

using namespace std;
//
//Algoritmo que resuelve una funcion con el metodo de euler
//Los parametros se ingresan a traves de una linea de comandos
//El orden para ingresar los datos es: "nombre txt", "valor inicial de x", "valor inicial de y", "valor final de x", "cantidad de iteraciones"
//
//
int main(int argc, char *argv[])
{
	ofstream fs(argv[1]);
	
	fs<<"Fundamento = optimización"<<endl;
	fs<<"Metodo = euler"<<endl;
	fs << "\n" <<endl;
    float  h ,x,y, w, yr,e,er;
    float x0 = atof(argv[2]);
    float y0 = atof(argv[3]);
    float b = atof(argv[4]);
    int n = atof(argv[5]);
    int k;
    fs << "f(x) = (2*^(e,x))-x-1" <<endl;
    fs <<"Xi = "<<x0<<endl;
    fs <<"Xf = "<<b<<endl;
    fs <<"Yi = "<<y0<<endl;
    fs <<"Iteraciones = "<<n<<endl;
    fs << "\n" <<endl;
 /* cin >> x0;   // valor inicial de x, ver grafico de la function real
    cin >> y0;   // valor inicial de y, ver grafico de la function real
    cin >> b;    // valor final de  x, ver grafico de la function real
    cin >> n;   // cantidad de divisiones entre x=0 y x=1*/
    h=(b-x0)/n ; // calculo del valor de cada division
    x= x0;
    y= y0;
    w=0.2;
    e=2.71828 ;

    fs << "x(0)="<< x <<  "               y(0)="<< y0<<"    h="<<h<< endl ;
    //cout << "----------------------------------------------------------------------" << endl;
    fs << "\n" <<endl;
    
    for (k=1; k<=n ; k++)   {
		y = y+(x+y)*h ; // ecuacion obtenida para el calculo
		x=x+h; // se incrementa el valor de x
		yr=(2*pow(e,x))-x-1;  // ecuacion real
		er=((yr-y)*100)/yr;  // calculo del error

		fs << "x("<< k << ")=" << x<< "   y(" << k <<")="<< y <<"   yr("<<k<<")="<<yr<<"    er="<<er<< endl ;
		//cout << "----------------------------------------------------------------------" << endl;
		}

	fs.close();
    return 0;
}
