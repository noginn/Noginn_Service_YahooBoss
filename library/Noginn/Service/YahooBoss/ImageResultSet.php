<?php

/**
 * Image search result set class
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage YahooBoss
 * @author Tom Graham
 */
class Noginn_Service_YahooBoss_ImageResultSet extends Noginn_Service_YahooBoss_ResultSet
{
    /**
     * The result class
     *
     * @var string
     */
    protected $_resultClass = 'Noginn_Service_YahooBoss_ImageResult';
    
    /**
     * The results element name in the XML response
     *
     * @var string
     */
    protected $_resultSetElement = 'resultset_images';
}
