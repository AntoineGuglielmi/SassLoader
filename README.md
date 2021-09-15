# SassLoader
I always loved sass. But I didn't like to add each new file path/to/_whatever.sass file in my main.sass file.  
So I created SassLoader, a little and simple sass files caller which looks for all the files in a directory of your choice and add them to a drop point sass file with a "@import" rule.

---
## To install
```
composer require AntoineGuglielmi/SassLoader
```

## To use
Let's assume that my project directories look like this:
```txt
public
-- css
-- sass
------ tools
-------- `_file01.sass
------ _file02.sass
src
-- ...
vendor
-- ...
index.php
```


In my `index.php` file, I'll put the following:  

```php
// creating a new SassLoader object
$sassloader = new SL\SassLoader('public/sass');
// setting 'public/sass/main.sass' as my drop point sass file, the one that will receive the "@import" rules
$sassloader->set_drop_point('main.sass');
// let's do the magic
$sassloader->load();
```

SassLoader will generate the `public/sass/main.sass` file which will look like the following:  
```sass
@import 'file02'
@import 'tools/file01'
```

All you have to do is to run your sass command, and voilà !

**More: my sass bat file**
```bat
if not DEFINED IS_MINIMIZED set IS_MINIMIZED=1 && start "" /min "%~dpnx0" %* && exit
    sass --watch public/sass:public/css --style expanded
exit
```
