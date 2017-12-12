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
from scrapy import Request
from scrapy.spiders import Rule
from scrapy.linkextractors import LinkExtractor
from twisted.internet import reactor
from scrapy.crawler import CrawlerRunner
from scrapy.utils.log import configure_logging
import datetime
from newspaper import Article
import sys
sys.path.append('/Users/bthai/Desktop/venv/finance/SentimentScore')
import Generic_Parser as GP

class StackItem(Item):
    domain = Field()
    title = Field()
    url = Field()

def articleConversion(url, domain):
    if ("http" not in url) and (domain not in url):
        url = 'https://www.' + domain + url
        url = url.replace('"', '')
    article = Article(url)
    try:
        article.download()
        article.parse()
        article.nlp()
        GP.getArticle(url,article.publish_date.date(),'test',article.text)
    except:
        pass
    return

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

class GenericSpider(Spider):
    name = "generic"
    def __init__(self, domain=None, name=None, days=None, *args, **kwargs):
            super(GenericSpider,self).__init__(*args, **kwargs)
            self.custom_settings = {'FEED_URI' : "/%s.csv" % name }
            self.domain = domain
            self.page = 1
            self.maxDate = datetime.date.today()
            #self.maxDate = datetime.date.today() - datetime.timedelta(32, 0, 0)
            self.minDate = self.maxDate - datetime.timedelta(days, 0, 0)
            self.count = 0
            if (domain == "wsj.com"):
                self.start_urls = ["https://www.wsj.com/search/term.html?KEYWORDS=%s" % name ]
            elif (domain == "bloomberg.com"):
                self.start_urls = ["https://www.bloomberg.com/search?query=%s&sort=time:desc" % name]
                #self.start_urls = ["https://www.bloomberg.com/search?query=%s&sort=time:desc&endTime=2017-11-09T23:26:35.497Z" % name]
                Rules = (Rule(LinkExtractor(allow=(), restrict_xpaths=('//a[@class="content-next-link"]',)), callback="parse", follow= True),)
            elif (domain == "fool.com"):
                self.start_urls = ["https://www.fool.com/search/solr.aspx?q=%s&sort=date&dataSource=article&handleSearch=true" % name]
                Rules = (Rule(LinkExtractor(allow=(), restrict_xpaths=('//a[@class="rounded pageNext"]',)), callback="parse", follow= True),)
            elif (domain == "cnn.com"):
                self.start_urls = ["http://money.cnn.com/search/index.html?sortBy=date&primaryType=mixed&search=Search&query=%s" % name]
            elif (domain == "cnbc.com"):
                self.start_urls = ["https://search.cnbc.com/rs/search/view.html?partnerId=2000&keywords=%s&sort=date&type=news&source=CNBC.com&pubtime=0&pubfreq=a" % name]
                Rules = (Rule(LinkExtractor(allow=(), restrict_xpaths=('//div[@id="rightPagCol"]',)), callback="parse", follow= True),)
    def parse(self,response):

        print(self.maxDate , self.minDate)
        if (self.domain == "wsj.com"):
            articles = Selector(response).xpath('//div[@class="headline-container"]/h3[@class="headline"]')
        elif (self.domain == "bloomberg.com"):
            articles = Selector(response).xpath('//div[@class="search-result-story__container"]/h1[@class="search-result-story__headline"]')
            next_page = response.xpath('.//a[@class="content-next-link"]/@href').extract()
        elif (self.domain == "fool.com"):
            articles = Selector(response).xpath('//dl[@class="results"]/dt')
            next_page = response.xpath('.//a[@class="rounded pageNext"]/@href').extract()
        elif (self.domain == "cnn.com"):
            articles = Selector(response).xpath('//div[@class="summaryBlock"]/div[@class="cnnHeadline"]')
        elif (self.domain == "cnbc.com"):
            articles = Selector(response).xpath('//div[@class="SearchResultCard"]/h3[@class="title"]')
            next_page = response.xpath('.//div[@id="rightPagCol"]/a/@href').extract()
        for article in articles:
            #do page parsing by "next" button (The Motley Fool, Bloombergh, MoneyCNN
            date = getDate(article.xpath('a/@href').extract()[0], self.domain)
            try:
                date = date.date()
                if(date <= self.maxDate and date >= self.minDate):
                    articleConversion(article.xpath('a/@href').extract()[0], self.domain)
                    print(date)
            except:
                pass
        try:
            if (date > self.minDate):
                if next_page:
                    self.page+= 1
                    print("Next page checked! " + str(self.page));
                    next_href = '&page=' + str(self.page)
                    next_page_url = self.start_urls[0] + next_href
                    request = Request(url=next_page_url)
                    yield request
        except:
            pass
            #pass article, but check published date to determine time period... whether we keep parsing



def runCrawlers():
    #ask user for company's name
    queryName = str(input("Enter a company's name : ")).lower()
    daysBack = int(input("Enter how many days back: "))
    configure_logging()
    runner = CrawlerRunner()
    GP.createDoc()
    #create instance of spider and pass argument
    #runner.crawl(GenericSpider, domain="barrons.com", name=queryName)
    runner.crawl(GenericSpider, domain="bloomberg.com", name=queryName, days=daysBack)
    runner.crawl(GenericSpider, domain="fool.com", name=queryName,days=daysBack)
    #runner.crawl(GenericSpider, domain="cnbc.com", name=queryName)
    d = runner.join()
    d.addBoth(lambda _: reactor.stop())

    reactor.run() #script will end until all jobs are finished

runCrawlers()