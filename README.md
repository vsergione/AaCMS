# AaCMS
AaCMS or "Almost a CMS" is a single file visual website editor which allows instant modifications of static HTML pages of a website.  

##### Features
- edit text 
- delete HTML elements with point and click
- duplicate HTML elements
- move elements around the page with drag and drop
- create new files from existing ones using the save-as function 

#### Requirements
- a running webserver (apache/nginx/lighttpd) with PHP support
- website files should be writeable
- it uses jquery and jquery-ui which are loaded from an external CDN, therefore it is required a running internet connection for the client 

##Installation
1. Edit `editor.php` and set a user and password.   
2. Copy/upload `editor.php` in the root folder of your website

Note: feel free to rename editor.php to something more random. 

##Usage
Just point your browser to

    http(s)://yourwebsiteaddress/editor.php?file=file_to_edit.html

and start editing. 

You will notice a toolbox like floating window that you can move around the page.
 
Currently there are 4 tools:
- edit: edit the text which is contained by the yellow highlighted element
- delete: delete the red highlighted element
- move: move around the pink highlighted element
- clone: create clone of the red highlighted element

Use the Save button to overwrite the current file with the changes that you have done

Use "Save as" button to create a new file from the current file.

 
###<span style="color:red">Warnings</span>
- there is no undo
- when using "Save as" if the file name that you provide already exists, it will not prompt for confirmation rather it will overwrite it directly.
 
###Roadmap:
v1.0.1
- confirmation on overwrite
- add swap file for continuos saving
- edit links
- edit images




