#ifndef _MAIN_HH
#define _MAIN_HH

#include "../fparser4.5.2/fparser.hh"

#include <iostream> /* std::cout, std::cin, std::endl */
#include <fstream> /* std::fstream, open(), is_open(), clear(), close(), std::ifstream */
#include <cstring> /* strcpy(), compare */
#include <string> /* c_str(), length(), std::string*/
#include <cstdlib> /* malloc, free, rand, atoi, atof (return double value) */
#include <algorithm> /* transform */
#include <cmath> /* abs() */
#include <iomanip> /* std::setw(), std::setprecision*/

char * fichero (std::string dir, std::string lenguaje, std::string fundamento, std::string metodo, std::string stream, std::string ext, int count);
char * digitos (int dig_len, int limit, int start);
double f (FunctionParser fparser, double x);
double dvalue(int pos_cstr, char* cstr);

#endif