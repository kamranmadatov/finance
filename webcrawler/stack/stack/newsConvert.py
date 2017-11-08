from newspaper3k import Article
import csv

with open('articles/tesla.csv') as csvNews:
	csvReader = csv.reader(csvNews)
	for row in csvReader:
		print(row)
