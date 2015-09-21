TREE_TYPE = TWO_LEVEL_TREE
CC = g++
ODIR = OBJ
CFLAGS =  -O3 -Wall -D$(TREE_TYPE) -g

AR = fparser.cc fparser.hh

_OBJ = fparser.o main.o

OBJ = $(patsubst %,$(ODIR)/%,$(_OBJ))

$(ODIR)/%.o: %.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIR)/%.o: ../%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

.PHONY: 
	all clean

all:
	$(MAKE) fparser

fparser: $(OBJ)
	$(CC) -o ../Brent $(OBJ) $(CFLAGS)

clean: 
	/bin/rm -f $(ODIR)/*.o ../Brent *~ ._* $(IDIR)/*~ $(IDIR)/._* 

fparser.o: $(AR)
