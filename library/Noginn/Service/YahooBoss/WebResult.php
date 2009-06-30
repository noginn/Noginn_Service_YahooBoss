<?php

/**
 * Web search result class
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage YahooBoss
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Noginn_Service_YahooBoss_WebResult
{
    /**
     * An abstract of a web document
     *
     * @var string
     */
    protected $_abstract;
    
    /**
     * The title of the web page
     *
     * @var string
     */
    protected $_title;
    
    /**
     * The URL of the web page
     *
     * @var string
     */
    protected $_url;
    
    /**
     * The click URL of the web page
     *
     * @var string
     */
    protected $_clickUrl;
    
    /**
     * The display URL of the web page.
     * Search terms will be highlighted using <b> tags unless the style option
     * is set to "raw".
     *
     * @var string
     */
    protected $_displayUrl;
    
    /**
     * The size of the web page in bytes
     *
     * @var string
     */
    protected $_size;
    
    /**
     * The date the web page was last changed
     *
     * @var string
     */
    protected $_date;
    
    /**
     * The key terms for a web page. 
     * Only available when the "keyterms" view is requested.
     *
     * @var array
     */
    protected $_keyTerms = array();
    
    /**
     * The language of the web page. 
     * Only available when the "language" view is requested.
     *
     * @var string
     */
    protected $_language;
    
    /**
     * The number of users who saved the web page in delicious bookmarks.
     *
     * @var int
     */
    protected $_deliciousSaves = 0;
    
    /**
     * Constructor.
     *
     * Processes the result node and fills the object with available information.
     *
     * @param DOMElement $dom 
     */
    public function __construct(DOMElement $dom)
    {
        $xpath = new DOMXPath($dom->ownerDocument);
        $xpath->registerNamespace('boss', Noginn_Service_YahooBoss::API_RESPONSE_NAMESPACE);
        
        $abstract = $xpath->query('./boss:abstract/text()', $dom);
        if ($abstract->length == 1) {
            $this->_abstract = (string) $abstract->item(0)->data;
        }
        
        $title = $xpath->query('./boss:title/text()', $dom);
        if ($title->length == 1) {
            $this->_title = (string) $title->item(0)->data;
        }
        
        $url = $xpath->query('./boss:url/text()', $dom);
        if ($url->length == 1) {
            $this->_url = (string) $url->item(0)->data;
        }
        
        $clickUrl = $xpath->query('./boss:clickurl/text()', $dom);
        if ($clickUrl->length == 1) {
            $this->_clickUrl = (string) $clickUrl->item(0)->data;
        }
        
        $displayUrl = $xpath->query('./boss:dispurl/text()', $dom);
        if ($displayUrl->length == 1) {
            $this->_displayUrl = (string) $displayUrl->item(0)->data;
        }
        
        $size = $xpath->query('./boss:size/text()', $dom);
        if ($size->length == 1) {
            $this->_size = (int) $size->item(0)->data;
        }
        
        $date = $xpath->query('./boss:date/text()', $dom);
        if ($date->length == 1) {
            $this->_date = (string) $date->item(0)->data;
        }
        
        $keyTerms = $xpath->query('./boss:keyterms/boss:terms/boss:term/text()', $dom);
        foreach ($keyTerms as $term) {
            $this->_keyTerms[] = (string) $term->data;
        }
        
        $language = $xpath->query('./boss:language/text()', $dom);
        if ($language->length == 1) {
            $this->_language = (string) $language->item(0)->data;
        }
        
        $deliciousSaves = $xpath->query('./boss:delicious_saves/text()', $dom);
        if ($deliciousSaves->length == 1) {
            $this->_deliciousSaves = (int) $deliciousSaves->item(0)->data;
        }
    }
    
    /**
     * Returns an abstract of the web page content
     *
     * @return string
     */
    public function getAbstract()
    {
        return $this->_abstract;
    }
    
    /**
     * Returns the web page title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }
    
    /**
     * Returns the URL of the web page
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }
    
    /**
     * Returns the click URL
     *
     * @return string
     */
    public function getClickUrl()
    {
        return $this->_clickUrl;
    }
    
    /**
     * Returns the display URL
     *
     * @return string
     */
    public function getDisplayUrl()
    {
        return $this->_displayUrl;
    }
    
    /**
     * Returns the size of the web page in bytes
     *
     * @return int
     */
    public function getSize()
    {
        return $this->_size;
    }
    
    /**
     * Returns the date the web page was last changed
     *
     * @return string
     */
    public function getDate()
    {
        return $this->_date;
    }
    
    /**
     * Returns the key terms for the web page content
     *
     * @return array
     */
    public function getKeyTerms()
    {
        return $this->_keyTerms;
    }
    
    /**
     * Returns the language of the web page
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->_language;
    }
    
    /**
     * Returns the number of users who saved the web page in delicious bookmarks
     *
     * @return int
     */
    public function getDeliciousSaves()
    {
        return $this->_deliciousSaves;
    }
}
