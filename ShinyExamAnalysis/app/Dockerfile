# Base R Shiny image
FROM rocker/shiny

WORKDIR /app

RUN apt-get update && apt-get install -y texlive-latex-base && apt-get install -y texlive-fonts-recommended && apt-get install -y texlive-fonts-extra && apt-get install -y texlive-latex-extra


# Install R dependencies
RUN R -e "install.packages(c('dplyr', 'ggplot2', 'plotly' , 'gapminder', 'shinydashboard','jsonlite','callr','datasets','TAM','forcats','grid','CTT','shinyjs','bsplus','htmltools','rmarkdown','webshot','psych'))"
#RUN Rscript -e "tinytex::install_tinytex()"


# Copy the Shiny app code
COPY app.R /app

# Expose the application port
EXPOSE 8180

# Run the R Shiny app
CMD Rscript app.R

