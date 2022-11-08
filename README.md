Flashcard CLI
==============
This is a test which provided for Studoc Comapny for the Software Developer Position.

Here is the bussiness logic that asked for the test:

We want an interactive CLI program for Flashcard practice. For context: a flashcard is a spaced repetition tool for memorising questions and their respective answers.  
The command \`php artisan flashcard:interactive\` should present a main menu with the following actions:  

1 . Create a flashcard
----------------------
The user will be prompted to give a flashcard question and the only answer to that question. The question and the answer should be stored in the database.  

2 . List all flashcards
----------------------
A table listing all the created flashcard questions with the correct answer.  

3 . Practice
----------------------

This is where a user will practice the flashcards that have been added.  
First, show the current progress: The user will be presented with a table listing all questions, and their practice status for each question: Not answered, Correct, Incorrect.  
As a table footer, we want to present the % of completion (all questions vs correctly answered).  
Then, the user will pick the question they want to practice. We should not allow answering questions that are already correct.  
Upon answering, store the answer in the DB and print correct/incorrect.  
Finally, show the first step again (the current progress) and allow the user to keep practicing until they explicitly decide to stop.  

4 . Stats
----------------------

Display the following stats:  
\- The total amount of questions.  
\- % of questions that have an answer.  
  
\- % of questions that have a correct answer.  

5 . Reset 
----------------------

This command should erase all practice progress and allow a fresh start.  


6 . Exit
----------------------

This option will conclude the interactive command.  
Note: The program should only exit by choosing the \`Exit\` option on the main menu (or killing the process)

How to use?
==============

- Get clone of the project
- Make sure that you install Docker before you start.
- Go to the folder of the project

### Run the docker enverioment
```
docker-compose up
```

### Go to the docker enverioment
```
docker-compose up myapp bash
```

### Make Flashcard Command Line Interactive by running this line
```
php artisan flashcard:interactive
```


There is an {--action} switch there which could be:
*   List
*   Create
*   Practice
*   Stats
*   Reset
*   Exit


------------------------------------------------------------------------
Also there some alternative way for doing this actions:


### Flashcard List
```
php artisan flashcard:list
```
### Flashcard Create
```
php artisan flashcard:create
```
### Flashcard Practice
```
php artisan flashcard:practice
```
### Flashcard Stats
```
php artisan flashcard:stats
```
### Flashcard Reset
```
php artisan flashcard:reset
```
### Flashcard Exit
```
php artisan flashcard:exit
```


