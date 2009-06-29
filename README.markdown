## Noginn_Service_YahooBoss ##
Noginn_Service_YahooBoss is a Zend Framework component that wraps the Yahoo BOSS search API (http://developer.yahoo.com/search/boss/).

## How to ##
### Basic usage ###

    $boss = new Noginn_Service_YahooBoss('APPID');
    $result = $boss->webSearch('query string', array(
        'count' => 25,
        'start' => 0
    ));
    
I plan to write some actual documentation in the wiki in the not so distant future. 
For now, have a poke around in the code and take a look at the Yahoo BOSS API documentation