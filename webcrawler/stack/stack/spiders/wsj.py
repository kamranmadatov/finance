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
        name = "wsj"
        allowed_domains = ["wsj.com"]
	custom_settings = {'FEED_URI' : "../articles/"+queryName +".csv" }
        start_urls = ["https://www.wsj.com/search/term.html?KEYWORDS=" + queryName+ "&min-date=" + minDate + "&max-date" + maxDate +"&page=" + str(page) + "&daysback=2d&isAdvanced=true&andor=AND&sort=date-desc&source=wsjarticle,wsjblogs,wsjvideo,sitesearch",]
        def parse(self,response):
                articles = Selector(response).xpath('//div[@class="headline-container"]/h3[@class="headline"]')
                for article in articles:
                        item = StackItem()
                        item['domain'] = "wsj.com"
			item['title'] = article.xpath('a/text()').extract()[0]
                        item['url'] = article.xpath('a/@href').extract()[0]
                        yield item
