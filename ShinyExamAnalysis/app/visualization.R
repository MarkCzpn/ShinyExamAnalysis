library(ggplot2)
library(forcats)
library(plotly)
# library(psych)
library(grid)
library(dplyr)
library(psych)

library(shiny)

source("language.R")


#' @param model Tam mml Rasch Model
#' @return returns the item difficulty from the model
getItemDiff <- function(model) {
    itemDiff <- data.frame(Item = model$item$item, Difficulty = model$xsi$xsi)

    return(itemDiff)
}

#' @param model: Tam mml Rasch Model
#' @return: returns the  person Ability from the model
getPersonAbility <- function(model) {
    person <- TAM::tam.wle(model)
    itemDiff <- getItemDiff(model)

    # Person ability Distribution
    personAbility <- data.frame(personAbility = person$theta)

    return(personAbility)
}

# Normaldistribution
#' @param: Tam mml Rasch Model
#' @return: Data Frame with Person's ability and the density
# Personendichte in : Personenzahl erste Ableitung
getNormalizedPersonAbility <- function(model) {
    person <- TAM::tam.wle(model)
    itemDiff <- getItemDiff(model)

    # seq borders dynamically set by min and max person ability
    y <- seq(floor(min(person$theta)), ceiling(max(person$theta)), len = 500)

    xp <- dnorm(y, mean = mean(person$theta), sd = sd(person$theta))
    xi <- pnorm(y, mean = mean(itemDiff$Difficulty), sd = sd(itemDiff$Difficulty))

    personAbility <- data.frame(PersonDensity = xp, ItemDifficulty = xi)
    personAbility <- data.frame(personAbility = xp)
    # print(personAbility)
    return(personAbility)
}


#' @param model: CTT Model from CTT module
#' @return: returns the item difficulty from the model
getCTTItemDiff <- function(model) {
    itemDiff <- data.frame(Item = model$itemReport$itemName, Difficulty = model$itemReport$itemMean)

    return(itemDiff)
}



#' @param model rasch model from TAM
#' @return an ggplot2 with datapoints difficulty/name
rasch_plotter <- function(model) {
    itemDiff <- getItemDiff(model)
    # plot "ordered" after Items
    rasch_plot_item <- ggplot(itemDiff, aes(Item, Difficulty))

    # plot ordered after Difficulty: same same but different)
    # rasch_plot_diff <- ggplot(itemDiff, aes(reorder(Item, Difficulty), Difficulty)) + geom_point()

    rasch_plot <- ggplot() +
        geom_point(data = itemDiff, aes(reorder(Item, Difficulty), Difficulty))
    return(rasch_plot)
}

#' @param model rasch model from TAM
#' @return a histogram with person Abilities
person_plotter_hist <- function(model) {
    personAbility <- getPersonAbility(model)
    personAbility_plot <- ggplot() +
        geom_histogram(data = personAbility, binwidth = 0.1, aes(x = pa, y = after_stat(density))) +
        # flip the plot 90 degrees to the right
        scale_y_reverse() +
        coord_flip() +
        scale_x_continuous(position = "top")
    return(personAbility_plot)
}

#' @param model rasch model from TAM
#' @return a histogram with person Abilities, this time normalized 
normalized_person_plotter <- function(personAbility) {
    personAbility <- getPersonAbility(model)
    personAbility_plot <- ggplot(personAbility, aes(ItemDifficulty)) +
        geom_histogram(aes(y = after_stat(density)), binwidth = .01) +
        geom_density()
    
    return(personAbility_plot)
}







