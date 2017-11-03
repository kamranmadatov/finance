from __future__ import absolute_import
from scrapy import Spider
from scrapy.selector import Selector
from stack.items import StackItem


class StackSpider(Spider):
        queryName = raw_input("Enter a stock name, ticker: ").lower()
        name = "thestreet"
        allowed_domains = ["thestreet.com"]
        start_urls = ["https://www.thestreet.com/find/results?q=" + queryName + "&redirectQuote=true",]
        def parse(self,response):
                articles = Selector(response).xpath('//div[@class="news-list-compact__body"]')
                for article in articles:
                        item = StackItem()
                        item['title'] = article.xpath('a/h3[@class="news_list-compact__headline"]/text()').extract()[0]
                        item['url'] = article.xpath('a/@href').extract()[0]
                        yield item
