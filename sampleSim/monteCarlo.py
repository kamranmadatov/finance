import numpy
import scipy
import scipy.stats
import csv


def mean_confidence_interval(data, confidence=0.95):
    a = 1.0 * numpy.array(data)
    n = len(a)
    m, se = numpy.mean(a), scipy.stats.sem(a)
    h = se * scipy.stats.t._ppf((1 + confidence) / 2., n - 1)
    return m - h, m, m + h


dates = []
close = []
opening = []
diff = []


with open('HistoricalQuotes.csv') as csvDataFile:
    csvReader = csv.reader(csvDataFile)
    next(csvReader)
    for row in csvReader:
        dates.append(row[0])
        close.append(row[1])
        opening.append(row[3])

close = map(float, close)
opening = map(float, opening)

for i in range(len(opening)):
    diff.append(close[i]-opening[i])


startValue = close[0]
expValue = numpy.mean(diff)
stdDev = numpy.std(diff)
currentValues = numpy.array([numpy.random.normal(expValue, stdDev, 1000) + startValue])
dayValues = [[startValue]] * 1000
for i in range(0, 1000):
    dayValues[i].append(currentValues[0, i])
for i in range(0, 10):
    inc = numpy.random.normal(expValue, stdDev, 1000)
    for j in range(0, 1000):
        currentValues[0, j] = inc[j] + currentValues[0, j]
        dayValues[j].append(currentValues[0, j])
currentValues.sort()
interval = mean_confidence_interval(currentValues[0])
print(interval[0] - startValue, interval[2] - startValue)
print(interval)
