
# Introduction :

This package is for updating your Laravel project via view without doing any command in the prompt, this package may be useful when you sell your project to multiple people as they will update without any intervention from you via a simple destination

# How it works :

When you do any "Release and TAG " a new update will appear

# Install :

  

Run this command for install :

  

> composer require salahhusa9/updater

  

For edit config file or view :

  

> php artisan vendor:publish

  

## Start and Test:

  

 1. Clone You private repo used ssh , Because it not asks to enter the
    password when "git pull" is Running ,Or any other way that respects
    this
 
 2. [GITHUB PRIVATE ACCESS TOKEN](https://docs.github.com/en/github/authenticating-to-github/keeping-your-account-and-data-secure/creating-a-personal-access-token)
 
 3. Create a first version in github Tag : 1.0.0
 4. Env :
    ```env
    SELF_UPDATER_VERSION_INSTALLED=1.0.0
    SELF_UPDATER_GITHUB_PRIVATE_ACCESS_TOKEN="YOUR_GITHUB_PRIVATE_ACCESS_TOKEN"

    SELF_UPDATER_REPO_VENDOR="YOUR_GITHUB_USERNAME"
    SELF_UPDATER_REPO_NAME="YOUR_GITHUB_REPO_NAME"
    ```

5. If You need to update :
    ```env
    SELF_UPDATER_DATABASE_TYPE=sql
    SELF_UPDATER_SQL_PATH="YOUR_PATH_SQL_FILE"
    ```
    ex : 
    > SELF_UPDATER_SQL_PATH="database/sql"

    For sql file name it : version.sql ,ex : 1.0.0.sql

 6. Test If all work :
    Run 
    > php artisan updater:check-for-update
    
    Response :
    > There\'s no new version available.

# How to use :

    Enter to :
   [youdomain/update](http://127.0.0.1:8000/update)

## Config :

  

This for Maintenance Mode : true / false / manual ,if need to activate or deactivate it in update

  

```PHP

'maintenance-mode' => 'manual',

```