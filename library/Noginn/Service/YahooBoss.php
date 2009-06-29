<?php

/**
 * Yahoo! BOSS API wrapper
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage YahooBoss
 * @author Tom Graham
 */
class Noginn_Service_YahooBoss
{
    /**
     * The base URI of the API
     */
    const API_URI_BASE = 'http://boss.yahooapis.com/ysearch';
    
    /**
     * API paths
     */
    const API_PATH_WEB = '/web/v1/%s';
    const API_PATH_IMAGE = '/images/v1/%s';
    const API_PATH_NEWS = '/news/v1/%s';
    const API_PATH_INLINK = '/se_inlink/v1/%s';
    const API_PATH_PAGEDATA = '/se_pagedata/v1/%s';
    const API_PATH_SPELLING = '/spelling/v1/%s';
    
    /**
     * The namespace used in the API responses
     */
    const API_RESPONSE_NAMESPACE = 'http://www.inktomi.com/';
    
    /**
     * The application ID
     *
     * @var string
     */
    protected $_appId;
    
    /**
     * The HTTP client used to make the API requests
     *
     * @var Zend_Http_Client
     */
    protected $_httpClient;
    
    /**
     * Constructor
     *
     * @param string $appId The application ID
     */
    public function __construct($appId)
    {
        $this->_appId = $appId;
    }
    
    /**
     * Performs a web search
     *
     * @param string $query 
     * @param array $options 
     * @return Noginn_Service_YahooBoss_WebResultSet
     */
    public function webSearch($query, array $options = array())
    {
        static $defaultOptions = array(
            'start' => 0,
            'count' => 10,
        );
        
        if (empty($query) || !is_string($query)) {
            throw new Zend_Service_Exception('You must supply a query string');
        }
        
        $options = $this->_prepareWebSearchOptions($options, $defaultOptions);
        
        // Make the search request
        $response = $this->_makeRequest(sprintf(self::API_PATH_WEB, urlencode($query)), $options);
        $dom = $this->_convertResponseAndCheckContent($response);
        
        return new Noginn_Service_YahooBoss_WebResultSet($dom, $this);
    }
    
    /**
     * Performs an image search
     *
     * @param string $query 
     * @param array $options 
     * @return Noginn_Service_YahooBoss_ImageResultSet
     */
    public function imageSearch($query, array $options = array())
    {
        static $defaultOptions = array(
            'start' => 0,
            'count' => 10,
            'filter' => 'yes',
            'dimensions' => 'all',
        );
        
        if (empty($query) || !is_string($query)) {
            throw new Zend_Service_Exception('You must supply a query string');
        }
        
        $options = $this->_prepareImageSearchOptions($options, $defaultOptions);
        
        // Make the search request
        $response = $this->_makeRequest(sprintf(self::API_PATH_IMAGE, urlencode($query)), $options);
        $dom = $this->_convertResponseAndCheckContent($response);
        
        return new Noginn_Service_YahooBoss_ImageResultSet($dom, $this);
    }
    
    /**
     * Performs a news search
     *
     * @param string $query 
     * @param array $options 
     * @return Noginn_Service_YahooBoss_NewsResultSet
     */
    public function newsSearch($query, array $options = array())
    {
        static $defaultOptions = array(
            'start' => 0,
            'count' => 10,
        );
        
        if (empty($query) || !is_string($query)) {
            throw new Zend_Service_Exception('You must supply a query string');
        }
        
        $options = $this->_prepareNewsSearchOptions($options, $defaultOptions);
        
        // Make the search request
        $response = $this->_makeRequest(sprintf(self::API_PATH_NEWS, urlencode($query)), $options);
        $dom = $this->_convertResponseAndCheckContent($response);
        
        return new Noginn_Service_YahooBoss_NewsResultSet($dom, $this);
    }
    
    /**
     * Returns a spelling suggestion for a given word
     *
     * @param string $text 
     * @return string
     */
    public function getSpellingSuggestion($text)
    {
        if (empty($text) || !is_string($text)) {
            throw new Zend_Service_Exception('You must supply text string');
        }
        
        $options = $this->_prepareOptions();
        
        // Make the search request
        $response = $this->_makeRequest(sprintf(self::API_PATH_SPELLING, urlencode($text)), $options);
        $dom = $this->_convertResponseAndCheckContent($response);
        
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('boss', Noginn_Service_YahooBoss::API_RESPONSE_NAMESPACE);
        
        $suggestion = $xpath->query('//boss:suggestion/text()');
        if ($suggestion->length == 1) {
            // Return the suggestion
            return (string) $suggestion->item(0)->data;
        }
        
        // No suggestions
        return '';
    }
    
