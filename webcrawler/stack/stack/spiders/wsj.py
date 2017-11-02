from __future__ import absolute_import
from scrapy import Spider
from scrapy.selector import Selector
from stack.items import StackItem

class StackSpider(Spider):
        queryName = raw_input("Enter a stock name, ticker: ").lower()
        name = "wsj"
        allowed_domains = ["wsj.com"]
        start_urls = ["https://www.wsj.com/search/term.html?KEYWORDS=" + queryName,]
        def parse(self,response):
                articles = Selector(response).xpath('//div[@class="headline-container"]/h3[@class="headline"]')
                for article in articles:
                        item = StackItem()
                        item['title'] = article.xpath('a/text()').extract()[0]
                        item['url'] = article.xpath('a/@href').extract()[0]
                        yield item
