from __future__ import absolute_import
from scrapy import Spider
from scrapy.selector import Selector
from stack.items import StackItem
import os

class StackSpider(Spider):
        queryName = str(raw_input("Enter a stock name, ticker: ")).lower()
	minDate = "2017/07/04"
	maxDate = "2017/11/02"
	page = 1
        name = "bloomberg"
        allowed_domains = ["bloomberg.com"]
	custom_settings = {'FEED_URI' : "../articles/"+queryName +".csv" }
        start_urls = ["https://www.bloomberg.com/search?query=" + queryName + "&startTime=-1m&sort=time:desc&endTime=2017-11-10T00:08:18.617Z&page=1",]
        def parse(self,response):
                articles = Selector(response).xpath('//div[@class="search-result-story__container"]/h1[@class="search-result-story__headline"]')
                for article in articles:
                        item = StackItem()
                        item['domain'] = "bloomberg.com"
			item['title'] = article.xpath('a/text()').extract()[0]
                        item['url'] = article.xpath('a/@href').extract()[0]
                        yield item
