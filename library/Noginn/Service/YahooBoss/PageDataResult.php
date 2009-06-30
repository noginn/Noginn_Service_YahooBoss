<?php

/**
 * Page data result class
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage YahooBoss
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Noginn_Service_YahooBoss_PageDataResult
{
    /**
     * The abstract
     *
     * @var string
     */
    protected $_abstract;
    
    /**
     * The title
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
     * The click URL
     *
     * @var string
     */
    protected $_clickUrl;
    
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
        
        $clickUrl = $xpath->query('./boss:clickurl/text()', $dom);
        if ($clickUrl->length == 1) {
            $this->_clickUrl = (string) $clickUrl->item(0)->data;
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
     * Returns the click URL
     *
     * @return string
     */
    public function getClickUrl()
    {
        return $this->_clickUrl;
    }
}
