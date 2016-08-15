#include <iostream>
//#include <conio.h> // old MS-DOS
#include <curses.h> // funciones similares de conio
#include <iomanip>
#include <math.h>
#include <stdlib.h>
#include <fstream>

using namespace std;

double x0,y0n,xf,yf;
int n;
ofstream arch;

//Se debe ingresar X0=0; y0n=1; Xf=1; N=10

double f(double x, double y){
  // EJEMPLO PAGINA 665 CHAPRA
    return -2*pow(x,3) + 12*pow(x,2) - 20*x + 8.5;
}

void reportar(double x, double y, int i){
    cout << setiosflags(ios::showpoint | ios::fixed);
    cout << setiosflags(ios::right);
    cout.precision(6);
    cout << setw(10) << i << setw(15) << x << setw(15) << y << endl;

    arch << setw(10) << i << setw(15) << x << setw(15) << y << endl;
}
/*
VALORES
0 1 4 7
*/
void Kutta(){
    double h,k1,k2,k3,k4;
    int i;
    //system("cls");

    h = (xf-x0)/n;
    cout<<endl;
    cout<< "\t" << "I" << "\t" << "Xi" << "\t" << "Yi" << endl;
    cout<< "\t" << "-" << "\t" << "--" << "\t" << "--" <<endl;


    arch << "Fundamento = Resolucion de ecuaciones diferenciales" << endl;
    arch << "metodo = Runge-kutta" << endl << endl;

    arch << "f(x)" << endl;
    arch << "X0 = " << x0 << endl;
    arch << "y0n = " << y0n << endl;
    arch << "Xf = " << xf << endl;
    arch << "yf = " << yf << endl;
    arch << "n = " << n << endl << endl;

    for(i=x0;i< n;i++){
        k1 = f(x0,y0n);
        k2 = f(x0+h/2,y0n+h*k1/2);
        k3 = f(x0+h/2,y0n+h*k2/2);
        k4 = f(x0+h,y0n+h*k3);
        y0n = y0n+(k1+2*k2+2*k3+k4)*h/6;
        x0 = x0+h;
        reportar(x0,y0n,i);
    }
    cout<<"El valor de Yf: " << y0n << endl;
    getch();
}


int main (int argc, char const *argv[]){
    //std::string function = argv[1];
    x0 = atof(argv[1]);
    y0n = atof(argv[2]);
    xf = atof(argv[3]);
    n = atoi(argv[4]);
    arch.open(argv[5], ofstream::out | ofstream::app);

    Kutta();
    getch();
    arch.close();

    return 0;

}