# TODO : set an Order parameter
#
# Generic Wright Map
#' @param: personAbility as DataFrame, ItemDiff as DataFrame, binwidth, color, size ,yAxisLeft as string of Axis Name, yAxisRight as string of Axis Name
#' @return: WrightMap with Density of Person Abilities and Item Difficulty
wrightMap <- function(model, binwidth = 0.1, normalize = FALSE, color = "blue", size = 15, rel_widths = c(1, 4), xAxisLeft = "Person Ability", xAxisRight = "Item Name") {
    if (missing(model)) {
        stop("'Model ' needs to be specified", call. = FALSE)
    }


    df.itemDiff <- getItemDiff(model)

    # TODO: Normalize option
    if (normalize) {
        df.personAbility <- getNormalizedPersonAbility(model)
    } else {
        df.personAbility <- getPersonAbility(model)
    }
    # df.personAbility <- getPersonAbility(model)
    

    # defining limits , for both the same at y, because they share it
    lim.y.min <- min(c(df.personAbility$personAbility, df.itemDiff$Difficulty), na.rm = TRUE) - binwidth
    lim.y.max <- max(c(df.personAbility$personAbility, df.itemDiff$Difficulty), na.rm = TRUE) + binwidth

    #p1 point plot for item Difficulty
    p1 <- ggplot(data = df.itemDiff, aes(reorder(x = .data$Item, .data$Difficulty), y = .data$Difficulty, label = .data$Item)) +
        geom_point(na.rm = TRUE) +
        scale_y_continuous(position = "left", limits = c(lim.y.min, lim.y.max)) +
        xlab(xAxisRight) +
        ylab("Difficulty") +
        theme(
            # axis.title.y = element_blank()
        )

    #p2 Histogram plot for person Ability 
    p2 <- ggplot(df.personAbility, aes(x = .data$personAbility)) +
        geom_histogram(binwidth = binwidth, fill = color, col = "black", na.rm = TRUE) +
        xlim(lim.y.min, lim.y.max) +
        coord_flip() +
        scale_y_reverse() +
        xlab(xAxisLeft) +
        ylab("Personen frequency") +
        scale_x_continuous(
            # sec.axis = sec_axis(trans = ~.*1 ,name="sec")
        ) +
        theme(
            # axis.title.y = element_blank(),
            # axis.text.y = element_blank(),
            # axis.ticks.y.left = element_blank(),

            # axis.line.y.right  = element_line(color="red",linewidth =3, linetype = 1),
            # axis.ticks.y.right = element_line(color="red",linewidth =3, linetype = 2)
        )


    plts <- list(p2, p1)


    # arrange plots using bare grid
    grid.newpage()

    grobs <- lapply(plts, ggplotGrob)

    new_layout <- data.frame(list(
        t = c(1, 1),
        l = c(1, 2),
        b = c(1, 1),
        r = c(1, 2),
        z = c(1, 2),
        clip = rep("off", 2),
        name = rep("arrange", 2)
    ))


    # make gtable
    g <- gTree(
        grobs = grobs, layout = new_layout, widths = unit(rel_widths, "null"),
        heights = unit(1, "null"), respect = FALSE, name = "arrange", rownames = NULL,
        colnames = NULL, vp = NULL, cl = "gtable"
    )

    grid.draw(g)
    # this is grid Extra g <- grid.arrange(p1,p2, nrow = 1)
    return(g)
    # invisible(g)
}

