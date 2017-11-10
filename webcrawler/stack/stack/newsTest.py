from newspaper import Article

url = 'https://www.wsj.com/articles/electric-vehicle-tax-credit-proposal-slows-tesla-detroit-1509732413'
article = Article(url)
#article.download()
article.parse()
print(article.text)
