from __future__ import absolute_import
from scrapy import Spider
from scrapy.selector import Selector
from thestreet.items import ThestreetItem

queryName = raw_input("Enter a stock name, ticker: ").lower()

class StackSpider(Spider):
	name = "stack"
	allowed_domains = ["thestreet.com"]
	start_urls = ["https://www.thestreet.com/find/results?q=" + queryName + "&redirectQuote=true",]
    
	def parse(self,response):
		articles = Selector(response).xpath('//div[@class="news-list-compact__body"]/a')
		for article in articles:
			item = StackItem()
			item['title'] = article.xpath('h3[@class="news_list-compact__headline"]/text()').extract()[0]
			item['url'] = article.xpath('@href').extract()[0]
			yield item
	
