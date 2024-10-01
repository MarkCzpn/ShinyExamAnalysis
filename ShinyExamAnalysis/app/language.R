#Language Moduel for App
#' @param language provided 'en' and 'de' 
#' @return returns the list of the param language 

getLanguageList <- function(language) {
deLanguage <- list(
    #Title
    DashboardTitle = "Klausurenanalyse",

    #MenuItems
    MenuCTT = "Statistiken (KTT)",
    MenuIRT = "Weiterführend (IRT)",

    Dichotom = "Dichotom",
    Polytom = "Polytom",
    
    #Plot Titles in Boxes
    HistIRTTitle = "Histogram Item Schwierigkeit (IRT)",
    ViolinIRTTitle = "Violin Plot ItemSchwierigkeit(IRT)",

    ScatterCTTTitle = "Scatter Plot - Item Schwierigkeit(CTT)",
    HistCTTTitle = "Histogram Item - Schwierigkeit (CTT)",
    ViolinCTTTitle = "Violin Plot Item - Schwierigkeit(CTT)",

    FactorAnalysisTitle = "Faktoren Analyse (Validität)",

    #PlotNames in Subnavigation
    HistIRTPoints = "Histogram - Item Schwierigkeit (IRT)",
    ViolinIRTPoints = "Violin Plot - Schwierigkeit (IRT)",
    WrightMap = "WrightMap",

    ScatterCTTPoints = "Scatter Plot - Item Schwierigkeit (CTT)",
    HistCTTPoints = "Histogram - Item Schwierigkeit (CTT)",
    ViolinCTTPoints = "Violin Plot - Schwierigkeit (CTT)",
    CronbachsAlpha = "CronbachsAlpha",

    factorAnalysisCheckLabel = "Faktoren Analyse (Validität)",

    ##Plots
    #Histogram
    HistogramGGText = "Hist Punkte",
    binSliderHistogramGGText = "Groesse Bins",
    radioHistogramGGText = "",
    radionormHistogramGGText = "Normalisiert",
    radioprobHistogramGGText = "Wahrscheinlichkeit",

    Report = "PDF Report DE",
        
    #Tooltips
    #not from here right now. in app.R
    HistIRTPointsTooltip = "HistoramPointsT",
    ViolinIRTPointsTooltip = "ViolinPointsT",
    WrightMapTooltip = "WrightMapT",
    CronbachsAlphaTooltip = "CronbachsAlphaT",

    ScatterCTTPointsTooltip = "ScatterPointsT",
    HistCTTPointsTooltip = "HistoramPointsT",
    ViolinCTTPointsTooltip = "ViolinPointsT",

    #Plotly contetn in visualization
    xAxisViolinIRTPloty = "Item Schwierigkeit",
    xAxisViolinCTTPloty = "Item Schwierigkeit",

    xAxisHistogramIRTPloty = "Item Schwierigkeit",
    yAxisHistogramIRTPloty = "Item Häufigkeit",
    xAxisHistogramCTTPloty = "Item Schwierigkeit",
    yAxisHistogramCTTPloty = "Item Häufigkeit",

    xAxisLeftWrightMapPloty = "Personen",
    xAxisRightWrightMaoIRTPloty = "Items" ,
    yAxisWrightMapIRTPloty = "Itemschwierigkeit / Personenfähigkeit",

    xAxisScatterDifficultyCTTPloty = "Items",
    yAxisScatterDifficultyCTTPloty = "Itemschwierigkeit",

    FactorAnalysisRotation = "Rotation: ",
    FactorAnalysisFactor = "Faktor: ",
    FactorAnalysisCut =  "Abschneiden: "

)

enLanguage <- list(
    #Title
    DashboardTitle = "Exam Analysis",

    #MenuItems
    MenuCTT = "Statistics (CTT)",
    MenuIRT = "Extended (IRT)",
    Dichotom = "Dichotomous",
    Polytom = "Polytomous",

    #Plot Titles in Boxes
    HistIRTTitle ="Histogram - Item Difficulty (IRT)",
    ViolinIRTTitle = "Violin Plot - Item Difficulty (IRT)",

    ScatterCTTTitle = "Scatter Plot - Item Difficulty(CTT)",
    HistCTTTitle = "Histogram - Item Difficulty (CTT)",
    ViolinCTTTitle = "Violin Plot - Item Difficulty (CTT)",

    FactorAnalysisTitle = "Factor Analysis (Validity)",


    #PlotNames in Subnavigation
    HistIRTPoints = "HistoramPointsE",
    ViolinIRTPoints = "ViolinPointsE",
    WrightMap = "WrightMapE",

    ScatterCTTPoints = "Scatter Plot - Item Difficulty (CTT)",
    HistCTTPoints = "Histogram - Item Difficulty (CTT)",
    ViolinCTTPoints = "Violin Plot - Item Difficulty (CTT)",
    CronbachsAlpha = "CronbachsAlphaE",
    
    factorAnalysisCheckLabel = "Factor Analysis (Validity)",
    ##Plots
    #Histogram
    HistogramGGText = "Hist Points",
    binSliderHistogramGGText = "bin size",
    radioHistogramGGText = "",
    radionormHistogramGGText = "Normalized",
    radioprobHistogramGGText = "Probability",

    Report = "PDF Report En",

    #Tooltips 
    #not from here right now. in app.R
    HistIRTPointsTooltip = "HistoramPointsTE",
    ViolinIRTPointsTooltip = "ViolinPointsTE",
    WrightMapTooltip = "WrightMapTE",
    CronbachsAlphaTooltip = "CronbachsAlphaTE",

    ScatterCTTPointsTooltip = "HistoramPointsTE",
    HistCTTPointsTooltip = "HistoramPointsTE",
    ViolinCTTPointsTooltip = "ViolinPointsTE",

    #Plotly contetn in visualization
    xAxisViolinIRTPloty = "Item Difficulty",
    xAxisViolinCTTPloty = "Item Difficulty",

    xAxisHistogramIRTPloty = "Item Difficulty",
    yAxisHistogramIRTPloty = "Item Frequency",
    xAxisHistogramCTTPloty = "Item Difficulty",
    yAxisHistogramCTTPloty = "Item Frequency",


    xAxisLeftWrightMapPloty = "Persons",
    xAxisRightWrightMaoIRTPloty = "Items" ,
    yAxisWrightMapIRTPloty = "Item Difficulty / Personen Ability",

    xAxisScatterDifficultyCTTPloty = "Items",
    yAxisScatterDifficultyCTTPloty = "Item Difficulty",
        
    FactorAnalysisRotation = "Rotation: ",
    FactorAnalysisFactor = "Factor: ",
    FactorAnalysisCut =  "Cut-Off: "


)
if(language == "de"){
    return (deLanguage)
}else{
    return (enLanguage)
}

}

