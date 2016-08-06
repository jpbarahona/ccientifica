#include <fstream>
#include <iostream>
#include <cstdlib>
#include <cmath>

using namespace std;

int valorx[100];
int valory[100];
int multxy[100];
float sumaXY=0;
float sumaX=0;
float sumaY=0;
float sumacuadradox=0;
float sumacuadradoy=0;
float SPXY=0;
float SPXX=0;
float SPYY=0;
float B1;
float B0;
float Yestimado[100];


int cuadradoX(int array[][2], int x){

	int aux;

	//cout <<"x²"<<endl;
	//cout << "---"<<endl;
	for(int i=0; i<x; i++){
		for(int j=0; j<1; j++){
			aux = array[i][j];
			sumaX = sumaX + aux;
			valorx[i] = aux*aux;
			//cout << valorx[i]<<endl;
			sumacuadradox = sumacuadradox+valorx[i];
			//cout<<cuadradox<<endl;
		//	cout << valorx[i];
		}
		//cout << "\t"<< endl;
	}
	//cout << "\n";
}

	int cuadradoY(int array[][2], int x){

	int aux;

	//cout <<"y²"<<endl;
	//cout << "---"<<endl;
	for(int i=0; i<x; i++){
		for(int j=1; j<=1; j++){
			aux = array[i][j];
			sumaY = sumaY + aux;
			valory[i] = aux*aux;
			sumacuadradoy = sumacuadradoy+valory[i];
			//cout<<cuadradoy<<endl;
			//cout << valory[i];
		}
		//cout << "\t"<< endl;
	}
	//cout << "\n";
}

	int multiplicacion(int array[][2], int x){

		int aux1;
		int aux2;
		int multi;

		for(int i=0; i<x; i++){
			for(int j=0; j<1; j++){
			aux1 = array[i][j];
			//cout<< aux1;
			}
			//cout <<" ";
		for(int k=1; k<=1; k++){
			aux2 = array[i][k];
			//cout<< aux2<<endl;
			}
			multxy[i] = aux1*aux2;
			//cout<<multxy[i]<<endl;
			sumaXY = sumaXY+multxy[i];
			//cout<<sumaXY<<endl;
		}

	}

	int covarianzaXY(int sumaXY, int sumaX, int sumaY, int x){
		SPXY = sumaXY-((sumaX*sumaY)/x);
		}

	int varianzaX(int sumacuadradox, int sumaX, int x){
		SPXX = sumacuadradox - ((sumaX*sumaX)/x);
		}

	int varianzaY(int sumacuadradoy, int sumaY, int x){
		SPYY = sumacuadradoy - ((sumaY*sumaY)/x);
		}

	int funcion(int B0, int B1, int array[][2], int x){

		int aux;
		for(int i=0; i<x; i++){
			for(int j=0; j<1; j++){
			aux = array[i][j];
			Yestimado[i] = B0 + B1*aux;
			}
		}
	}

int main (int argc, char *argv[]){

	/**
	 * Ejemplo Ejecución:
	 * ./minimos out.txt 3 2 3 4 5 6 7
	 * = ejecutador archivo_salida nº_ptos_a_evaluar puntos (x primero)
	 */

	ofstream fs(argv[1]);//Nombre del txt

	fs<<"Fundamento = ajuste de curvas"<<endl;
	fs<<"Metodo = minimos cuadrados"<<endl;

	int c = 3;
	int x = atof(argv[2]);//Cantidad de puntos que se ingresan en el arreglo
	int u;
	const int y = 2;
	/*
	cout<<"Ingrese la cantidad de puntos: "<<endl;
	cin>>x;*/

	int array1[x][y];

//	srand(time(0));
//	cout << "Ingrese los punto a generar " << endl;
	fs<<"Puntos ingresados:"<<endl;
	fs <<"X" << " "<<"Y"<<endl;
	fs << "\n"<<endl;
	for(int i=0; i<x; i++){
		for(int j=0; j<y; j++){
		//	cin >> u;
		u = atof(argv[c]);//Los puntos X e Y que se ingresan en el arreglo (primero se ingresa X luego Y)
		array1[i][j] = u;
		fs << array1[i][j];
		fs << " ";
		c++;
		}
	fs << "\t"<<endl;
	}
	fs << "\n";


	multiplicacion(array1, x);

	cuadradoX(array1, x);

	cuadradoY(array1, x);

	covarianzaXY(sumaXY, sumaX, sumaY, x);

	varianzaX(sumacuadradox, sumaX, x);

	varianzaY(sumacuadradoy, sumaY, x);


	B1 = SPXY/SPXX;
	B0 = (sumaY/x) - (B1*(sumaX/x));


	cout<<SPXY<<endl;
	cout<<SPXX<<endl;

	cout<<B1<<endl;

	funcion(B0, B1, array1, x);//Genera la funcion de ajuste

/*	for(int i=0; i<x; i++){
		cout <<Yestimado[i]<<endl;
		}*/
	fs<<"La funcion del ajuste de curva es: "<<endl<<"F(x)="<<B0<<"+"<<B1<<"*X"<<endl;
	fs.close();

	fs <<"Los nuevos putnos: "<<endl;//Se imprimen los nuevos puntos generados
	fs <<""<<endl;
	for(int i=0; i<x; i++){
		for(int j=0; j<1; j++){
		fs <<array1[i][j];
		fs <<" ";
		fs <<Yestimado[i]<<endl;
		}
	}

	return 0;
	}


