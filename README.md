# puush-patcher
### DISCLAIMER
```
I (Thomas Armstrong) pulled this from [https://github.com/xSamagon/puush]
where it was last updated 8 years ago. I have made some substantial changes to the code
as well as added some new features (like registration and a client patcher).
```


# Server
## Requirements
You need an webserver with PHP and MySQL and a good amount of storage space on the server if you're wanting to store a large number of files.

## Setup

You'll need to upload everything to the root of your webserver.
After doing so, you'll need to setup the database and the rewrite rules.
From there you can go to the register.php page and create an account.


### SQL
First of all create a database and execute the following queries:
```sql
CREATE TABLE `accounts` (
  `email` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL,
  `apikey` varchar(200) NOT NULL,
  `domain` varchar(200) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `apikey` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `orginalname` varchar(200) NOT NULL,
  `thumbenabled` tinyint(200) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL,
  `viewcount` bigint(200) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
```



### RewriteRules
I committed a `.htaccess_example` file as example. 
You will need to change the example.com domain and such to your server and rename the file to `.htaccess` and upload it to the root of your server.



### PHP
Look through the following two files. You'll need to copy/rename `Database.conf.php.example` to `Database.conf.php` and then modify it to your needs.
* `include/config/Database.conf.php.example`
* `include/config/Global.conf.php`

Make sure you give enough permissions to the files! ( Remember, it has to store files on the server ;) )

# Client
## Requirements
You need the old puush uploader (You can find the uploader in the bin folder, or you can download it from the official website: https://puush.me/dl/puush.exe).
You'll also need python to patch the client to your domain using the `patcher.py` file in the bin folder.
Note that the domain you use has to be the same length as puush.me. If you don't have a domain that length, you can modify your hosts file and point puush.me to your server.

