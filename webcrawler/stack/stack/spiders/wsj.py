from __future__ import absolute_import
from scrapy import Spider
from scrapy.selector import Selector
from stack.items import StackItem
from scrapy_splash import SplashRequest
import datetime
from newspaper import Article
import os


def getDate(url, domain):
    if ("http" not in url) and (domain not in url):
        url = 'https://www.' + domain + url
        url = url.replace('"', '')
    article = Article(url)
    try:
        article.download()
        article.parse()
        article.nlp()
        return article.publish_date
    except:
        pass
    return 'None'

#
# class StackSpider(Spider):
#     queryName = str(input("Enter a stock name, ticker: ")).lower()
#     minDate = "2017/07/04"
#     maxDate = "2017/11/02"
#     page = 1
#     name = "wsj"
#     allowed_domains = ["money.cnn.com", "cnn.com"]
#     custom_settings = {'FEED_URI' : "../articles/"+queryName +".csv" }
#     start_urls = ["http://money.cnn.com/search/index.html?sortBy=date&primaryType=mixed&search=Search&query=%s" % queryName]
#     def start_requests(self):
#         for url in self.start_urls:
#             yield SplashRequest(url, self.parse,
#                 endpoint='render.html',
#                 args={'wait': 0.5},
#                 )
#
#     def parse(self,response):
#         articles = Selector(response).xpath('//div[@class="summaryList"]/div[@class="summaryBlock"]/div[@class="cnnHeadline"]')
#         if(articles):
#             for article in articles:
#                 date = getDate(article.xpath('a/@href').extract()[0], "money.cnn.com")
#                 print(date.date())
#         else:
#             print("Didn't catch any articles")

class StackSpider(Spider):
    queryName = str(input("Enter a stock name, ticker: ")).lower()
    minDate = "2017/07/04"
    maxDate = "2017/11/02"
    page = 1
    name = "wsj"
    custom_settings = {'FEED_URI' : "../articles/"+queryName +".csv" }
    start_urls = ["https://www.economist.com/search?q=%s" % queryName]
    def parse(self,response):
        articles = Selector(response).xpath('//td[@class="gsc-table-cell-snippet-close"]/div[@class="gs-title gsc-table-cell-thumbnail gsc-thumbnail-left"]')
        if(articles):
            for article in articles:
                date = getDate(article.xpath('a/@href').extract()[0], "reuters.com")
                print(date.date())
        else:
            print("Didn't catch any articles")