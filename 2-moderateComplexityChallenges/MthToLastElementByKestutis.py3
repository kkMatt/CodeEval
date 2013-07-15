"""
Mth to last element
@author - Kestutis ITDev
@date - 2013.07.14
@email - kestutis.itsolutions@gmail.com
@description - CodeEval Challenge #30, Print the M-th from the end element
@version - 1.0
"""
__author__ = 'Kestutis ITDev'

"""Read lines from console"""
from sys import argv

#command line interface?
cli = True

if cli:
    file = argv[1]
else:
    file = 'Data30.txt'

#open file for reading
textLines = open(file, 'r')

for line in textLines:
    #break the loop in case of empty line
    if line == '\n':
        break

    line = line.rstrip()


    #split elements to array
    elements = line.split(' ')

    #get line length
    totalElements = len(elements)

    #get info which char from end to retrieve
    charPosFromEndToRetrieve = int(elements[len(elements)-1])

    #get required char
    charPosToRetrieve = len(elements)-1-charPosFromEndToRetrieve

    #DEBUG
    #print(["line content: [", line, "]"])
    #print (["charPosFromEndToRetrieve: ", charPosFromEndToRetrieve])
    #print (["charPosFromEndToRetrieve: ", charPosFromEndToRetrieve])

    if charPosToRetrieve >= 0:
        charToRetrieve = elements[charPosToRetrieve]

        #print the requested character
        print(charToRetrieve)

#close the file
textLines.close()
