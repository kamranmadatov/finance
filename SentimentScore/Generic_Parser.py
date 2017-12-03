"""
Program to provide generic parsing for all files in user-specified directory.
The program assumes the input files have been scrubbed,
  i.e., HTML, ASCII-encoded binary, and any other embedded document structures that are not
  intended to be analyzed have been deleted from the file.

Dependencies:
    Python:  Load_MasterDictionary.py
    Data:    LoughranMcDonald_MasterDictionary_2014.csv

The program outputs:
   1.  File name
   2.  File size (in bytes)
   3.  Number of words (based on LM_MasterDictionary
   4.  Proportion of positive words (use with care - see LM, JAR 2016)
   5.  Proportion of negative words
   6.  Proportion of uncertainty words
   7.  Proportion of litigious words
   8.  Proportion of modal-weak words
   9.  Proportion of modal-moderate words
  10.  Proportion of modal-strong words
  11.  Proportion of constraining words (see Bodnaruk, Loughran and McDonald, JFQA 2015)
  12.  Number of alphanumeric characters (a-z, A-Z, 0-9)
  13.  Number of alphabetic characters (a-z, A-Z)
  14.  Number of digits (0-9)
  15.  Number of numbers (collections of digits)
  16.  Average number of syllables
  17.  Averageg word length
  18.  Vocabulary (see Loughran-McDonald, JF, 2015)

  ND-SRAF
  McDonald 2016/06
"""

import csv
import glob
import re
import string
import sys
import time
sys.path.append('./Modules')  # Modify to identify path for custom modules
import Load_MasterDictionary as LM

# User defined directory for files to be parsed
TARGET_FILES = r'./TestParse/*.*'
# User defined file pointer to LM dictionary
MASTER_DICTIONARY_FILE = r'LoughranMcDonald_MasterDictionary_2014.csv'
# User defined output file
OUTPUT_FILE = r'./Temp/Parser.csv'
# Setup output
OUTPUT_FIELDS = ['url,','date,','file name,', 'file size,', 'number of words,', 'sentiment score,','% positive,', '% negative,',
                 '% uncertainty,', '% litigious,', '% modal-weak,', '% modal moderate,',
                 '% modal strong,', '% constraining,', '# of alphanumeric,', '# of digits,',
                 '# of numbers,', 'avg # of syllables per word,', 'average word length,', 'vocabulary']

lm_dictionary = LM.load_masterdictionary(MASTER_DICTIONARY_FILE, True)


def main():

    f_out = open(OUTPUT_FILE, 'w')
    wr = csv.writer(f_out, lineterminator='\n')
    wr.writerow(OUTPUT_FIELDS)

    file_list = glob.glob(TARGET_FILES)
    for file in file_list:
        print(file)
        with open(file, 'r', encoding='UTF-8', errors='ignore') as f_in:
            doc = f_in.read()
        doc_len = len(doc)
        doc = re.sub('(May|MAY)', ' ', doc)  # drop all May month references
        doc = doc.upper()  # for this parse caps aren't informative so shift

        output_data = get_data(doc)
        output_data[0] = "url"
        output_data[1] = "date"
        output_data[2] = file
        output_data[3] = doc_len
        output_data[5] = output_data[6]-output_data[7] #positive vs negative
        wr.writerow(output_data)

def createDoc():

    f_out = open(OUTPUT_FILE, 'w')
    wr = csv.writer(f_out, lineterminator='\n')
    wr.writerow(OUTPUT_FIELDS)

def getArticle(url,date,title,body):

    f_out = open(OUTPUT_FILE, 'a')
    wr = csv.writer(f_out, lineterminator='\n')
    

    print(title)
    
    
    doc_len = len(body)
    body = re.sub('(May|MAY)', ' ', body)  # drop all May month references
    body = body.upper()  # for this parse caps aren't informative so shift

    output_data = get_data(body)
    output_data[0] = url
    output_data[1] = date
    output_data[2] = title
    output_data[3] = doc_len
    output_data[5] = output_data[6]-output_data[7]
    wr.writerow(output_data)






##def wrAnalysis(stock,date, sentimentScore) 
##    myFile = open('countries.csv', 'w')  
##        with myFile:  
##            myFields = [date[0], data[1]]
##            writer = csv.DictWriter(myFile, fieldnames=myFields)    
##            writer.writeheader()
##            writer.writerow({'country' : 'France', 'capital': 'Paris'})
##            writer.writerow({'country' : 'Italy', 'capital': 'Rome'})
##            writer.writerow({'country' : 'Spain', 'capital': 'Madrid'})
##            writer.writerow({'country' : 'Russia', 'capital': 'Moscow'})
##
##    
def get_data(doc):

    vdictionary = {}
    _odata = [0] * 20
    total_syllables = 0
    word_length = 0
    
    tokens = re.findall('\w+', doc)  # Note that \w+ splits hyphenated words
    for token in tokens:
        if not token.isdigit() and len(token) > 1 and token in lm_dictionary:
            _odata[4] += 1  # word count
            word_length += len(token)
            if token not in vdictionary:
                vdictionary[token] = 1
            if lm_dictionary[token].positive: _odata[6] += 1
            if lm_dictionary[token].negative: _odata[7] += 1
            if lm_dictionary[token].uncertainty: _odata[8] += 1
            if lm_dictionary[token].litigious: _odata[9] += 1
            if lm_dictionary[token].weak_modal: _odata[10] += 1
            if lm_dictionary[token].moderate_modal: _odata[11] += 1
            if lm_dictionary[token].strong_modal: _odata[12] += 1
            if lm_dictionary[token].constraining: _odata[13] += 1
            total_syllables += lm_dictionary[token].syllables

    _odata[14] = len(re.findall('[A-Z]', doc))
    _odata[15] = len(re.findall('[0-9]', doc))
    # drop punctuation within numbers for number count
    doc = re.sub('(?!=[0-9])(\.|,)(?=[0-9])', '', doc)
    doc = doc.translate(str.maketrans(string.punctuation, " " * len(string.punctuation)))
    _odata[16] = len(re.findall(r'\b[-+\(]?[$€£]?[-+(]?\d+\)?\b', doc))
    _odata[17] = total_syllables / _odata[4]
    _odata[18] = word_length / _odata[4]
    _odata[19] = len(vdictionary)
    
    
    # Convert counts to %
    for i in range(6, 12 + 1):
        _odata[i] = (_odata[i] / _odata[4]) * 100
    # Vocabulary
     
    return _odata


if __name__ == '__main__':
    print('\n' + time.strftime('%c') + '\nGeneric_Parser.py\n')
    main()
    print('\n' + time.strftime('%c') + '\nNormal termination.')
