"""
Pangrams - sentences with all US alphabet. Find letters missing in alphabet
@author - Kestutis ITDev
@date - 2013.07.14
@email - kestutis.itsolutions@gmail.com
@description - CodeEval Challenge #31, Print missing letters in pangrams
@version - 1.0
"""
__author__ = 'Kestutis ITDev'

#Read lines from console
from sys import argv
#Get a list of ascii lowercase letters
from string import ascii_lowercase

#command line interface?
cli = True

if cli:
    file = argv[1]
else:
    file = 'Data31.txt'

"""
@param sentence - the sentence, to be used for a search
@param ABC - the dictionary
@return - missing letters from 'ABC' in a 'sentence'
"""
def getMissingABCLetters(sentence, ABC):
    #what to return
    ret = ""

    for theChar in ABC:
        #Get total char occurrences in sentence
        if sentence.count(theChar) == 0:
            ret += theChar

    if len(ret) == 0:
        return "NULL"
    else:
        return ret


#This is all our lowercase letters we need
listOfLowercaseLetters = ascii_lowercase

#debug
#print(["ABC:", listOfLowercaseLetters])

#open file for reading
textLines = open(file, 'r')

for line in textLines:
    #break the loop in case of empty line
    if line == '\n':
        break

    line = line.rstrip()
    #debug
    #print("-------------------------------")
    #print("LINE:", line)   

    #pass lowercase sentence and list of lowercase letters
    missingLetters = getMissingABCLetters(line.lower(), listOfLowercaseLetters)

    #print missing letters
    print(missingLetters)

#close the file
textLines.close()