    /**
     * Retrieves the "in-links" to a given URL.
     *
     * @param string $url 
     * @param array $options 
     * @return Noginn_Service_YahooBoss_InLinkResultSet
     */
    public function getInLinks($url, array $options = array())
    {
        static $defaultOptions = array(
            'start' => 0,
            'count' => 10,
        );
        
        if (empty($url) || !is_string($url)) {
            throw new Zend_Service_Exception('You must supply a URL string');
        }
        
        $options = $this->_prepareInLinkOptions($options, $defaultOptions);
        
        // Make the search request
        $response = $this->_makeRequest(sprintf(self::API_PATH_INLINK, urlencode($url)), $options);
        $dom = $this->_convertResponseAndCheckContent($response);
        
        return new Noginn_Service_YahooBoss_InLinkResultSet($dom, $this);
    }
    
    /**
     * Retrieves the page data of pages on a given URL.
     *
     * @param string $url 
     * @param array $options 
     * @return Noginn_Service_YahooBoss_PageDataResultSet
     */
    public function getPageData($url, array $options = array())
    {
        static $defaultOptions = array(
            'start' => 0,
            'count' => 10,
        );
        
        if (empty($url) || !is_string($url)) {
            throw new Zend_Service_Exception('You must supply a URL string');
        }
        
        $options = $this->_preparePageDataOptions($options, $defaultOptions);
        
        // Make the search request
        $response = $this->_makeRequest(sprintf(self::API_PATH_PAGEDATA, urlencode($url)), $options);
        $dom = $this->_convertResponseAndCheckContent($response);
        
        return new Noginn_Service_YahooBoss_PageDataResultSet($dom, $this);
    }
    
    /**
     * Prepares the user supplied options.
     *
     * @param array $options 
     * @param array $defaultOptions 
     * @return array The validated and formatted options
     */
    protected function _prepareOptions(array $options = array(), array $defaultOptions = array())
    {
        // Ensure the response format is always XML
        $options['format'] = 'xml';
        
        // Always set the correct application ID
        $options['appid'] = $this->getAppId();
        
        $options = array_merge($defaultOptions, $options);
        
        return $options;
    }
    
    /**
     * Prepares the web search specific options
     *
     * @param array $options 
     * @param array $defaultOptions 
     * @return array
     */
    protected function _prepareWebSearchOptions(array $options, array $defaultOptions)
    {
        static $validOptions = array(
            'appid', 'start', 'count', 'lang', 'region', 'strictlang', 'format',
            'sites', 'view', 'style', 'filter', 'type', 'abstract'
        );
        
        $options = $this->_prepareOptions($options, $defaultOptions);
        
        if (isset($options['filter'])) {
            if (is_string($types)) {
                $options['filter'] = array($options['filter']);
            }
            
            if (!is_array($options['filter'])) {
                throw new Zend_Service_Exception('The "filter" option must be a string or array of strings');
            }
            
            // Convert the array to a comma separated list of filters the API understands
            $options['filter'] = implode(',', $options['filter']);
        }
        
        if (isset($options['type'])) {
            if (is_string($options['type'])) {
                $options['type'] = array($options['type']);
            }
            
            if (!is_array($options['type'])) {
                throw new Zend_Service_Exception('The "type" option must be a string or array of strings');
            }
            
            // Convert the array to a comma separated list of types the API understands
            $options['type'] = implode(',', $options['type']);
        }
        
        if (isset($options['view'])) {
            if (is_string($options['view'])) {
                $options['view'] = array($options['view']);
            }
            
            if (!is_array($options['view'])) {
                throw new Zend_Service_Exception('The "view" option must be a string or array of strings');
            }
            
            // Convert the array to a comma separated list of views the API understands
            $options['view'] = implode(',', $options['view']);
        }
        
        $this->_compareOptions($options, $validOptions);
        
        return $options;
    }
    
    /**
     * Prepares the image search specific options
     *
     * @param array $options 
     * @param array $defaultOptions 
     * @return array
     */
    protected function _prepareImageSearchOptions(array $options, array $defaultOptions)
    {
        static $validOptions = array(
            'appid', 'start', 'count', 'lang', 'region', 'strictlang', 'format', 
            'style', 'filter', 'dimensions', 'refererurl', 'url'
        );
        
        $options = $this->_prepareOptions($options, $defaultOptions);
        
        if (isset($options['filter'])) {
            // Convert the boolean value to yes/no string that the API understands
            if ($options['filter'] == true) {
                $options['filter'] = 'yes';
            } else {
                $options['filter'] = 'no';
            }
        }
        
        $this->_compareOptions($options, $validOptions);
        
        return $options;
    }
    
