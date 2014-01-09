CC=gcc
CFLAGS=-O2 -g -pipe -Wall -std=gnu99
TARGET=ps4-wake

all:
	$(CC) $(CFLAGS) $(TARGET).c -o $(TARGET)

clean:
	rm -f $(TARGET)

