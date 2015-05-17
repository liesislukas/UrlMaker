# UrlMaker
This is hellper class to manipulate current URL. Transform $_GET to html inputs, set, remove, update vars from query.


- **Get current URL**

$urlmaker->reset()->getQuery();

- **Set some $_GET vars and get final query**

$urlMaker->setVal('project', $project)->setVal('page', '1')->getQuery();

- **get val from $_GET**

$urlMaker->getVal('project');

-

**Full structure:**

![alt tag](https://raw.githubusercontent.com/liesislukas/UrlMaker/master/structure.png)
