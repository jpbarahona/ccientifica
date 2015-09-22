TREE_TYPE = TWO_LEVEL_TREE
CC = g++
ODIRBi = ../Bisection/OBJ
ODIRBr = ../Brent/OBJ
ODIRF = ../Fixed_point/OBJ
ODIRR = ../Regula_falsi/OBJ
ODIRS = ../Secant/OBJ
CFLAGS =  -O3 -Wall -D$(TREE_TYPE) -g

AR = fparser.cc fparser.hh

_OBJ = fparser.o main.o

OBJBi = $(patsubst %,$(ODIRBi)/%,$(_OBJ))
OBJBr = $(patsubst %,$(ODIRBr)/%,$(_OBJ))
OBJF = $(patsubst %,$(ODIRF)/%,$(_OBJ))
OBJR = $(patsubst %,$(ODIRR)/%,$(_OBJ))
OBJS = $(patsubst %,$(ODIRS)/%,$(_OBJ))

#Bisection
$(ODIRBi)/%.o: %.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRBi)/%.o: ../Bisection/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

#Brent
$(ODIRBr)/%.o: %.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRBr)/%.o: ../Brent/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

#Fixed point
$(ODIRF)/%.o: %.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRF)/%.o: ../Fixed_point/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

#Regula falsi
$(ODIRR)/%.o: %.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRR)/%.o: ../Regula_falsi/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

#Secant
$(ODIRS)/%.o: %.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIRS)/%.o: ../Secant/%.cc
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
	/bin/rm -f $(ODIRBi)/*.o ../Brent *~ ._* $(IDIR)/*~ $(IDIR)/._*
	/bin/rm -f $(ODIRBr)/*.o ../Brent *~ ._* $(IDIR)/*~ $(IDIR)/._*
	/bin/rm -f $(ODIRF)/*.o ../Brent *~ ._* $(IDIR)/*~ $(IDIR)/._*
	/bin/rm -f $(ODIRR)/*.o ../Brent *~ ._* $(IDIR)/*~ $(IDIR)/._*
	/bin/rm -f $(ODIRS)/*.o ../Brent *~ ._* $(IDIR)/*~ $(IDIR)/._*

fparser.o: $(AR)
