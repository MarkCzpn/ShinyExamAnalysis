#processes the dataframe gotten by Evaexam to get models from. saves it into usable csv.
#' @param token id of the csv which gets prepared


evaExamDataHandler <- function(token) {
  rawData <- read.csv(sprintf("tmp/%s.csv",  token),  fileEncoding="latin1", sep = ";",check.names=FALSE)
  dataframe = rawData[3:(ncol(rawData)-10)]

  file.remove(sprintf("tmp/%s.csv",  token))

  makeDichotomFile(dataframe = dataframe, token = token)
  write.csv2(dataframe, sprintf("tmp/%s.csv", token),  fileEncoding="latin1",row.names = FALSE)
  return (dataframe)
} 

makeDichotomFile <- function(dataframe,token){
    dataframe <- apply(dataframe, c(1, 2), function(x) ifelse(x <= 0, 0, 1))
    dataframe <- as.data.frame(dataframe)
    write.csv2(dataframe, sprintf("tmp/dichotom-%s.csv", token),  fileEncoding="latin1",row.names = FALSE)
}