# CorkMeNot

CorkMeNot is a basic note card application, intended to be similar to note cards pinned to actual cork board. It is 
developed in an attempt to be accessible by any network-connected device. 

The user may create multiple "stories" of up to 1,000 cards each, enter information on each card and rearrange the 
cards using drag-and-drop. The user can choose how many columns of cards are displayed by choosing the column number at 
the top of the list, or using the '[+]' link to add a column.

If a card contains more text than fits on the card, a red '*' appears at the top of the card.

Each new story created has 300 blank cards. The exact number shown/available depends on the number of columns. If one 
column is displayed, then all the cards are available. If seven columns are displayed, then 294 cards are available, 
due to rounding.

When there are less than 100 blank cards remaining in a story, the user may add an additional 100 blank cards on the 
stories page. The stories page shows the # of non-blank cards and total cards per story.

As the amount of information and number of cards increases, the user may experience degraded performance, depending on 
their system. It may be beneficial to break a large project into multiple stories.

To edit a card, click or touch on the card to switch it into edit mode. You can type your contents in the text field. 
Plain text only. Any input HTML, Markdown, Javascript is encoded and displayed as plain text.

To save your edits, click or touch an area outside of the text edit box. The text is saved automagically. 

To rearrange cards, click or touch a card and drag it to the desired position.

Try it out at https://corkmenot.com/

## Screenshots

![CorkMeNot Screenshot, card display](https://github.com/arduent/corkmenot/blob/current/CorkMeNot-ss1.png?raw=true)

![CorkMeNot Screenshot, stories display](https://github.com/arduent/corkmenot/blob/current/CorkMeNot-ss2.png?raw=true)


## Installation

CorkeMeNot is hosted on a web server such as NGINX, with PHP. CorkMeNot has been tested with PHP Version 8.1, however 
the software should function on all active versions. The software also requires an available MySQL server (or MariaDB).
MariaDB version 10.5.12 has been tested, however any active version should suffice.

1. Create a database and user on your MySQL/MariaDB server. 
2. Enter the username, password, host, and database name in db.php
3. Enter the URL path for the root constant. Do not use a trailing backslash. If your installation point is at the root
of the web server then leave the blank string ''. If you put it in a directory, such as 
https://example.com/path/to/program, then enter '/path/to/program' for root.
4. Run create.sql on the MySQL/MariaDB server.
5. Open the site in your browser. You will create an account and log in. 

## Caveats

There is no sort function. There is no delete function.

In this version no emails are sent, so there is no code to verify the email address provided for the account. Also, 
there is no password reminder or reset service. There is a basic SPAM protection scheme, however no CAPTCHA code. 

If you want a cork board background image, you can edit the style in layout.html

You can change the header image and jquery src (maybe use CDN?) by editing function output in db.php

When using a touch screen device, such as a mobile phone, you may have to press and hold a card for a few seconds 
before dragging it to another position.

## Cookies

The following cookies are used:

- ^au^ session string. Used to keep track of the login. Expiration: 30 days. Set in dologin.php
- ^col^ an integer representing the number of columns displayed.  Expiration: 2 years. Set in index.php
- ^story^ an integer representing the current story. Expiration: 30 days. Set in index.php

## License

See LICENSE.txt  
This program includes jQuery v3.6.0 | (c) OpenJS Foundation and other contributors | jquery.org/license 
