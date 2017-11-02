install.packages("dplyr")
library(dplyr)
stockValues <- read.csv(fileName)
stockValues <- tbl_df(stockValues)
startValue <- stockValues$close[1]
stockValues <- mutate(stockValues, incr = close-open)
expValue <- mean(stockValues$incr)
stdDev <- sd(stockValues$incr)
currentvalues <- rnorm(5, expValue , stdDev)+startValue
dayvalues <-list(startValue, startValue, startValue, startValue, startValue)
for(j in 1:5){
  dayvalues[[j]] <- union(dayvalues[[j]], currentvalues[j])
}
for(i in 1:10){
  currentvalues <- rnorm(5, expValue, stdDev)+currentvalues
  for(t in 1:5){
    dayvalues[[t]] <- union(dayvalues[[t]], currentvalues[t])
  }
}
plot(1,type='n',xlim=c(1,12),ylim=c(range(dayvalues)),xlab='Days', ylab='Ending Value')

for(h in 1:5){
  lines(dayvalues[[h]])
}
print(mean(currentvalues))