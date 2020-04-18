# get-shit-done 

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
* PHP
* [NodeJS](https://nodejs.org/en/)

Do the following inside of '/project1':

```shell
# install grunt globally
$ npm install -g grunt-cli
    
# install other dependencies
$ npm install

# run Grunt to compile Sass files:
$ grunt

# run server
$ php -S localhost:8080
    
```

### Demo users


Username | Password
 --- | --- 
cyrilico | piroxenas@99
diogotorres97 | caloiras@99
antonioalmeida | randompassword@99
hdicty0 | jk=j?Nw7)E
dshama1 | PO0JhceYz29;
yipsgrave2 | Jhp/UsuR#mF9c
wstolberger3 | 5Dxb*XZE9CcReasWT=MlRlB@zVt66M
zdowney4 | u5WtV7=up1yVAw1a;CEH?s_FGhI54
ctinman5 | Zy5%S!vRM3@t0


__Disclaimer__: Session ID regeneration is implemented. However, the required configuration doesn't work on local servers, so the functionality is disabled by default. To activate it, uncomment `session.php:7`. It works when hosted properly (for example on `gnomo.fe.up.pt`)

### Used libraries
- [FontAwesome](fontawesome.com) - icons
- [Sass](http://sass-lang.com/) - used to properly structure CSS by taking use of its core features, mostly by using variables and nesting (no need to compile it to run, resulting css file is already included and linked)

### Other Resources
- Animated checkbox based on https://codepen.io/daniandl/pen/OgbXzK
- Animated material board shadow based on https://codepen.io/sdthornton/pen/wBZdXq
- Buttons and typography sizes based on https://milligram.io/%
