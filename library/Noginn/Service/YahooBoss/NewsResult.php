<?php

/**
 * News search result class
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage YahooBoss
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Noginn_Service_YahooBoss_NewsResult
{
    /**
     * The abstract
     *
     * @var string
     */
    protected $_abstract;
    
    /**
     * The page title
     *
     * @var string
     */
    protected $_title;
    
    /**
     * The URL
     *
     * @var string
     */
    protected $_url;
    
    /**
     * The source
     *
     * @var string
     */
    protected $_source;
    
    /**
     * The source URL
     *
     * @var string
     */
    protected $_sourceUrl;
    
    /**
     * The click URL
     *
     * @var string
     */
    protected $_clickUrl;
    
    /**
     * The date
     *
     * @var string
     */
    protected $_date;
    
    /**
     * The time
     *
     * @var string
     */
    protected $_time;
    
    /**
     * The language
     *
     * @var string
     */
    protected $_language;
    
    /**
     * Constructor.
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
        
        $source = $xpath->query('./boss:source/text()', $dom);
        if ($source->length == 1) {
            $this->_source = (string) $source->item(0)->data;
        }
        
        $sourceUrl = $xpath->query('./boss:sourceurl/text()', $dom);
        if ($sourceUrl->length == 1) {
            $this->_sourceUrl = (string) $sourceUrl->item(0)->data;
        }
        
        $clickUrl = $xpath->query('./boss:clickurl/text()', $dom);
        if ($clickUrl->length == 1) {
            $this->_clickUrl = (string) $clickUrl->item(0)->data;
        }
        
        $date = $xpath->query('./boss:date/text()', $dom);
        if ($date->length == 1) {
            $this->_date = (string) $date->item(0)->data;
        }
        
        $time = $xpath->query('./boss:time/text()', $dom);
        if ($time->length == 1) {
            $this->_time = (string) $time->item(0)->data;
        }
        
        $language = $xpath->query('./boss:language/text()', $dom);
        if ($language->length == 1) {
            $this->_language = (string) $language->item(0)->data;
        }
    }
    
    /**
     * Returns the abstract
     *
     * @return string
     */
    public function getAbstract()
    {
        return $this->_abstract;
    }
    
    /**
     * Returns the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }
    
    /**
     * Returns the URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->_url;
    }
    
    /**
     * Returns the source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->_source;
    }
    
    /**
     * Returns the source URL
     *
     * @return string
     */
    public function getSourceUrl()
    {
        return $this->_sourceUrl;
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
     * Returns the date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->_date;
    }
    
    /**
     * Returns the time
     *
     * @return string
     */
    public function getTime()
    {
        return $this->_time;
    }
    
    /**
     * Returns the language
     *
     * @return string
     */
    public function getLanguage()
    {
        return $this->_language;
    }
}
