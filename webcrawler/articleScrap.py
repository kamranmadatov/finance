'''

Must grab

*dates to distinguish articles by days on positive vs negative articles
--> how to get date? article.publish_date does not work, have to manually get?

*Possibly list data as a date, a list of score is pos - neg = score, neg is bad day
--> Nov 10, 2017 - 3,4,3,1,2,4,-1,2
--> compute average?



'''

from scrapy.selector import Selector
from scrapy import Item,Field
from scrapy import Spider
from twisted.internet import reactor
from scrapy.crawler import CrawlerRunner
from scrapy.utils.log import configure_logging
from newspaper import Article
from datetime import date

class StackItem(Item):
    domain = Field()
    title = Field()
    url = Field()

def articleConversion(url, domain):
    if ("https" not in url) or ("http" not in url):
        url = 'https://www.' + domain + url
        url = url.replace('"', '')
        print(url)
        article = Article(url)
        article.download()
        article.parse()
        article.nlp()
        print(article.text)
        #publish date print does not work
        #print(article.publish_date)
    return url

class GenericSpider(Spider):
    name = "generic"
    def __init__(self, domain=None, name=None, *args, **kwargs):
            super(GenericSpider,self).__init__(*args, **kwargs)
            minDate = "2017/07/04"
            #d = date.today()
            maxDate = "2017/11/21"
            page = 1
            self.custom_settings = {'FEED_URI' : "/%s.csv" % name }
            self.domain = domain
            if (domain == "wsj.com"):
                self.start_urls = ["https://www.wsj.com/search/term.html?KEYWORDS=%s&min-date=%s&max-date=%s&page=%s&daysback=2d&isAdvanced=true&andor=AND&sort=date-desc&source=wsjarticle,wsjblogs,wsjvideo,sitesearch" % (name, minDate, maxDate, str(page)),]
            elif (domain == "bloomberg.com"):
                self.start_urls = ["https://www.bloomberg.com/search?query=%s&startTime=-1m&sort=time:desc&endTime=%sT00:08:18.617Z&page=1" % (name, maxDate)]
            elif (domain == "fool.com"):
                self.start_urls = ["https://www.fool.com/search/solr.aspx?q=%s&sort=date&dataSource=article&handleSearch=true" % name]
    def parse(self,response):
            if (self.domain == "wsj.com"):
                articles = Selector(response).xpath('//div[@class="headline-container"]/h3[@class="headline"]')
            elif (self.domain == "bloomberg.com"):
                articles = Selector(response).xpath('//div[@class="search-result-story__container"]/h1[@class="search-result-story__headline"]')
            elif (self.domain == "fool.com"):
                articles = Selector(response).xpath('//dl[@class="results"]/dt')
            for article in articles:
                #item = StackItem()
                #item['domain'] = self.domain
                #item['title'] = article.xpath('a/text()').extract()[0]
                #item['url'] = article.xpath('a/@href').extract()[0]
                #yield item

                #possibly sort by date of good/bad articles
                url = articleConversion(article.xpath('a/@href').extract()[0], self.domain)



def runCrawlers():
    #ask user for company's name
    queryName = str(input("Enter a company's name : ")).lower()
    configure_logging()
    runner = CrawlerRunner()
    #create instance of spider and pass argument
    runner.crawl(GenericSpider, domain="wsj.com", name=queryName)
    runner.crawl(GenericSpider, domain="bloomberg.com", name=queryName)
    #runner.crawl(GenericSpider, domain="fool.com", name=queryName)
    d = runner.join()
    d.addBoth(lambda _: reactor.stop())

    reactor.run() #script will end until all jobs are finished

runCrawlers()