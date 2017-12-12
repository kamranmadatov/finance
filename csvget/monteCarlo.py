import numpy
import scipy
import scipy.stats
import csv

#Function to calculate the 95% confidence interval
def mean_confidence_interval(data, confidence=0.95):
    n = len(data)
    m = numpy.mean(data)
    se = scipy.stats.sem(data)
    h = se * scipy.stats.t._ppf((1 + confidence) / 2., n - 1)
    return m - h, m, m + h

#Function to run tests on the simulation
def sim_test(dates, opening, close):
    first_close = close[:365]
    first_opening = opening[:365]
    first_diff = []
    second_close = close[365:]
    second_opening = opening[365:]
    second_diff = []
    diff_between = []
    predicted_high = []
    predicted_mid = []
    predicted_low = []
    error_high = []
    error_mid = []
    error_low = []

    for i in range(365):
        interval = monte_carlo(second_opening, second_close, i)
        predicted_high.append(interval[2])
        predicted_mid.append(interval[1])
        predicted_low.append(interval[0])
        error_high.append(interval[2] - float(first_opening[len(first_opening) - i-1]))
        error_mid.append(interval[1] - float(first_opening[len(first_opening) - i-1]))
        error_low.append(interval[0] - float(first_opening[len(first_opening) - i-1]))

    with open('predict_cnc_10.csv', 'w') as csvfile:
        predictwriter = csv.writer(csvfile, delimiter=',', quotechar='|', quoting=csv.QUOTE_MINIMAL)
        predictwriter.writerow(['low']  + ['mid'] + ['high'] + ['actual'])
        for i in range(len(predicted_low)):
            predictwriter.writerow([predicted_low[i]] + [predicted_mid[i]] + [predicted_high[i]]+[first_opening[len(first_opening) - i - 1]])

#Function to read from a csv file and convert the data to be used in the model
def csv_reader(dates, close, opening):
    with open('cnc.csv') as csvDataFile:
        csvReader = csv.reader(csvDataFile)
        next(csvReader)
        for row in csvReader:
            dates.append(row[0])
            close.append(row[4])
            opening.append(row[1])
    close = list(map(float, close))
    opening = list(map(float, opening))

#Function to simulate stock prices over a period of days
def monte_carlo(opening, close, days):
    diff = []
    for i in range(len(opening) - 1):
        #diff.append(float(close[i+1]) - float(opening[i+1]))
        diff.append(float(opening[i])-float(opening[i+1]))
    startValue = float(opening[0])
    expValue = numpy.mean(diff)
    stdDev = numpy.std(diff)
    currentValues = numpy.array([numpy.random.normal(expValue, stdDev, 1000) + startValue])
    dayValues = [[startValue]] * 1000
    for i in range(0, 1000):
        dayValues[i].append(currentValues[0, i])
    for i in range(0, days):
        inc = numpy.random.normal(expValue, stdDev, 1000)
        for j in range(0, 1000):
            currentValues[0, j] = inc[j] + currentValues[0, j]
            dayValues[j].append(currentValues[0, j])
    currentValues.sort()
    interval = mean_confidence_interval(currentValues[0])
    #print(interval[0] - startValue, interval[2] - startValue)
    return(interval)

dates = []
close = []
opening = []
#diff = []
csv_reader(dates, close, opening)
#print(monte_carlo(opening, 1000))
sim_test(dates, opening, close)

