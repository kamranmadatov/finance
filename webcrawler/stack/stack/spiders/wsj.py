from __future__ import absolute_import
from scrapy import Spider
from scrapy.selector import Selector
from stack.items import StackItem
import os

class StackSpider(Spider):
    queryName = str(input("Enter a stock name, ticker: ")).lower()
    minDate = "2017/07/04"
    maxDate = "2017/11/02"
    page = 1
    name = "wsj"
    allowed_domains = ["money.cnn.com", "cnn.com"]
    custom_settings = {'FEED_URI' : "../articles/"+queryName +".csv" }
    start_urls = ["http://money.cnn.com/search/index.html?sortBy=date&primaryType=mixed&search=Search&query=%s" % queryName]
    def parse(self,response):
        articles = Selector(response).xpath('//div[@class="summaryBlock"]/div[@class="cnnHeadline"]')
        for article in articles:
            item = StackItem()
            item['domain'] = "cnbc.com"
            item['title'] = article.xpath('a/text()').extract()[0]
            item['url'] = article.xpath('a/@href').extract()[0]
            yield item
