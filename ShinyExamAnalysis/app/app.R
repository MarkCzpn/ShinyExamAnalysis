library(shiny)
library(dplyr)
library(ggplot2)
library(gapminder)

library(plotly)

library(shinydashboard)
library(bsplus)
library(htmltools)
library(shinyjs)
library(tinytex)

library(jsonlite)

library(datasets)
library(callr)

library(TAM)
library(CTT)
library(psych)

source("visualization.R")
source("language.R")
source("dataManipulation.R")

# Specify the application port
options(shiny.host = "0.0.0.0")
options(shiny.port = 8180)



# POST Handler: handles incoming Data (params in csv)
# Saves and processing Data in tmp/token.csv
# params: csv_link (link to exam Data)
# params: token (id) 
# params: source (Ilias/Evaexam)
post_handler <- function(req, response) {

  if (identical(req$REQUEST_METHOD, "POST")) {
    # you probably want to limit the upload file size w/ the first arg of $read()

    raw_data <- req$rook.input$read()
    data <- jsonlite::fromJSON(rawToChar(raw_data))

    if (is.null(data) || is.null(data$csv_link) || is.null(data$token)) {
    #if (is.null(data) || is.null(data$token)) {
      return (shiny:::httpResponse(404, "text/plain", "ERROR"))

    } else {

      download.file(data$csv_link, sprintf("tmp/%s.csv", data$token))
      write_json(data, sprintf("tmp/%s.json", data$token))
      
      #process the csv data so it can be worked
      #TODO ILIAS Handling
      if(data$source == "ILIAS"){
        TRUE
      }
      #make a evaexam condition with else if
      else if (data$source == "evaexam"){
        evaExamDataHandler(data$token)
      }

        # result_irt <- try(rasch_mod <- TAM::tam.mml(read.csv("tmp/test.csv"),  fileEncoding="latin1", sep = ";",check.names=FALSE), silent = TRUE)
        # # result_ctt <- try(ctt_mod <- CTT::itemAnalysis("put in datasset here"), silent = TRUE)
        # if  (inherits(result_ctt, 'try-error') | inherits(result_irt, 'try-error')) {
        #     return (shiny:::httpResponse(404, "text/plain", "Provided Data not suitable for Analysis"))
        # }

      return(shiny:::httpResponse(200, "text/plain","OK"))
    }
  }
  # return regular shiny response
  response
}

#make shiny yse Post
options(shiny.http.response.filter = post_handler)

#make a javascript function so we can use tooltips 
activateTooltip <-'$(function () {
        $("[rel=\'tooltip\']").tooltip();
    });'


