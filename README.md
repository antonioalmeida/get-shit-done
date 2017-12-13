# LTW
Repository to host Web Languages and Technologies [project](/Project%20Specification.pdf).

LTW is a course given at FEUP in the third year of the MIEIC.
 
## Goal
Create a web application where users can store and share to-do lists. 

## Features
### Users
 * Profile (visualization and edit)
 * Authentication
 
### Lists
 * Create new lists
 * Manage your lists
 * Share ownership
 
### Items
 * Create new items
 * Manage your items (set completed, priority, assign users...)
 
### Others
 * URIs to store the profile pics
 * Advanced lists, users and items search capabilities
 * Web attacks prevention (XSS, SQL injection, Path Traversal, Bcrypt,Session Fixation, etc)

## Technologies
* SQLITE database where data about users and to-do lists is stored.
* HTML and CSS to create the application design.
* PHP as an intermediate bridge between the webpages and the data from the database.
* Javascript/AJAX to enhance the user experience.

## Gallery

| [<img src="/res/mainPage.png" width="256" heigth="256">](/res/mainPage.png)                                                                   | [<img src="/res/profilePage.png" width="256" heigth="256">](/res/profilePage.png)                                                             | [<img src="/res/listsPage.png" width="256" heigth="256">](/res/listsPage.png) |
|:---:|:---:|:---:|
| Home Page | User Profile | Lists Page |

| [<img src="/res/itemPage.png" width="256" heigth="12">](/res/itemPage.png)                                                        | [<img src="/res/discoverPage.png" width="256" heigth="256">](/res/discoverPage.png)                                               | [<img src="/res/sharePage.png" width="256" heigth="256">](/res/sharePage.png) |
|:---:|:---:|:---:|
| Items Page | Discover Page | Share Page |

## How To Run

Install:
* [NodeJS](https://nodejs.org/en/)


Run: 

    $ npm install -g grunt-cli

Inside of project1:

    $ npm install

    $ grunt

And run a php server

## Team 
[António Almeida](https://github.com/antonioalmeida)

[João Damas](https://github.com/cyrilico)

[Diogo Torres](https://github.com/diogotorres97)

