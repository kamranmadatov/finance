'''
Keyword Extractor Progress

input would be a CSV file formatted from the output of web crawler scrappy
'''


from newspaper import Article
import csv
import json
import nltk

with open('articles/tesla.csv') as csvNews:
  csvReader = csv.reader(csvNews)
  for row in csvReader:
    url = row[0].replace('{"url": "', '')
    domain = row[1].replace(' "domain": ', '')
    if "https" not in url: 
      url = 'https://www.' + domain + url
    url = url.replace('"', '')
    print(url)
    article = Article(url)
    article.download()
    article.parse()
    article.nlp()
    print(article.text)
