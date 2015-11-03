TREE_TYPE = TWO_LEVEL_TREE
CC = g++
ODIRBi = metodos/Bisection/OBJ
ODIRBr = metodos/Brent/OBJ
ODIRF = metodos/Fixed_point/OBJ
ODIRR = metodos/Regula_falsi/OBJ
ODIRS = metodos/Secant/OBJ
CFLAGS =  -O3 -Wall -D$(TREE_TYPE) -g

AR = fparser4.5.2/fparser.cc fparser4.5.2/fparser.hh
MR = INCLUDE/raiz.cc INCLUDE/raiz.hh

_OBJ = raiz.o fparser.o main.o

OBJBi = $(patsubst %,$(ODIRBi)/%,$(_OBJ))
OBJBr = $(patsubst %,$(ODIRBr)/%,$(_OBJ))
OBJF = $(patsubst %,$(ODIRF)/%,$(_OBJ))
OBJR = $(patsubst %,$(ODIRR)/%,$(_OBJ))
OBJS = $(patsubst %,$(ODIRS)/%,$(_OBJ))

#Bisection
$(ODIRBi)/%.o: fparser4.5.2/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRBi)/%.o: metodos/Bisection/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRBi)/%.o: INCLUDE/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

#Brent
$(ODIRBr)/%.o: fparser4.5.2/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRBr)/%.o: metodos/Brent/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRBr)/%.o: INCLUDE/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)	

#Fixed point
$(ODIRF)/%.o: fparser4.5.2/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRF)/%.o: metodos/Fixed_point/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRF)/%.o: INCLUDE/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

#Regula falsi
$(ODIRR)/%.o: fparser4.5.2/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRR)/%.o: metodos/Regula_falsi/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRR)/%.o: INCLUDE/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

#Secant
$(ODIRS)/%.o: fparser4.5.2/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRS)/%.o: metodos/Secant/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRS)/%.o: INCLUDE/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

.PHONY: 
	all clean

all:
	$(MAKE) Bisection Brent Fixed_point Regula_falsi Secant

#All .exe
Bisection: $(OBJBi)
	$(CC) -o ../Bisection $(OBJBi) $(CFLAGS)

Brent: $(OBJBr)
	$(CC) -o ../Brent $(OBJBr) $(CFLAGS)

Fixed_point: $(OBJF)
	$(CC) -o ../Fixed_point $(OBJF) $(CFLAGS)

Regula_falsi: $(OBJR)
	$(CC) -o ../Regula_falsi $(OBJR) $(CFLAGS)

Secant: $(OBJS)
	$(CC) -o ../Secant $(OBJS) $(CFLAGS)

clean:
	/bin/rm -f $(ODIRBi)/*.o ../Bisection *~ ._* $(IDIR)/*~ $(IDIR)/._*
	/bin/rm -f $(ODIRBr)/*.o ../Brent *~ ._* $(IDIR)/*~ $(IDIR)/._*
	/bin/rm -f $(ODIRF)/*.o ../Fixed_point *~ ._* $(IDIR)/*~ $(IDIR)/._*
	/bin/rm -f $(ODIRR)/*.o ../Regula_falsi *~ ._* $(IDIR)/*~ $(IDIR)/._*
	/bin/rm -f $(ODIRS)/*.o ../Secant *~ ._* $(IDIR)/*~ $(IDIR)/._*

fparser.o: $(AR)
raiz.o: $(MR)
