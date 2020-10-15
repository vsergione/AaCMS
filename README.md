# AaCMS  
**Almost a CMS** aka **AaCMS** is a simple visual editor for live static websites written in PHP and JavaScript. It's easy to install (just copy the editor.php on your web server) and to use (load it in the web browser).

Use it to update static web pages and also create new pages using the _Save As_ feature

Being simple means that it's also limited in many aspects, including security stuff. So don't forget to check out the [Warnings](#warnings) section to find out more about how you can secure your installation.   

#### Screenshot
<img src='screenshot.png' alt='Screenshot of editor in action' title='Screenshot of editor in action' style='max-width: 100%; border: solid 1px'>


  
## Features  
- edit text   
- edit links  
- edit images  
- delete elements  
- copy/cut & paste elements within the page  
- save as (allows to create new files)  
- confirm "save as" when file exists already  
- uses basic authentication to authenticate users
  
## Requirements  
- a running web server (apache/nginx/lighttpd) with PHP support  
- website files should be writeable by the web server (see [Warnings](#warnings) )  
- it links to jquery and jquery-ui from an external CDN, therefore it is required a running internet connection for the client   
  
## Links  
* [GitHub](https://github.com/vsergione/AaCMS)  
* [Homepage](https://softaccel.net/aacms/)  
* [Demo](https://softaccel.net/aacms/editor.php?file=index.html) (user: demo, password: 123456)  
  
  
## Installation  
1. download editor.php from GitHub: https://raw.githubusercontent.com/vsergione/AaCMS/main/editor.php  
2. Edit `editor.php` and set a user and password. Multiple users can be added     
3. Copy/upload `editor.php` in the root folder of your website  
4. Security suggestion: rename file editor.php so it's name cannot be guesses easily  
  
  
## Usage  
Point your browser to  
  
 http(s)://yourwebsiteaddress/editor.php?file=file_to_edit.html  and start editing.  
  
You will notice a toolbox-like floating window that you can move around the page. By default it displays a "File menu" which you can use to save the file, save the file under a new name, reload or go to original file.  
  
By moving the mouse over the page the hovered elements will be highlighted with a dashed border. Clicking on the hovered element will enter the edit mode.  
  
Depending on the selected element type, you will get 2 standard menus and a selection dependent menu  
- **edit**: use this menu to perform copy/cut & paste operations  
- **traverse**: use the buttons from this menu to navigate through the elements tree. Useful especially for selecting elements which cannot be selected with a click, like: FORM, TABLE, FIELDSET, UL and so on  
- **text**: this menu becomes active when clicking an element which can be edited as text, like DIV, P, TD, LI and so on. Once the element is selected you can start to edit it. Also, it provides some basic styling options: bold, italic, increase/decrease font size, and so on. The styling will be applied only to the text selection and not on the entire selected element.  
- **image**: this menu becomes active when the selected element is an image and displays a form which can be used to modify the basic image properties  
- **link**: this menu becomes active when the selected element is a link and displays a form to edit the link properties  
  
  
## <a id='warnings'></a>Warnings  
This tool is like a knife: it's simple and straightforward (not much fanciness inside) and you can do useful stuff with it, but you can also cut yourself pretty bad. Therefore there are a few things which you should keep in mind when using it on your website:  
  
#### Security  
The security of this script is pretty low by itself. It uses Basic Auth to authenticate users which transmits password in clear. This means that you should **NEVER** use this on a live website without **HTTPS** enabled.    
  
The information about the users is hard coded in the script itself, so not a very flexible approach. Of course, you are free to implement your own methods. A quick improvement could be to create a separate PHP file where you store the users info placed outside the website DocRoot and include it in the script.      
  
#### File permissions  
This script, being run by the web server, it will access files with the web server user. On a typical Linux systems this is "www-data". Therefore, you should decide in advance which files/directories you want to allow to be edited and set their access rights or ownership accordingly.   
          
Do this either in Linux console by using any of the approaches bellow  
- set access rights: `chmod u+w your_file_or_directory_name` or   
- change ownership files to match the web server user:  `chown www-data your_file_or_directory_name`  
  
Or by using your favorite FTP client change either the access rights or the ownership of the files   
  
  
## Support  
Feel free to make feature requests, suggestions or signal any issues using the project GIT Hub Issues:   
https://github.com/vsergione/AaCMS
