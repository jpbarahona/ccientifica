#include "raiz.hh"

double f (FunctionParser fparser, double x){
	double vals[] = { 0 };
	
    vals[0] = x;
	
	return fparser.Eval(vals);
}

double dvalue(int pos_cstr, char* cstr){
	int j = 0;
	char * cstrcpy = new char[25];
	
	do
	{
		cstrcpy[j]=cstr[pos_cstr];
		pos_cstr++;j++;
	}while(cstr[pos_cstr] != '\0');
	
	return atof(cstrcpy);
}

char * fichero (std::string dir, std::string lenguaje, std::string fundamento, std::string metodo, std::string stream, std::string ext, int count){
	/*
	* El nombre final del fichero se identificará con el criterio de acontinuación, las cuales contendran informacion importante de
	* solo sus iniciales:
	*		  			"lenguaje""fundamento""método""n°fichero""stream""extencion"
	* 
	* Ejemplo: CCERBI000OUT.txt -  CCERBI000OUT.php - CCERBI000OUT.py ...
	* 
	* out: Directorio salida.
	* name: Nombre inicial del fichero. ("lenguaje""fundamento""método")
	*/

	char * digitos (int dig_len, int limit, int start);

	std::string str = lenguaje + fundamento + metodo + "000";
	transform(str.begin(), str.end(), str.begin(), ::toupper);
	transform(stream.begin(), stream.end(), stream.begin(), ::toupper);
	std::string str2 = stream + "." + ext;
	std::string str1 = dir + "/" + str;

	std::string salida = str1 + str2;

	int len = str1.length();
	char * cstr = (char *)malloc(len+15);
	char * c;
	std::fstream of;
	strcpy(cstr,salida.c_str());

	cstr[len-3] = '0';
	cstr[len-2] = '0';
	cstr[len-1] = '1';

	for (int i = 1; i <= count; ++i)
	{
		c = digitos(3,i+1,i);
		cstr[len-3] = c[0];
		cstr[len-2] = c[1];
		cstr[len-1] = c[2];
		of.open(cstr);
		if (!of.is_open())
		{
			of.clear();
			of.open(cstr, std::fstream::in | std::fstream::out | std::fstream::app);
			of.close();
			break;
		}
		of.close();
	}
	
	return cstr;
}

char * digitos (int dig_len, int limit, int start){
	char * c = (char *)malloc(sizeof(dig_len));
	int i = start,n = limit;

	if((start/10)%10 < 10 && (start/10)%10 > 0){
		c[1] = (start/10)%10 +'0';
	}else c[1] = '0';
	if(start/100 < 10 && start/100 > 0){
		c[0] = start/100 +'0';
	}else c[0] = '0';
	if(i%10 == 0){ c[2] = '0'; return c;}
	else{
		i = i%10;
		int j = (start/10)%10 * 10 ;
		n = n-j;
		if(start/100>0){
			int p = (start/100)%10 * 100 ;
			n = n - p;
		}
	}
	while (i<n)
	{
		c[2] = i+'0';
		if(c[2] == '9' && i+1 != n){
			if(c[1] == '9' && i+1 != n)
			{
				c[1] = '0';
				c[0] ++;
			}else c[1] ++;
			i = -1;
			n = n-10;
		}
		i++;
	}

	return c;
}