#uses shinydashboard 
# every div gets a box gets a output (plot, etc)
# uiOutput renders Text on Browser Language
startShiny <- function(){
    app=shinyApp(
        

        ui =  dashboardPage(title = "Exam Analysis",

        dashboardHeader(title = uiOutput("dashboardTitle", inline = TRUE)),
                    
        dashboardSidebar(
            useShinyjs(),
            
            #get actual Language , on side load function
            extendShinyjs(text = activateTooltip, functions = c()),


            
            sidebarMenu(id = 'sidebarmenu',

                selectInput("select_shape", label = h5("Items"), choices = list("Dichotom" = "dichotomous", "Polytom" = "polytomous"), selected = 1),

                #Menu Points Statistics (CTT)
                menuItem(uiOutput("cttMenu", inline = TRUE), tabName = 'ctt',
                        icon = icon('line-chart'),
                        checkboxInput(inputId = "scatterCTTDifficultyCheck",  label = uiOutput("scatterCTTDifficultyCheckLabel", inline = TRUE), value = TRUE),
                        checkboxInput(inputId = "violinCTTChartCheck",  label = uiOutput("violinCTTChartCheckLabel", inline = TRUE), value = TRUE),
                        checkboxInput(inputId = "histogramCTTPointsCheck",  label = uiOutput("histogramCTTPointsCheckLabel", inline = TRUE), value = TRUE),
                        checkboxInput(inputId = "cronbachsAlphaCheck",  label = uiOutput("cronbachAlphaCheckLabel", inline = TRUE), value = TRUE),

                        checkboxInput(inputId = "factorAnalysisCheck",  label = uiOutput("factorAnalysisCheckLabel", inline = TRUE), value = TRUE)


                ),

                #Menu Points Extended (IRT)
                menuItem(uiOutput("irtMenu", inline = TRUE), tabName = 'irt',
                        icon = icon('line-chart'),
                        checkboxInput(inputId = "wrightMapCheck",  label = uiOutput("wrightMapCheckLabel", inline = TRUE), value = TRUE),
                        checkboxInput(inputId = "violinIRTChartCheck",  label = uiOutput("violinIRTChartCheckLabel", inline = TRUE), value = TRUE),
                        checkboxInput(inputId = "histogramIRTPointsCheck",  label = uiOutput("histogramIRTPointsCheckLabel", inline = TRUE), value = TRUE)


                ),

                menuItem("FAQ", 
                        icon = icon("download"),
                        downloadLink("downloadFAQ", label = "Download", icon = icon("download"))
                        )
                        
                
                
            )
            
        ),


        dashboardBody(
        
            fluidRow(
            # div(id="textbox1",
            #     box(title = "text1" , textOutput("text1"))
            # ),            
            
            # I think div not needed? but maybe better 
            div(id = "cronbachsAlphaDiv",
                box(title = list("Cronbachs Alpha" , 

                    #make a tootlip which changes content based on language
                    shiny_iconlink() %>%
                        span(
                        `id` = 'cronbachsTooltipID',
                        `data-toggle` = "tooltip", 
                        `data-trigger` = "click",
                        title = "",
                        )
                    ),
                    status = "primary", 
                    infoBoxOutput("cronbachsAlpha", width = 6))
            ),

            #Tooltips from bsplus are init before making server actions. So language file doesnt work: workaround, js code in content, because html code works
            div(id="wrightMapDiv",
                box(title = list("Wright Map" , 
                    shiny_iconlink() %>% 
                        span(
                            `id` = 'wrightMapTooltipID',
                            `data-toggle` = "tooltip", 
                            `data-placement` = "auto",
                            `data-trigger` = "click",
                            title = "",
                            )
                    ), 
                    status = "primary", 
                    plotlyOutput("wrightPlot"))
            ),

            div(id="violinIRTChartDiv",
                box(title = list(uiOutput("ViolinIRTChartTitle", inline = TRUE) , 
                    shiny_iconlink() %>% 
                        span(
                            `id` = 'violinIRTTooltipID',
                            `data-toggle` = "tooltip", 
                            `data-placement` = "auto",
                            `data-trigger` = "click",
                            title = "",
                            )
                    ),
                    status = "primary", 
                    plotlyOutput("violinIRTPlot"))
            ),

            div(id="violinCTTChartDiv",
                box(title = list(uiOutput("ViolinCTTChartTitle", inline = TRUE) , 
                    shiny_iconlink() %>% 
                        span(
                            `id` = 'violinCTTTooltipID',
                            `data-toggle` = "tooltip", 
                            `data-placement` = "auto",
                            `data-trigger` = "click",
                            title = "",
                            )
                    ),
                    status = "primary", 
                    plotlyOutput("violinCTTPlot"))
            ),


            div(id="histogramIRTPointsDiv",
                box(title = list(uiOutput("HistogramIRTChartTitle", inline = TRUE) , 
                    shiny_iconlink() %>% 
                        span(
                            `id` = 'histogramIRTTooltipID',
                            `data-toggle` = "tooltip", 
                            `data-placement` = "auto",
                            `data-trigger` = "click",
                            title = "",
                            )
                    ), 
                    status = "primary",
                    plotlyOutput("histogramIRTPoints"))
                
            ),

            div(id="histogramCTTPointsDiv",
                box(title = list(uiOutput("histogramCTTChartTitle", inline = TRUE) , 
                    shiny_iconlink() %>% 
                        span(
                            `id` = 'histogramCTTTooltipID',
                            `data-toggle` = "tooltip", 
                            `data-placement` = "auto",
                            `data-trigger` = "click",
                            title = "",
                            )
                    ), 
                    status = "primary",
                    plotlyOutput("histogramCTTPoints"))
                
            ),

            div(id="scatterCTTPointsDiv",
                box(title = list(uiOutput("scatterCTTChartTitle", inline = TRUE) , 
                    shiny_iconlink() %>% 
                        span(
                            `id` = 'scatterCTTPointsTooltipID',
                            `data-toggle` = "tooltip", 
                            `data-placement` = "auto",
                            `data-trigger` = "click",
                            title = "",
                            )
                    ), 
                    status = "primary",
                    plotlyOutput("scatterCTTPoints"))
                
            ),

            div(id="factorAnalysisDiv",
                box(title = list(uiOutput("FactorAnalysisTitle", inline = TRUE) , 
                    shiny_iconlink() %>% 
                        span(
                            `id` = 'factorAnalysisTooltipID',
                            `data-toggle` = "tooltip", 
                            `data-placement` = "auto",
                            `data-trigger` = "click",
                            title = "",
                            )
                    ), 
                    status = "primary",
                    fluidRow(
                        column(4,
                            selectInput("rotation",
                                        uiOutput("FactorAnalysisRotation", inline = TRUE) ,
                                        c("Simplimax", "Varimax", "Oblimin"))
                        ),
                        column(4,
                            sliderInput("factors",
                                        uiOutput("FactorAnalysisFactor", inline = TRUE),
                                            min = 1, max = 5,
                                            value = 1),
                        ),

                        column(4,
                            sliderInput("cutOff",
                                        uiOutput("FactorAnalysisCut", inline = TRUE),
                                            min = 0, max = 1,
                                            value = 0.3),
                        ),
                    ),
                    tableOutput('factorAnalysisDT'),
                    tableOutput('factorAnalysisR2'),
                )

            ),
            # box(
            # downloadButton(
            #     outputId = "report",
            #     label = "Generate report"
            #     )),



            #Try to make tooltip or popovers work
                            tags$style(HTML('.
                               .popover {position: fixed; }
                               .popover-title {color:red;}
                               .popover-content {color:black;}
                               .box{z-index:auto;}
                               .box box-primary {z-index:auto;}
                               .violinIRTChartDiv {z-index:auto;}'))
            )
        )),
        

        server = function(input, output, session) {
            
            
            url_parameters <- reactiveValues()

            #checks if token is in GET Query 
            observe({
                query <- parseQueryString(session$clientData$url_search)
                url_parameters$token <- query[["token"]]
            })


            #get language via Javascript and puts it into input$lanData variable
            runjs("var language =  window.navigator.userLanguage || window.navigator.language;
                    Shiny.onInputChange('lanData', language); 
                    ")

            # delete the files on session end
            # session$onSessionEnded(function() {
            #     fileToDelete <- "test.txt"
            #     if (file.exists(fileToDelete)) {
            #     file.remove(fileToDelete)
            #     }
            # })


            session$onSessionEnded(function() {
                if (file.exists(sprintf("tmp/%s.csv",  url_parameters$token))){
                    file.remove(sprintf("tmp/%s.csv",  url_parameters$token))
                }
            })

            # download FAQ PDF
            output$downloadFAQ <- downloadHandler(
                filename = "FAQ.pdf",
                if (input$lanData == "de")
                    {
                        content = function(file) {
                        file.copy("FAQ/FAQ-de.pdf", file)
                        }
                    }
                else
                    {
                        content = function(file) {
                        file.copy("FAQ/FAQ-en.pdf", file)
                        }
                    },



            )

            #getRaschModel() is a rasch Model
            #and decides if data is dichotomous or polytomous by Input of selct
            getRaschModel <- reactive({
                if(input$select_shape == "dichotomous"){
                    TAM::tam.mml(read.csv(sprintf("tmp/dichotom-%s.csv",  url_parameters$token),  fileEncoding="latin1", sep = ";"))
                }else{
                    TAM::tam.mml(read.csv(sprintf("tmp/%s.csv",  url_parameters$token),  fileEncoding="latin1", sep = ";"))
                }
               
                #TAM::tam.mml(read.csv("tmp/test.csv",  fileEncoding="latin1"))
            })

            #getCTTModel() is a CTT Model
            #and decides if data is dichotomous or polytomous by Input of select
            getCTTModel <- reactive({
                if(input$select_shape == "dichotomous"){
                    CTT::itemAnalysis(read.csv(sprintf("tmp/%s.csv",  url_parameters$token),  fileEncoding="latin1", sep = ";"))
                }else{
                    CTT::itemAnalysis(read.csv(sprintf("tmp/dichotom-%s.csv",  url_parameters$token),  fileEncoding="latin1", sep = ";"))
                }
                
                #CTT::itemAnalysis(read.csv("tmp/test.csv",  fileEncoding="latin1"))
            })

            #delete
            output$text1 <- renderText({ paste(url_parameters$token) })

            #fill CronbachsAlpha Box with CAlpha: good, bad, okay borders 
            output$cronbachsAlpha <- renderInfoBox({
                if(getCTTModel()$alpha > .7){
                    infoBox(
                    "Cronbachs Alpha",round(getCTTModel()$alpha, digits = 3), icon = icon("thumbs-up", lib = "glyphicon"),
                    color = "green", fill=TRUE
                    )
                }else if(getCTTModel()$alpha < .5) {
                    infoBox(
                    "Cronbachs Alpha", round(getCTTModel()$alpha, digits = 3), icon = icon("thumbs-down", lib = "glyphicon"),
                    color = "red", fill=TRUE
                    )
                }else{
                    infoBox(
                    "Cronbachs Alpha",round(getCTTModel()$alpha, digits = 3), icon = icon("hand-right", lib = "glyphicon"),
                    color = "orange", fill=TRUE
                    )
                }


            })

            #call WrightPlot in visualization.R
            output$wrightPlot <- renderPlotly({
                wrightMapPlotly(model = getRaschModel() , language = input$lanData)
            })

            #call scatterCTTPoints in visualization.R
            output$scatterCTTPoints <- renderPlotly({
                scatterCTTDifficultyPlotly(model = getCTTModel(), language = input$lanData)      

            })

            #call violinIRTPlot in visualization.R
            output$violinIRTPlot <- renderPlotly({
                violinIRTPoints(model = getRaschModel(), language = input$lanData)
            })

            #call violinCTTPlot in visualization.R
            output$violinCTTPlot <- renderPlotly({
                violinCTTPoints(model = getCTTModel(), language = input$lanData)

            })

             #fill Histogram Box with Histogram Charts (from visualization.R)
            output$histogramIRTPoints <- renderPlotly({
                histogramIRTPointsPlotly(model = getRaschModel(), language = input$lanData)
            })           

            output$histogramCTTPoints <- renderPlotly({
                histogramCTTPointsPlotly(model = getCTTModel(), language = input$lanData)

            })

            #different Model for Factor 
            factorData <- reactive({
                psych::fa(r = read.csv(sprintf("tmp/%s.csv",  url_parameters$token),  fileEncoding="latin1", sep = ";"), nfactors = input$factors, rotate = tolower(input$rotation))
            })

            cutOff <- reactive({
                input$cutOff
            })

            #puts FactorAnalysis in a Table
            output$factorAnalysisDT <- renderTable({
                factor_data <- as.data.frame(unclass(factorData()$Structure))
                #make new Column with Items
                factor_data <- factor_data %>% mutate_if(is.numeric, round, 3)
                factor_data[factor_data < cutOff()] <- ''
                cbind(Items = rownames(factor_data), factor_data)
                
            })

            output$factorAnalysisR2 <- renderTable({
                factor_data <- as.data.frame(factorData()$R2)
                colnames(factor_data)[1] <- "Correlation"
                factor_data[factor_data < cutOff()] <- ''
                cbind(Factor = rownames(factor_data),factor_data)
            })



            # output$plot2 <- renderPlotly({
            #     wrightMapPlotly(model = rasch_mod)
            # })


            #change names of labels of the sidebar by language (de/en)
            output[["cttMenu"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$MenuCTT}
                else{getLanguageList("en")$MenuCTT}

            })

            output[["irtMenu"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$MenuIRT}
                else{getLanguageList("en")$MenuIRT}

            })


            output[["ViolinIRTChartTitle"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$ViolinIRTTitle}
                else{getLanguageList("en")$ViolinIRTTitle}

            })
            

            output[["violinIRTChartCheckLabel"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$ViolinIRTPoints}
                else{getLanguageList("en")$ViolinIRTPoints}

            })


            output[["ViolinCTTChartTitle"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$ViolinCTTTitle}
                else{getLanguageList("en")$ViolinCTTTitle}

            })
            

            output[["violinCTTChartCheckLabel"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$ViolinCTTPoints}
                else{getLanguageList("en")$ViolinCTTPoints}

            })

            output[["FactorAnalysisTitle"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$FactorAnalysisTitle}
                else{getLanguageList("en")$FactorAnalysisTitle}

            })

            output[["HistogramIRTChartTitle"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$HistIRTTitle}
                else{getLanguageList("en")$HistIRTTitle}

            })

            output[["histogramIRTPointsCheckLabel"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$HistIRTPoints}
                else{getLanguageList("en")$HistIRTPoints}

            })            

            output[["histogramCTTChartTitle"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$HistCTTTitle}
                else{getLanguageList("en")$HistCTTTitle}

            })

            output[["histogramCTTPointsCheckLabel"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$HistCTTPoints}
                else{getLanguageList("en")$HistCTTPoints}

            })

            output[["scatterCTTChartTitle"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$ScatterCTTTitle}
                else{getLanguageList("en")$ScatterCTTTitle}

            })

            output[["scatterCTTDifficultyCheckLabel"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$ScatterCTTPoints}
                else{getLanguageList("en")$ScatterCTTPoints}

            })

            output[["cronbachAlphaCheckLabel"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$CronbachsAlpha}
                else{getLanguageList("en")$CronbachsAlpha}

            })

            output[["factorAnalysisCheckLabel"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$factorAnalysisCheckLabel}
                else{getLanguageList("en")$factorAnalysisCheckLabel}

            })

            output[["wrightMapCheckLabel"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$WrightMap}
                else{getLanguageList("en")$WrightMap}

            })

            output[["FactorAnalysisRotation"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$FactorAnalysisRotation}
                else{getLanguageList("en")$FactorAnalysisRotation}

            })

            output[["FactorAnalysisFactor"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$FactorAnalysisFactor}
                else{getLanguageList("en")$FactorAnalysisFactor}

            })

            output[["FactorAnalysisCut"]] <- renderUI({
                if (input$lanData == "de"){getLanguageList("de")$FactorAnalysisCut}
                else{getLanguageList("en")$FactorAnalysisCut}

            })

                runjs("var language =  window.navigator.userLanguage || window.navigator.language;
                    if (language == 'de'){
                        Shiny.onInputChange('langu', 'germany'); 
                    }
                    else{
                        Shiny.onInputChange('langu', 'ingles'); 
                    }
                ")

            
            #and Language of Tootlips in Javascript 
            # TODO : get TOOLTIPS in from language File : do not know how to get values from shiny in JS by now
            runjs("
                    var cronbachsTooltip =  document.getElementById('cronbachsTooltipID');
                    var wrightMapTooltip =  document.getElementById('wrightMapTooltipID');
                    var violinIRTTooltip =  document.getElementById('violinIRTTooltipID');
                    var violinCTTTooltip =  document.getElementById('violinCTTTooltipID');
                    var histogramIRTTooltip =  document.getElementById('histogramIRTTooltipID');
                    var histogramCTTTooltip =  document.getElementById('histogramCTTTooltipID');
                    var scatterCTTPointsTooltip =  document.getElementById('scatterCTTPointsTooltipID');
                    var factorAnalysisTooltip =  document.getElementById('factorAnalysisTooltipID');
                    
                    var language =  window.navigator.userLanguage || window.navigator.language;
                    if (language == 'de'){
                        cronbachsTooltip.title = 
                            'statistisches Maß für die interne Konsistenz einer Skala. Bewertet Zuverlässigkeit des Gesamttests';
                        wrightMapTooltip.title =  
                            'Stellt Item Schwierigkeit und Teilnehmerfähigkeit in Relation';
                        violinIRTTooltip.title = 
                            'Visualisiert die Dichte der Itemschwierigkeit - nach Item-Response-Theorie';
                        violinCTTTooltip.title = 'violinCTTTooltipDE';
                            'Visualisiert die Dichte der Itemschwierigkeit - nach klassischer Testtheorie';
                        histogramIRTTooltip.title = 
                            'Verteilung der Item Schwierigkeit als Histogram - nach Item-Response-Theorie';
                        histogramCTTTooltip.title = 
                            'Verteilung der Item Schwierigkeit als Histogram - nach klassischer Testtheorie';
                        scatterCTTPointsTooltip.title = 
                            'Itemschwierigkeit - nach klassischer Testtheorie';
                        factorAnalysisTooltip.title = 
                            'Identifiziert Korrelationen zwischen Items';
                    }
                    else{
                        cronbachsTooltip.title = 
                            'Statistical measure of the internal consistency of a scale. Evaluates reliability of the overall test';
                        wrightMapTooltip.title =  
                            'Relates item difficulty and person ability';
                        violinIRTTooltip.title = 
                            'Visualizes the density of item difficulty - according to item response theory';
                        violinCTTTooltip.title =
                            'Visualizes the density of item difficulty - according to classical test theory';
                        histogramIRTTooltip.title = 
                            'Distribution of item difficulty as a histogram - according to item response theory';
                        histogramCTTTooltip.title = 
                            'Distribution of item difficulty as a histogram - according to classical test theory';
                        scatterCTTPointsTooltip.title = 
                            'Item difficulty - according to classical test theory';
                        factorAnalysisTooltip.title = 
                            'Identifies correlations between items';
                    }
                ")

            ## observe the button being pressed
            observeEvent(input$wrightMapCheck, {
                
                if(input$wrightMapCheck == TRUE){
                    shinyjs::show(id = "wrightMapDiv")
                }else{
                    shinyjs::hide(id = "wrightMapDiv")
                }
            })


            ## observe the button being pressed
            observeEvent(input$cronbachsAlphaCheck, {
                
                if(input$cronbachsAlphaCheck == TRUE){
                    shinyjs::show(id = "cronbachsAlphaDiv")
                }else{
                    shinyjs::hide(id = "cronbachsAlphaDiv")
                }
            })


            ## observe the button being pressed
            observeEvent(input$factorAnalysisCheck, {
                
                if(input$factorAnalysisCheck == TRUE){
                    shinyjs::show(id = "factorAnalysisDiv")
                }else{
                    shinyjs::hide(id = "factorAnalysisDiv")
                }
            })

            ## observe the button being pressed
            observeEvent(input$violinIRTChartCheck, {
                
                if(input$violinIRTChartCheck == TRUE){
                    shinyjs::show(id = "violinIRTChartDiv")
                }else{
                    shinyjs::hide(id = "violinIRTChartDiv")
                }
            })


            observeEvent(input$violinCTTChartCheck, {
                
                if(input$violinCTTChartCheck == TRUE){
                    shinyjs::show(id = "violinCTTChartDiv")
                }else{
                    shinyjs::hide(id = "violinCTTChartDiv")
                }
            })

            ## observe the button being pressed
            observeEvent(input$histogramIRTPointsCheck, {
                
                if(input$histogramIRTPointsCheck == TRUE){
                    shinyjs::show(id = "histogramIRTPointsDiv")
                }else{
                    shinyjs::hide(id = "histogramIRTPointsDiv")
                }
            })

            observeEvent(input$histogramCTTPointsCheck, {
                
                if(input$histogramCTTPointsCheck == TRUE){
                    shinyjs::show(id = "histogramCTTPointsDiv")
                }else{
                    shinyjs::hide(id = "histogramCTTPointsDiv")
                }
            })

            observeEvent(input$scatterCTTDifficultyCheck, {
                
                if(input$scatterCTTDifficultyCheck == TRUE){
                    shinyjs::show(id = "scatterCTTPointsDiv")
                }else{
                    shinyjs::hide(id = "scatterCTTPointsDiv")
                }
            })

        }



    )
    runApp(app)
}

startShiny()



