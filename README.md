# PePP-QQL3
Shiny Server for extended Exam Analysis and corresponding EvaExam Plugin 

# Installation 
Use Docker-compose to install a the Shiny Server in a Docker Container
(docker-compose up in directory of the docker-compose.yaml in a terminal)

# EvaExam Plugin
Configure the Config.ini file by put in the IP of the Shiny Server into the IP field.
Then Install the Plugin into EvaExam by compress the content of the PeppPluginEvaExam Folder into a .zip and upload it in the Plugin Section


# Usage without EvaExam
You can use the Dashboard without the EvaExam Plugin.
Simply put a csv-file (filename.csv) in tmp with the same shape as the test.csv and the dichotom-test.csv (both files needed, both can be dichotomous).
You then can call it from your browser with : http://localhost:8180/?token=filename (or http://'server IP':8180/?token=filename )

