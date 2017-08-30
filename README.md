# TeamSpeak Hosting Script v1.1
A simple TeamSpeak Hosting Script with Database integration, written in PHP, MySQL using Bootstrap for the form design.
***
## Installation
**Clone or Download the Repository**

`$ git clone https://github.com/panteLx/teamspeakhostingscript.git`


**Creating the MySQL Database**

*Create Database "ts" and table "ts".*

```mysql
CREATE TABLE `ts` (
  `ID` int(30) NOT NULL,
  `Slots` text NOT NULL,
  `Servername` text NOT NULL,
  `Port` text NOT NULL,
  `Passwort` text,
  `IP` text NOT NULL,
  `Browser` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Token` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
```

**Setup the `config.php` file**

*Fill in your TeamSpeak- and Server Database Data.*

```php
<?php
// TS DATABASE
$HOST_QUERY = "schokolade.gq";  // Localhost is invalid! You need to add an IP (Otherwise you can't join the created TeamSpeak)
$PORT_QUERY = "10011";
$USER_QUERY = "serveradmin";
$PASS_QUERY = "";
$NICK_QUERY = "TeamSpeakHostingScript";

// SERVER DATABASE
$DB_IP = "localhost"; // Localhost is valid!
$DB_USER = "root";
$DB_PASS = "";
?>
```
## Screenshots

![img1](https://i.imgur.com/O8bHtIK.png)

![img2](https://i.imgur.com/CtF5Tpl.png)

![img3](https://i.imgur.com/CFX2vc4.png)

![img4](https://i.imgur.com/suYUO0b.png)

***
_If you have Problems feel free to contact me._
