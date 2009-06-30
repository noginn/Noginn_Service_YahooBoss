<?php

/**
 * Web search result set class
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage YahooBoss
 * @copyright Copyright (c) 2009 Tom Graham <me@noginn.com>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Noginn_Service_YahooBoss_WebResultSet extends Noginn_Service_YahooBoss_ResultSet
{
    /**
     * The result class
     *
     * @var string
     */
    protected $_resultClass = 'Noginn_Service_YahooBoss_WebResult';
    
    /**
     * The results element name in the XML response
     *
     * @var string
     */
    protected $_resultSetElement = 'resultset_web';
}