# Generic Wright Map made with plotly
# @param: personAbilityWrightMapPlotly() as DataFrame, ItemDiff as DataFrame, binwidth, color, size ,yAxisLeft as string of Axis Name, yAxisRight as string of Axis Name
# return: WrightMap with Density of Person Abilities and Item Difficulty
wrightMapGGPlotly <- function(model, binwidth = 0.1, normalize = FALSE, color = "blue", size = 15, rel_widths = c(1, 4), language = "en") {
    if (missing(model)) {
        stop("'Model ' needs to be specified", call. = FALSE)
    }

    if (language == "de"){
        xAxisLeft <- getLanguageList("de")$xAxisHistogramIRTPloty
        xAxisRight <- getLanguageList("de")$yAxisHistogramIRTPloty
    }
    else{
        xAxisLeft <- getLanguageList("en")$xAxisHistogramIRTPloty
        xAxisRight <- getLanguageList("en")$yAxisHistogramIRTPloty
    }

    df.itemDiff <- getItemDiff(model)

    #ordered by Difficulty 
    df.itemDiff <- df.itemDiff[order(df.itemDiff$Difficulty),]


    # TODO: Normalize option
    if (normalize) {
        norm = "probability"

    } else {
        norm = ""
        }
    df.personAbility <- getPersonAbility(model)



    #ggplot to plotly idea 
    binwidth=0.1
    # defining limits , for both the same at y, because they share it
    lim.y.min <- min(c(df.personAbility$personAbility, df.itemDiff$Difficulty), na.rm = TRUE) - binwidth
    lim.y.max <- max(c(df.personAbility$personAbility, df.itemDiff$Difficulty), na.rm = TRUE) + binwidth

    p1_gg <-  ggplot(data = df.itemDiff, aes(reorder(x = .data$Item, .data$Difficulty), y = .data$Difficulty, label = .data$Item)) +
        geom_point(na.rm = TRUE) +
        scale_y_continuous(position = "leTRUEft", limits = c(lim.y.min, lim.y.max)) +
        xlab(xAxisRight) +
        ylab("Difficulty") +
        theme(
             axis.title.y = element_blank()
        )

    p2_gg <- ggplot(df.personAbility, aes(x = .data$personAbility)) +
        geom_histogram(binwidth = binwidth, na.rm = TRUE) +
        xlim(lim.y.min, lim.y.max) +
        coord_flip() +
        scale_y_reverse() +
        xlab(xAxisLeft) +
        ylab("Personen frequency") +
        scale_x_continuous(
            # sec.axis = sec_axis(trans = ~.*1 ,name="sec")
        ) +
        theme(
            #axis.title.y = element_blank(),
            #axis.text.y = element_blank(),
            axis.ticks.y  = element_blank(),
            axis.title.x = element_blank()

            #axis.line.y.right  = element_line(color="red",linewidth =3, linetype = 1),
           # axis.ticks.y.right = element_line(color="red",linewidth =3, linetype = 2)
        )
    p1_gg <- ggplotly(p = p1_gg)
    p2_gg <- ggplotly(p = p2_gg)

    p2_gg <- p2_gg %>% layout(
            xaxis= list(),
            yaxis= list(mirror = "all", side="right", hoverformat = ".2f"),
            plot_bgcolor = "red",
            updatemenus = list(
                list(
                    type = "buttons",
                    y = 0.8,
                    buttons = list(

                        list(method = "restyle",args = list("color", "blue"),
                        label = "Blue"),

                        list(method = "restyle",
                        args = list("color", "red"),
                        label = "Red")))
                )
            )


    plt_gg <- subplot(
        p2_gg ,
        p1_gg ,

        shareY = TRUE, widths = c(0.2,0.8) 
    )

    htmlwidgets::saveWidget(as_widget(plt_gg), "write.html")

    return (plt_gg)
}

