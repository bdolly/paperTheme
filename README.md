#paperTheme

paperTheme is a WordPress hacker theme built from  _s (http://underscores.me) with parts adapted from Bones (http://themble.com/bones/). Hack it, push it, pull request it, put a fork in it, have fun with it and if you have an issue with that.....well you know where to put it.
<hr>
###Repo-genesis (how this repo started)

paperTheme's root repo is a fork of the Wordpress repo (https://github.com/WordPress/WordPress) which is updated every 15minutes from their svn. This fork was created so that the core files will easily be in-sync with the latest WordPress updates. This also allows you roll back core files easily 
and version out certain plugins so that when you clone the repo you have everything you need. This also allows you to grab the optimized .htaccess file when you clone it down. 
the paperTheme files are a modified fork of _s (http://underscores.me) by Automattic, these files have been changed and customized by keep their with the _s theme structure. Giving credit where credit is due paperTheme's responsice sass structure is adapted from Bones (http://themble.com/bones/) 
and also includes alot of customization.

paperTheme itself is meant to be used as an uncompressed developement theme with comes with grunt task for building production ready theme. 

<hr>
##paperTheme workflow

This workflow assumes a basic knowledge of the terminal, GIT, WP installation, Node.js, and Grunt.js 

1. git clone where you want the WP install to be 
2. ```$ git add remote upstream https://github.com/WordPress/WordPress.git ```<br>
   This makes sure you have an upstream branch to the WordPress repo to pull new version changes or be able to roll back 
3. Setup remote tracking branches to your repo. NOTE:Please submit changes to paperTheme repo as pull request   
4. install WP
5. ```$ cd paperTheme/wp-content/themes/paperTheme```<br>
6. ```$ npm install``` <br>
   This sets-up the grunt task in Gruntfile.js 
7. change the ClientName and Author variables in the top of Gruntfile.js 
8. ```$ grunt watch ``` 
  Start hacking at the theme and building awesome stuff with it
9. git commit your changes 
10. ```$ grunt build ``` <br>
   Builds your production theme using the ClientName variable in Gruntfile.js
11. Activate your theme and check it out locally to make sure it's solid
13. ```$ grunt deploy ``` <br>
    This grunt builds, git adds and commits your production theme, then runs git push origin master
14. DRINK BEER! (or don't if you're straight edge, it's cool )
