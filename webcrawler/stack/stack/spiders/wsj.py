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
    allowed_domains = ["fool.com"]
    custom_settings = {'FEED_URI' : "../articles/"+queryName +".csv" }
    start_urls = ["https://www.fool.com/search/solr.aspx?q=" + queryName + "&sort=date&dataSource=article&handleSearch=true",]
    def parse(self,response):
        articles = Selector(response).xpath('//dl[@class="results"]/dt')
        for article in articles:
            item = StackItem()
            item['domain'] = "fool.com"
            item['title'] = article.xpath('a/text()').extract()[0]
            item['url'] = article.xpath('a/@href').extract()[0]
            yield item
