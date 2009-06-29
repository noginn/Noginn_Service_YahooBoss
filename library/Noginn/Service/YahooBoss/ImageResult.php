<?php

/**
 * Image search result class
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage YahooBoss
 * @author Tom Graham
 */
class Noginn_Service_YahooBoss_ImageResult
{
    /**
     * An abstract from the web page containing the image
     *
     * @var string
     */
    protected $_abstract;
    
    /**
     * The title of the image
     *
     * @var string
     */
    protected $_title;
    
    /**
     * The image filename
     *
     * @var string
     */
    protected $_filename;
    
    /**
     * The image URL
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
     * The size of the image in bytes
     *
     * @var string
     */
    protected $_size;
    
    /**
     * The format of the image
     *
     * @var string
     */
    protected $_format;
    
    /**
     * The height of the image
     *
     * @var int
     */
    protected $_height;
    
    /**
     * The width of the image
     *
     * @var int
     */
    protected $_width;
    
    /**
     * The date the image was indexed/changed
     *
     * @var string
     */
    protected $_date;
    
    /**
     * The mime-type of the image
     *
     * @var string
     */
    protected $_mimeType;
    
    /**
     * The referer URL
     *
     * @var string
     */
    protected $_refererUrl;
    
    /**
     * The referer website click URL
     *
     * @var string
     */
    protected $_refererClickUrl;
    
    /**
     * The thumbnail URL
     *
     * @var string
     */
    protected $_thumbnailUrl;
    
    /**
     * The thumbnail height
     *
     * @var int
     */
    protected $_thumbnailHeight;
    
    /**
     * The thumbnail width
     *
     * @var int
     */
    protected $_thumbnailWidth;
    
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
        
        $filename = $xpath->query('./boss:filename/text()', $dom);
        if ($filename->length == 1) {
            $this->_filename = (string) $filename->item(0)->data;
        }
        
        $url = $xpath->query('./boss:url/text()', $dom);
        if ($url->length == 1) {
            $this->_url = (string) $url->item(0)->data;
        }
        
        $clickUrl = $xpath->query('./boss:clickurl/text()', $dom);
        if ($clickUrl->length == 1) {
            $this->_clickUrl = (string) $clickUrl->item(0)->data;
        }
        
        $size = $xpath->query('./boss:size/text()', $dom);
        if ($size->length == 1) {
            $this->_size = (string) $size->item(0)->data;
        }
        
        $format = $xpath->query('./boss:format/text()', $dom);
        if ($format->length == 1) {
            $this->_format = (string) $format->item(0)->data;
        }
        
        $height = $xpath->query('./boss:height/text()', $dom);
        if ($height->length == 1) {
            $this->_height = (int) $height->item(0)->data;
        }
        
        $width = $xpath->query('./boss:width/text()', $dom);
        if ($width->length == 1) {
            $this->_width = (int) $width->item(0)->data;
        }
        
        $date = $xpath->query('./boss:date/text()', $dom);
        if ($date->length == 1) {
            $this->_date = (string) $date->item(0)->data;
        }
        
        $mimeType = $xpath->query('./boss:mimetype/text()', $dom);
        if ($mimeType->length == 1) {
            $this->_mimeType = (string) $mimeType->item(0)->data;
        }
        
        $refererClickUrl = $xpath->query('./boss:refererclickurl/text()', $dom);
        if ($refererClickUrl->length == 1) {
            $this->_refererClickUrl = (string) $refererClickUrl->item(0)->data;
        }
        
        $refererUrl = $xpath->query('./boss:refererurl/text()', $dom);
        if ($refererUrl->length == 1) {
            $this->_refererUrl = (string) $refererUrl->item(0)->data;
        }
        
        $thumbnailUrl = $xpath->query('./boss:thumbnail_url/text()', $dom);
        if ($thumbnailUrl->length == 1) {
            $this->_thumbnailUrl = (string) $thumbnailUrl->item(0)->data;
        }
        
        $thumbnailHeight = $xpath->query('./boss:thumbnail_height/text()', $dom);
        if ($thumbnailHeight->length == 1) {
            $this->_thumbnailHeight = (int) $thumbnailHeight->item(0)->data;
        }
        
        $thumbnailWidth = $xpath->query('./boss:thumbnail_width/text()', $dom);
        if ($thumbnailWidth->length == 1) {
            $this->_thumbnailWidth = (int) $thumbnailWidth->item(0)->data;
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
     * Returns the filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->_filename;
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
    
    /**
     * Returns the size of the image in bytes
     *
     * @return int
     */
    public function getSize()
    {
        return $this->_size;
    }
    
    /**
     * Returns the image format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->_format;
    }
    
    /**
     * Returns the height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->_height;
    }
    
    /**
     * Returns the width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->_width;
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
     * Returns the mime-type of the image
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->_mimeType;
    }
    
    /**
     * Returns the referer URL
     *
     * @return string
     */
    public function getRefererUrl()
    {
        return $this->_refererUrl;
    }
    
    /**
     * Returns the click URL of the referer page
     *
     * @return string
     */
    public function getRefererClickUrl()
    {
        return $this->_refererClickUrl;
    }
    
    /**
     * Returns the thumbnail URL
     *
     * @return string
     */
    public function getThumbnailUrl()
    {
        return $this->_thumbnailUrl;
    }
    
    /**
     * Returns the thumbnail height
     *
     * @return int
     */
    public function getThumbnailHeight()
    {
        return $this->_thumbnailHeight;
    }
    
    /**
     * Returns the thumbnail width
     *
     * @return int
     */
    public function getThumbnailWidth()
    {
        return $this->_thumbnailWidth;
    }
}