# Generic Wright Map made with plotly 
# Person Ability Histogram x Item Difficulty
#' @param model TAM Rasch model
#' @param binwidth for Person ability Histogram
#' @param normalize
#' @param color
#' @param size
#' @param rel_widths size of different plots 
#' @param language de or en
#' @return: WrightMap with Density of Person Abilities and Item Difficulty
wrightMapPlotly <- function(model, binwidth = 0.1, normalize = FALSE, color = "blue", size = 15, rel_widths = c(1, 4), language = "en" ) {
    if (missing(model)) {
        stop("'Model ' needs to be specified", call. = FALSE)
    }

    if (language == "de"){
        xAxisLeftContent <- getLanguageList("de")$xAxisLeftWrightMapPloty
        xAxisRigthContent <- getLanguageList("de")$xAxisRightWrightMaoIRTPloty
        yAxisContent <- getLanguageList("de")$yAxisWrightMapIRTPloty
    }
    else{
        xAxisLeftContent <- getLanguageList("de")$xAxisLeftWrightMapPloty
        xAxisRigthContent <- getLanguageList("de")$xAxisRightWrightMaoIRTPloty
        yAxisContent <- getLanguageList("de")$yAxisWrightMapIRTPloty
    }

    df.itemDiff <- getItemDiff(model)

    #ordered by Difficulty 
    df.itemDiff <- df.itemDiff[order(df.itemDiff$Difficulty),]


    df.personAbility <- getPersonAbility(model)


    #make a sliderinput list for the bin slider in plot p2
    sliderinput <- list()
    for (i in 1:20) {
        item <- list(
            args = list("nbinsy", i),
            label = i,
            method = "restyle",
            value = as.character(i)
        )
        sliderinput <- c(sliderinput, list(item))
     }
    
    #make the normal distribution
    mean_val <- mean(df.personAbility$personAbility)
    sd_val <- sd(df.personAbility$personAbility)
    y_range <- range(df.personAbility$personAbility)
    y_values <- seq(from = y_range[1], to = y_range[2], length.out = 100)
    normal_curve <- dnorm(y_values, mean = mean_val, sd = sd_val)

    #ggplot to plotly idea 
    binwidth=0.1
    # defining limits , for both the same at y, because they share it
    lim.y.min <- min(c(df.personAbility$personAbility, df.itemDiff$Difficulty), na.rm = TRUE) - binwidth
    lim.y.max <- max(c(df.personAbility$personAbility, df.itemDiff$Difficulty), na.rm = TRUE) + binwidth

    #x = reorder(df.itemDiff$Item, df.itemDiff$Difficulty)

    #Scatter plot of Item Difficulty
    p1 <- plot_ly(
        data = df.itemDiff, x = reorder(df.itemDiff$Item, df.itemDiff$Difficulty) , y = round(df.itemDiff$Difficulty, digits = 2), #if wanted unordered: x = ~Item
        type = "scatter",
        marker = list(size= 10, color ="#3374b1"),
        name = ' '

    )%>% layout(
        xaxis=list(title = xAxisRigthContent,
                   list = (hoverformat = '.2f')),

        yaxis=list(title = yAxisContent ,
                   list = (hoverformat = '.2f'))
    )
    
    # Person Ability Histogram
    p2 <- plot_ly(
        data = df.personAbility, y = round(df.personAbility$personAbility, digits = 2), #maybe use r Norm?  ~rnorm(500) instead of ~personAbility
        type = "histogram",
        histnorm = "probability", #vs norm
        nbinsy = 9,
        name = ' ',

        #binwidth = .1 #<- do i need binwidth?
        color = I("#3374b1")
        
    )%>% layout(
    xaxis=list(mirror = "all", side="right",autorange = "reversed", 
                title = xAxisLeftContent,list = (hoverformat = '.2f')),
    yaxis=list(mirror = "all", side="right", ticklen=20, tickcolor = "white",
                title = yAxisContent,list = (hoverformat = '.2f')), #make long ticks and make them invisible, not beautiful
        
    
        #making a bin slider
        sliders = list(
            list(
                active = 9,
                currentvalue = list(prefix = "Bin Size: "), 
                steps = sliderinput,
                pad = list(t = 50)
                )
            )
        # updatemenus = list(
        #     list(
        #         direction = "left",
        #         xanchor = 'right',
        #         yanchor = "center",
        #         pad = list('r'= 0, 't'= 10, 'b' = 10),
        #         x = 0.28,
        #         y = 1.125,
        #         buttons = list(
        #         list(method = "restyle",
        #             args = list("histnorm",  "probability"),
        #             label = "Probability"),

        #         list(method = "restyle",
        #             args = list("histnorm",  "norm"),
        #             label = "Norm")))

        # ) 
    )

    # probabbly add a normal distirbution
    #%>%add_trace(x = normal_curve, y = y_values, type = "scatter", mode = "lines", line = list(color = "red"), opacity = 0.5)


    # make a shared Plot
    plt <- subplot(
        p2,
        p1,
        
        shareY = TRUE, 
        titleX = TRUE, titleY = TRUE,
        widths = c(0.3,0.7),
        margin = 0.03

    )%>%config(
        displaylogo = FALSE,
        modeBarButtonsToRemove = c('zoom2d','pan2d','select2d', 'lasso2d', 'zoomIn2d', 'zoomOut2d', 'autoScale2d', 'resetScale2d')

    )%>% layout(
        #hovermode = 'y',

        xaxis=list(showgrid = TRUE),
        yaxis=list(showgrid = TRUE),
        showlegend = FALSE,
        
        #name of single plots
        annotations =list( 

            list( 
                x = 0.15,  
                y = 1.0,  
                text = "",  
                xref = "paper",  
                yref = "paper",  
                xanchor = "center",  
                yanchor = "bottom",  
                showarrow = FALSE, 
                size = 10

            ),  

            list( 
                x = 0.65,  
                y = 1,  
                text = "",  
                xref = "paper",  
                yref = "paper",  
                xanchor = "center",  
                yanchor = "bottom",  
                showarrow = FALSE,
                size = 10
            )
        ),
         updatemenus = list(
            list(
                direction = "down",
                xanchor = 'right',
                yanchor = "center",
                pad = list('r'= 0, 't'= 10, 'b' = 10),
                x = -0.055,
                y = -0.05,
                buttons = list(
                list(method = "restyle",
                    args = list("histnorm",  "probability"),
                    label = "Probability"),

                list(method = "restyle",
                    args = list("histnorm",  "norm"),
                    label = "Norm")))
        )
    )
    
    config(plt, displaylogo = FALSE)

    # htmlwidgets::saveWidget(as_widget(plt), "html/wrightMap.html")

    return (plt)
}

