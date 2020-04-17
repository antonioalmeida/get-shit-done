# get-shit-done 
Made with [@cyrilico](https://github.com/cyrilico) and [@diogotorres97](https://github.com/diogotorres97).
Repository to host Web Languages and Technologies' [project](https://web.fe.up.pt/~arestivo/page/courses/2017/ltw/project/). 

Work done for a subject in Web Languages and Technologies [LTW] in MIEIC @FEUP, in collaboration with [@cyrilico](https://github.com/cyrilico) and [@diogotorres97](https://github.com/diogotorres97).
 
## Goal
Create a web application where users can [store and share to-do lists](https://web.fe.up.pt/~arestivo/page/courses/2017/ltw/project/).  

## Features
### Users
 * Profile (visualization and edit)
 * Authentication
 
### Lists
 * Create new lists
 * Manage your lists
 * Share ownership
 
### Items / Tasks
 * Create new items
 * Manage your items (set as completed, update priority, assign users...)
 
### Others
 * URIs to store the profile pics
 * Advanced lists, users and items search capabilities
 * Web attacks prevention (XSS, SQL injection, Path Traversal, Bcrypt,Session Fixation, etc)

## Technologies
* SQLITE database where data about users and to-do lists is stored;
* Sass as a CSS preprocessor;
* PHP as an intermediate bridge between the webpages and the data from the database;
* Javascript/AJAX to enhance the user experience.

## Gallery

| [<img src="/res/mainPage.png" width="256" heigth="256">](/res/mainPage.png)                                                                   | [<img src="/res/profilePage.png" width="256" heigth="256">](/res/profilePage.png)                                                             | [<img src="/res/listsPage.png" width="256" heigth="256">](/res/listsPage.png) |
|:---:|:---:|:---:|
| Home Page | User Profile | Lists Page |

| [<img src="/res/itemPage.png" width="256" heigth="12">](/res/itemPage.png)                                                        | [<img src="/res/discoverPage.png" width="256" heigth="256">](/res/discoverPage.png)                                               | [<img src="/res/sharePage.png" width="256" heigth="256">](/res/sharePage.png) |
|:---:|:---:|:---:|
| Items Page | Discover Page | Share Page |

## Install development environment
Requirements:
* [NodeJS](https://nodejs.org/en/)

Do the following inside of '/project1':

#### 1 - Install Grunt globally:

    $ npm install -g grunt-cli
    
#### 2 - Install other dependecies: 

    $ npm install
#### 3 - Run Grunt to compile Sass:

    $ grunt
#### 4 - Run PHP Server

    $ php -S localhost:8080
    
