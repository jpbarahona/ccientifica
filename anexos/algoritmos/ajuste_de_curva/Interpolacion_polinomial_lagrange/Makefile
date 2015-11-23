CC = g++
TREE_TYPE = TWO_LEVEL_TREE
ODIR = OBJ
CFLAGS =  -O3 -Wall -D$(TREE_TYPE) -g

AR = fparser.cc parser.hh

_OBJ = fparser.o main.o
OBJ = $(patsubst %,$(ODIR)/%,$(_OBJ))

$(ODIR)/%.o: fparser4.5.2/%.cc
	$(CC) -c -o $@ $< $(CFLAGS)

$(ODIR)/%.o: %.cc
	$(CC) -c -o $@ $< $(CFLAGS)

all: $(OBJ)
	$(CC) -o lagrange $(OBJ) $(CFLAGS)

#all:
#	$(CC) -o test test.cc

clean:
	/bin/rm -f $(ODIR)/*.o lagrange lagrange.exe *~ ._* $(IDIR)/*~ $(IDIR)/._*

fparser.o: $(AR)