#' @param model Model from CTT package
#' @param language language de or en
#' @return returns a Scatter Plot with CTT Item Difficulty
scatterCTTDifficultyPlotly  <- function(model, language = "en"){
    if (missing(model)) {
        stop("'Model ' needs to be specified", call. = FALSE)
    }

    if (language == "de"){
        xAxisContent <- getLanguageList("de")$xAxisScatterDifficultyCTTPloty
        yAxisContent <- getLanguageList("de")$yAxisScatterDifficultyCTTPloty
    }
    else{
        xAxisContent <- getLanguageList("en")$xAxisScatterDifficultyCTTPloty
        yAxisContent <- getLanguageList("en")$yAxisScatterDifficultyCTTPloty
    }

    df.itemDiff <- getCTTItemDiff(model)

    # Plot it with plotly
    plt <- plot_ly()%>%add_trace(
        data = df.itemDiff, x = reorder(df.itemDiff$Item, df.itemDiff$Difficulty) , y = round(df.itemDiff$Difficulty, digits = 2), #if wanted unordered: x = ~Item
        type = "scatter",
        marker = list(size= 10, color ="#3374b1"),
        name = ' '
    )%>%config(
        displaylogo = FALSE,
        modeBarButtonsToRemove = c('zoom2d','pan2d','select2d', 'lasso2d', 'zoomIn2d', 'zoomOut2d', 'autoScale2d', 'resetScale2d')

    )%>%layout(
    xaxis=list(title = xAxisContent,list = (hoverformat = '.2f') ,zeroline = F),
    yaxis=list(title = '',list = (hoverformat = '.2f'))
    )

    return (plt)
}

#' @param model rasch Model from  TAM package
#' @param language language de or en
#' @return returns a Histogram with TAM Item Difficulty
histogramIRTPointsPlotly <- function(model, language = "en"){
    if (missing(model)) {
        stop("'Model ' needs to be specified", call. = FALSE)
    }

    if (language == "de"){
        xAxisContent <- getLanguageList("de")$xAxisHistogramIRTPloty
        yAxisContent <- getLanguageList("de")$yAxisHistogramIRTPloty
    }
    else{
        xAxisContent <- getLanguageList("en")$xAxisHistogramIRTPloty
        yAxisContent <- getLanguageList("en")$yAxisHistogramIRTPloty
    }

    df.itemDiff <- getItemDiff(model)


    #make a sliderinput list for the bin slider in plot
    sliderinput <- list()
    for (i in 1:length(df.itemDiff$Difficulty)) {
        item <- list(
            args = list("nbinsx", i),
            label = i,
            method = "restyle",
            value = as.character(i)
        )
        sliderinput <- c(sliderinput, list(item))
     }


    plt <- plot_ly()%>%add_trace(
    data = df.itemDiff, 
    x = round(df.itemDiff$Difficulty, digits = 2), #maybe use r Norm?  ~rnorm(500) instead of ~personAbility
    type = "histogram",
    histnorm = "probability", #vs norm
    nbinsx = 9,
    #binwidth = .1 #<- do i need binwidth?
    color = I("#3374b1")

    )%>%config(
        displaylogo = FALSE,
        modeBarButtonsToRemove = c('zoom2d','pan2d','select2d', 'lasso2d', 'zoomIn2d', 'zoomOut2d', 'autoScale2d', 'resetScale2d')

    )%>% layout(
    xaxis=list(title = xAxisContent,list = (hoverformat = '.2f')),
    yaxis=list(title = yAxisContent,list = (hoverformat = '.2f')), #make long ticks and make them invisible, not beautiful
  
    
        #making a bin slider
        sliders = list(
            list(
                active = 9,
                currentvalue = list(prefix = "Bin Size: "), 
                steps = sliderinput,
                pad = list(t = 50)
                )
            ),

        updatemenus = list(
            list(
                xanchor = 'right',
                yanchor = "center",
                pad = list('r'= 0, 't'= 0, 'b' = 0),
                x = -0.055,
                y = -0.05,
                buttons = list(
                list(method = "restyle",
                    args = list("histnorm",  "probability"),
                    label = "Probability"),

                list(method = "restyle",
                    args = list("histnorm",  "norm"),
                    label = "Norm")))
        )
    )


    # htmlwidgets::saveWidget(as_widget(plt), "html/histogramPoints.html")

    return (plt)
}