    /**
     * Prepares the news search options
     *
     * @param array $options 
     * @param array $defaultOptions 
     * @return array
     */
    protected function _prepareNewsSearchOptions(array $options, array $defaultOptions)
    {
        static $validOptions = array(
            'appid', 'start', 'count', 'lang', 'region', 'strictlang', 'format', 
            'style', 'age', 'orderby', 'view'
        );
        
        $options = $this->_prepareOptions($options, $defaultOptions);
        
        if (isset($options['view']) && $options['view'] != 'language') {
            throw new Zend_Service_Exception($options['view'] . ' is not a valid "view" option');
        }
        
        $this->_compareOptions($options, $validOptions);
        
        return $options;
    }
    
    /**
     * Prepares the in-link request options
     *
     * @param array $options 
     * @param array $defaultOptions 
     * @return array
     */
    protected function _prepareInLinkOptions(array $options, array $defaultOptions)
    {
        static $validOptions = array(
            'appid', 'start', 'count', 'lang', 'region', 'strictlang', 'format', 
            'style', 'entire_site', 'omit_inlinks'
        );
        
        $options = $this->_prepareOptions($options, $defaultOptions);
        $this->_compareOptions($options, $validOptions);
        
        return $options;
    }
    
    /**
     * Prepares the page data request options
     *
     * @param array $options 
     * @param array $defaultOptions 
     * @return array
     */
    protected function _preparePageDataOptions(array $options, array $defaultOptions)
    {
        static $validOptions = array(
            'appid', 'start', 'count', 'lang', 'region', 'strictlang', 'format', 
            'style', 'domain_only'
        );
        
        $options = $this->_prepareOptions($options, $defaultOptions);
        $this->_compareOptions($options, $validOptions);
        
        return $options;
    }
    
    /**
     * Compares the user options with the given valid options.
     *
     * @param array $options 
     * @param array $validOptions 
     * @return void
     * @throws Zend_Service_Exception
     */
    protected function _compareOptions(array $options, array $validOptions)
    {
        $difference = array_diff(array_keys($options), $validOptions);
        if ($difference) {
            throw new Zend_Service_Exception('The following parameters are invalid: ' . implode(',', $difference));
        }
    }
    
    /**
     * Makes a request
     *
     * @param string $path 
     * @param array $options 
     * @return Zend_Http_Response_Abstract
     * @throws Zend_Service_Exception
     */
    protected function _makeRequest($path, array $parameters = array())
    {
        $httpClient = $this->getHttpClient();
        $httpClient->resetParameters();
        $httpClient->setUri(self::API_URI_BASE . $path);
        $httpClient->setParameterGet($parameters);
        $response = $httpClient->request('GET');
        
        if ($response->isError()) {
            throw new Zend_Service_Exception(sprintf(
                'Invalid response status code (HTTP/%s %s %s)',
                $response->getVersion(), $response->getStatus(), $response->getMessage()
            ));
        }
        
        return $response;
    }
    
    /**
     * Converts the response to a DOM object and checks it for errors.
     *
     * @param Zend_Http_Response $response 
     * @return DOMDocument
     */
    protected function _convertResponseAndCheckContent(Zend_Http_Response $response)
    {
        $dom = new DOMDocument();
        $dom->loadXML($response->getBody());
        $this->_checkErrors($dom);
        
        return $dom;
    }
    
    /**
     * Checks the response for errors
     *
     * @param DOMDocument $dom 
     * @return void
     */
    protected function _checkErrors(DOMDocument $dom)
    {
        
    }
    
    /**
     * Sets the application ID
     *
     * @param string $appId 
     * @return Noginn_Service_YahooBoss
     */
    public function setAppId($appId)
    {
        $this->_appId = $appId;
        return $this;
    }
    
    /**
     * Returns the application ID
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->_appId;
    }
    
    /**
     * Set the HTTP client used to perform API requests.
     *
     * @param Zend_Http_Client $httpClient 
     * @return void
     * @author Tom Graham
     */
    public function setHttpClient(Zend_Http_Client $httpClient)
    {
        $this->_httpClient;
    }
    
    /**
     * Returns the HTTP client used to perform API requests.
     *
     * @return Zend_Rest_Client
     */
    public function getHttpClient()
    {
        if ($this->_httpClient === null) {
            $this->_httpClient = new Zend_Http_Client(self::API_URI_BASE);
        }

        return $this->_httpClient;
    }
}