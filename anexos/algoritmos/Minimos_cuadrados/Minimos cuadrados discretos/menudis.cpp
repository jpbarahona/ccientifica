#include <iostream>
#include <cstdlib>
#include <cmath>

using namespace std;

int valorx[6];
int valory[6];
int multxy[6];
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
int Yestimado[6];


int cuadradoX(int array[6][2]){
	
	int aux;
	
	//cout <<"x²"<<endl;
	//cout << "---"<<endl;
	for(int i=0; i<6; i++){
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

	int cuadradoY(int array[6][2]){
	
	int aux;
	
	//cout <<"y²"<<endl;
	//cout << "---"<<endl;
	for(int i=0; i<6; i++){
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

	int multiplicacion(int array[6][2]){
		
		int aux1;
		int aux2;
		int multi;
		
		for(int i=0; i<6; i++){
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

	int covarianzaXY(int sumaXY, int sumaX, int sumaY){
		SPXY = sumaXY-((sumaX*sumaY)/6);
		}
	
	int varianzaX(int sumacuadradox, int sumaX){
		SPXX = sumacuadradox - ((sumaX*sumaX)/6);
		}
		
	int varianzaY(int sumacuadradoy, int sumaY){
		SPYY = sumacuadradoy - ((sumaY*sumaY)/6);
		}
		
	int funcion(int B0, int B1, int array[6][2]){
		
		int aux;
		for(int i=0; i<6; i++){
			for(int j=0; j<1; j++){
			aux = array[i][j];
			Yestimado[i] = B0 + B1*aux;
			}		
		}
	}

int main (){

	const int x = 6;
	const int y = 2;
	int array1[x][y];

	srand(time(0));
	cout << "La puntos generados son: " << endl;
	cout <<"X" << " "<<"Y" <<endl;
	cout << "---"<<endl;
	for(int i=0; i<x; i++){
		for(int j=0; j<y; j++){
		array1[i][j] = (rand() % 9)+1;
	//	cout << array1[i][j];
	//	cout << " ";
		}
	//cout << "\t"<< endl;
	}
	//cout << "\n";	
	
	multiplicacion(array1);
	
	cuadradoX(array1);
	
	cuadradoY(array1);
	
	covarianzaXY(sumaXY, sumaX, sumaY);
	
	varianzaX(sumacuadradox, sumaX);
	
	varianzaY(sumacuadradoy, sumaY);
	
	
	B1 = SPXY/SPXX;
	B0 = (sumaY/6) - (B1*(sumaX/6));
	
	
	cout<<SPXY<<endl;
	cout<<SPXX<<endl;
	
	cout<<B1<<endl;
	
	funcion(B0, B1, array1);
	
/*	for(int i=0; i<x; i++){
		cout <<Yestimado[i]<<endl;
		}*/
	
	return 0;
	}


