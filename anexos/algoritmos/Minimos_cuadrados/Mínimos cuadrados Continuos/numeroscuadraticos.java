import java.io.*;
/**
 *Programa: se trata de una implementación para el ajuste por minimos
 *cuadrados de una serie de puntos, el programa calcula a,b,error de a y de b
 *y el coeficiente de correlación lineal r
 *autor: CrashCool
 *fecha: 14/12/03
 *Licencia GPL
 *Version: 1.0 Beta *pendiente de optimizacion y comentarios.
 **/
public class minimos
{
	public static double a,b;
	

	public static double leer() throws IOException
	{
		BufferedReader in=new BufferedReader(new InputStreamReader(System.in));
		String aux=in.readLine();
		double valor=Double.parseDouble(aux);
		return valor;
	}
	
	public static double Calcular_a(int N,double Ax[],double Ay[])
	{
		double A=0,B=0,C=0,D=0,E;
		double aux1=0;
		
		for(int i=0;i<N;i++)
		{
			A+=(Ax[i]*Ay[i]);
			C+=potencia(Ax[i]);
			D+=(Ax[i]); //tb es aux_1
			aux1+=Ay[i];
		}
		A*=N;
		B=D*aux1;
		C*=N;
		D=potencia(D);
		E=(A-B)/(C-D);
	
		
		return E;
	
	}
	
	public static double Calcular_b(int N,double Ax[],double Ay[])
	{
		double A=0,a1=0,a2=0,B=0,b1=0,b2=0,C=0,D=0,E=0;
		
		for (int i=0;i<N;i++)
		{
			a1+=potencia(Ax[i]);
			a2+=Ay[i];
			b1+=Ax[i]; //tb es c1_1
			b2+=Ax[i]*Ay[i];
			C+=potencia(Ax[i]);
			
		}
		
		A=a1*a2;
		B=b1*b2;
		C*=N;
		D=potencia(b1);
		E=(A-B)/(C-D);
		
		return E;
		
	}
	
	public static double Calcular_error_a(int N,double Ax[],double Ay[])
	{
		double A=0,B=0,C,b1,p;
		
		b1=media(Ax);
		for(int i=0;i<N;i++)
		{
			A+=potencia(Ay[i]-(a*Ax[i])-b);
			B+=potencia(Ax[i]-b1);
			
		}
		p=(A/((N-2)*B));
		C=Math.pow(p,0.5);
		
			return C;
		
	}
	
	public static double Calcular_error_b(int N,double Ax[],double Ay[])
	{
		double A=0,B=0,C,D,E;
		double med=media(Ax);
		for(int i=0;i<N;i++)
		{
			A+=potencia(Ax[i]-med);
			B+=potencia(Ay[i]-(a*Ax[i])-b);
		}
		C=(1/N)+(potencia(med)/A);
		D=B/(N-2);
		E=Math.pow(C*D,0.5);
		
		return E;
	}
	
	public static double Calcular_r(int N,double Ax[],double Ay[])
	{
		double A,a1=0,B,b1=0,b2=0,C,c1=0,c2=0,D,d1=0,d2=0,r;
		for(int i=0;i<N;i++)
		{
			a1+=Ax[i]*Ay[i];
			b1+=Ax[i]; //tb es c2-1
			b2+=Ay[i]; //tb es d2-1
			c1+=potencia(Ax[i]);
			d1+=potencia(Ay[i]);
						
		}
		c2=potencia(b1);
		d2=potencia(b2);
		A=N*a1;
		B=b1*b2;
		C=(N*c1)-c2;
		D=(N*d1)-d2;
		r=(A-B)/(Math.sqrt(C*D));
		return r;
	}
	
	private static double media(double Ax[])
	{
		double aux=0;
		for(int i=0;i<Ax.length;i++)
		{
				aux+=Ax[i];
		}
		return aux/Ax.length;
	}
	
	public static double potencia(double base)
	{
		
		return base*base;
	}
	
	public static void Proceso(int N) throws IOException
	{
		double Ax[]=new double[N];
		double Ay[]=new double[N];
		for (int i=0;i<N;i++)
		{
			System.out.print("x"+(i+1)+"=");
			Ax[i]=leer();
			System.out.print("y"+(i+1)+"=");
			Ay[i]=leer();
		}
		System.out.println();
		a=Calcular_a(N,Ax,Ay);
		b=Calcular_b(N,Ax,Ay);
		System.out.println("------------------------------");
		System.out.println("a="+a);
		System.out.println("b="+b);
		System.out.println("\tErr_a="+Calcular_error_a(N,Ax,Ay));
		System.out.println("\tErr_b="+Calcular_error_b(N,Ax,Ay));
		System.out.println("\t\tr="+Calcular_r(N,Ax,Ay));
		System.out.println("------------------------------");
	}
	
	public static void main(String args[]) throws IOException
	{
		
		System.out.println("-Ajuste por minimos cuadrados by CrashCool-")
		System.out.println("Introduzca N,(Para terminar valor negativo)");
		int N=(int)leer();
		
		
		while(N>0)
		{
			Proceso(N);
			System.out.println("Introduzca N");
			N=(int)leer();
			
		}
		
	}
}
