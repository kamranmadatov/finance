import urllib.request
import ssl
from datetime import date

# Ignore SSL verification
ssl._create_default_https_context = ssl._create_unverified_context

# Link for downloading CSV
# https://finance.google.com/finance/historical?q=MSFT&startdate=may+1+2010&output=csv

# Retrieve webpage as string
tickerName = input("Enter a stock ticker: ").lower()
date = date.today().year - 10
response = urllib.request.urlopen("https://finance.google.com/finance/historical?q=" + tickerName + "&startdate=jan+1+" + str(date) + "&output=csv")

csv = response.read()

with open(tickerName + '.csv', 'wb') as f:
   f.write(csv)

# Save the string to a file
# csvstr = str(csv).strip("b'")

#lines = csvstr.split("\\n")
#f = open("historical.csv", "w")
#for line in lines:
#   f.write(line + "\n")
#f.close()