#' @param model Model from CTT package
#' @param language language de or en
#' @return returns a Histogram with CTT Item Difficulty
histogramCTTPointsPlotly <- function(model, language = "en"){
    if (missing(model)) {
        stop("'Model ' needs to be specified", call. = FALSE)
    }

    if (language == "de"){
        xAxisContent <- getLanguageList("de")$xAxisHistogramCTTPloty
        yAxisContent <- getLanguageList("de")$yAxisHistogramCTTPloty
    }
    else{
        xAxisContent <- getLanguageList("en")$xAxisHistogramCTTPloty
        yAxisContent <- getLanguageList("en")$yAxisHistogramCTTPloty
    }

    df.itemDiff <- getCTTItemDiff(model)


    #make a sliderinput list for the bin slider in plot p2
    sliderinput <- list()
    for (i in 1:length(df.itemDiff$Difficulty)) {
        item <- list(
            args = list("nbinsx", i),
            label = i,
            method = "restyle",
            value = as.character(i)
        )
        sliderinput <- c(sliderinput, list(item))
     }


    plt <- plot_ly()%>%add_trace(
    data = df.itemDiff, 
    x = round(df.itemDiff$Difficulty, digits = 2), #maybe use r Norm?  ~rnorm(500) instead of ~personAbility
    type = "histogram",
    histnorm = "probability", #vs norm
    nbinsx = 9,
    #binwidth = .1 #<- do i need binwidth?
    color = I("#3374b1")

    )%>%config(
        displaylogo = FALSE,
        modeBarButtonsToRemove = c('zoom2d','pan2d','select2d', 'lasso2d', 'zoomIn2d', 'zoomOut2d', 'autoScale2d', 'resetScale2d')

    )%>% layout(
    xaxis=list(title = xAxisContent,list = (hoverformat = '.2f')),
    yaxis=list(title = yAxisContent,list = (hoverformat = '.2f')), #make long ticks and make them invisible, not beautiful
  
    
        #making a bin slider
        sliders = list(
            list(
                active = 9,
                currentvalue = list(prefix = "Bin Size: "), 
                steps = sliderinput,
                pad = list(t = 50)
                )
            ),

        updatemenus = list(
            list(
                xanchor = 'right',
                yanchor = "center",
                pad = list('r'= 0, 't'= 0, 'b' = 0),
                x = -0.055,
                y = -0.05,
                buttons = list(
                list(method = "restyle",
                    args = list("histnorm",  "probability"),
                    label = "Probability"),

                list(method = "restyle",
                    args = list("histnorm",  "norm"),
                    label = "Norm")))
        )
    )


    # htmlwidgets::saveWidget(as_widget(plt), "html/histogramPoints.html")

    return (plt)
}

#' @param model Model from TAM package
#' @param language language de or en
#' @return returns a Violin Plot from a Item Difficulty
violinIRTPoints <- function(model, language = "en"){
    if (missing(model)) {
        stop("'Model ' needs to be specified", call. = FALSE)
    }

    if (language == "de"){
        xAxisContent <- getLanguageList("de")$xAxisViolinIRTPloty
    }
    else{
        xAxisContent <- getLanguageList("en")$xAxisViolinIRTPloty
    }

    df.itemDiff <- getItemDiff(model)



    plt <- plot_ly()%>%add_trace(
    data = df.itemDiff, x = round(df.itemDiff$Difficulty, digits = 2), #maybe use r Norm?  ~rnorm(500) instead of ~personAbility
    type = "violin",
    box = list(visible = T),
    points="all",
    #these to make trace0 disappear
    name = " ",
    hoverinfo = "x",
    color = I("#3374b1")
    #binwidth = .1 #<- do i need binwidth?
        
        
    )%>%config(
        displaylogo = FALSE,
        modeBarButtonsToRemove = c('zoom2d','pan2d','select2d', 'lasso2d', 'zoomIn2d', 'zoomOut2d', 'autoScale2d', 'resetScale2d')

    )%>%layout(
    xaxis=list(title = xAxisContent,list = (hoverformat = '.2f') ,zeroline = F),
    yaxis=list(title = '',list = (hoverformat = '.2f'))
    
    )

    #htmlwidgets::saveWidget(as_widget(plt), "violinPoints.html")

    return (plt)
}

