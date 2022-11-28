TIME SPENT:

    TASK 1:
        1.1 AROUND 30 MINS - TO SOLVE THE WERID JS ERROR AND THEN RENDER THE MAP
        1.2 AROUND 15 MINS - TO DRAW THE POLYGON AROUND THE OFFICE
        1.3 5 MINS  - TO GET THE MAP SIZED TO VIEWPORT

    TASK 2:
        IN TOTAL, AROUND 4 HOURS
        1. AROUND 1 HOUR -  TO UNDERSTAND THE LEAFLET MAP AND ITS MARKERS, ETC
        2. NEXT 1 HOUR - TO MOVE THE OBJECT WITH ARROW KEYS AT SPECIFIC SPEED
        3. NEXT 2 HOURS - TO CREATE THE DATABAES, CONNECTION TO IT AND IMPLEMENT FUNCTIONALITIES TO QUERY.

RUNNING THE PROJECT:

1.  CLONE OR DOWNLOAD THE GIT REPOSITORY, LINK: 2. IMPORT THE SQL FILE IN THE DATABASE,
    INCASE YOU ENCOUNTER ERROR, THERE ARE ONLY TWO TABLES. SO, YOU CAN CREATE THEM MANUALLY

            STEP 1:: CREATE THE DATABASE NAME 'rolling_tomato'

            STEP 2:: CREATE TWO TABLES NAMED AS 'speeds' and 'sucesses' - SEE THE SQL FILES FOR DATATYPES
                QUERY 1::
                    CREATE TABLE IF NOT EXISTS `speeds` (
                    `id` int NOT NULL AUTO_INCREMENT,
                    `value` int NOT NULL,
                    `unit` varchar(255) NOT NULL,
                    PRIMARY KEY (`id`)
                    );
                QUERY 2::
                    CREATE TABLE IF NOT EXISTS `sucesses` (
                    `id` int NOT NULL AUTO_INCREMENT,
                    `session_id` varchar(255) NOT NULL,
                    `time` varchar(255) NOT NULL,
                    `unit` varchar(255) NOT NULL,
                    PRIMARY KEY (`id`)
                    );

            STEP 3:: INSTER TWO RECORDS IN THE TABLE 'speeds' manually. - SEE THE SQL FILE FOR REFERENCES
                QUERY 1::
                INSERT INTO `speeds` (`id`, `value`, `unit`) VALUES
                (1, 500, 'kph'),
                (2, 1000, 'kph');

2.  SIMPLY OPEN THE FILES IN YOU BROWESER AS HOW YOU WOULD RUN A PHP PROGRAM.

//////////////////////////////////////////////////////////////////////////////////////////////////
INCASE YOU NEED ANY HELP AND WOULD LIKE TO TALK TO THE AUTHOR, EMAIL AT: katelroshan13@gmail.com
/////////////////////////////////////////////////////////////////////////////////////////////////
