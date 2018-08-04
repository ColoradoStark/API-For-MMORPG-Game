# API For an Asynchronous MMORPG Game
A very simple REST API that will return JSON objects.  It is written using the slim framework.  The code will set up a MySQL database with some basic player data for a turn based fantasy MMO.  It has basic CRUD functionality.
 

This repository is intended to be used with a server deployed by this wrapper: https://github.com/ColoradoStark/API-Server-Wrapper

Instructions:  

1. Follow the instructions to deploy a server here: https://github.com/ColoradoStark/API-Server-Wrapper
2. Replace the 2 directories titled ../API/public/ and ../API/src/ with the directories in this repository
3. Initialize the database by visiting the following URL: 127.0.0.1:8080/dbsetup.php

------------------------------------------------------------------------------------------------------

After you have set everything up, to test that the API is working as expected 
visit the following URL 127.0.0.1:8080/api/getallplayers