#' @param model Model from CTT package
#' @param language language de or en
#' @return returns a Violin Plot with CTT Item Difficulty
violinCTTPoints <- function(model, language = "en"){
    if (missing(model)) {
        stop("'Model ' needs to be specified", call. = FALSE)
    }

    if (language == "de"){
        xAxisContent <- getLanguageList("de")$xAxisViolinCTTPloty
    }
    else{
        xAxisContent <- getLanguageList("en")$xAxisViolinCTTPloty
    }

    df.itemDiff <- getCTTItemDiff(model)
    print(df.itemDiff)
    plt <- plot_ly()%>%add_trace(
    data = df.itemDiff, x = round(df.itemDiff$Difficulty, digits = 2), #maybe use r Norm?  ~rnorm(500) instead of ~personAbility
    type = "violin",
    box = list(visible = T),
    points="all",
    #these to make trace0 disappear
    name = " ",
    hoverinfo = "x",
    color = I("#3374b1")
    #binwidth = .1 #<- do i need binwidth?
        
        
    )%>%config(
        displaylogo = FALSE,
        modeBarButtonsToRemove = c('zoom2d','pan2d','select2d', 'lasso2d', 'zoomIn2d', 'zoomOut2d', 'autoScale2d', 'resetScale2d')

    )%>%layout(
    xaxis=list(title = xAxisContent,list = (hoverformat = '.2f') ,zeroline = F),
    yaxis=list(title = '',list = (hoverformat = '.2f'))
    
    )

    #htmlwidgets::saveWidget(as_widget(plt), "violinPoints.html")

    return (plt)
}

difficultyComparison <- function(data, model){
    if (missing(model)) {
        stop("'Model ' needs to be specified", call. = FALSE)
    }

    df.itemDiff <- getItemDiff(model)
    cttItemDiff <- colMeans(data)
    print(cttItemDiff)
    trace_ctt <- cttItemDiff

    plt <- plot_ly(df.itemDiff , x = df.itemDiff$Item, y = df.itemDiff$Difficulty, name = 'IRT', type = 'scatter', mode = 'markers')
    plt <- plt %>% add_trace(y = cttItemDiff, name = 'CTT', mode = 'markers')
    plt <- plt %>% layout(

        updatemenus = list(
                list(
                direction = "right",
                xanchor = 'left',
                yanchor = "center",
                pad = list('r'= 0, 't'= 10, 'b' = 10),
                x = 0.3,
                y = 1.125,
                showactive = FALSE,
                buttons = list(
                list(method = "restyle",

                    args = list('type', 'scatter',{"x":"df.itemDiff$Item"}),

                    label = "Task"),

                list(method = "restyle",

                    args = list('type', 'scatter',{"x":"df.itemDiff$Item"}),

                    label = "Difficulty")))

        )
    )
    # htmlwidgets::saveWidget(as_widget(plt), "html/difficultyComparison.html")

    return (plt)

}

# dataset <- read.csv("test.csv")
# rasch_mod <- TAM::tam.mml(dataset)

#wrightMapPlotly(model = rasch_mod)
#histogramPoints(model = rasch_mod)
#violinPoints(model = rasch_mod)
# difficultyComparison(data = dataset, model = rasch_mod)

# work on normalize
# wrightMap(model = rasch_mod, normalize = TRUE)

# person_plotter_hist(getPersonAbility (rasch_mod))
# person_plotter(getPersonAbility (rasch_mod))
# normalized_person_plotter(rasch_Normalized_personAbility(rasch_mod))
# rasch_plotter(getItemDiff(rasch_mod))

# getPersonAbility (rasch_mod)


# y          <-          seq(-4,4,len=500)
# xp          <-          dnorm(y,
#                               mean=mean(wle.v7$theta),
#                               sd=sd(wle.v7$theta))(-1)
# xi          <-          pnorm(y,
#                               mean=mean(itemschwierigkeiten),
#                               sd=sd(itemschwierigkeiten))1+offset.achse+.5/length(itemschwierigkeiten)
