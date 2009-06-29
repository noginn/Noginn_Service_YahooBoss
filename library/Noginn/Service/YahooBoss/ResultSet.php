<?php

/**
 * Abstract search result set base class
 *
 * @category Noginn
 * @package Noginn_Service
 * @subpackage YahooBoss
 * @author Tom Graham
 */
class Noginn_Service_YahooBoss_ResultSet implements SeekableIterator, Countable
{
    /**
     * The number of results in the result set
     *
     * @var int
     */
    protected $_count = 0;
    
    /**
     * The offset of the search
     *
     * @var int
     */
    protected $_start = 0;
    
    /**
     * The total number of hits in the results
     *
     * @var int
     */
    protected $_totalHits = 0;
    
    /**
     * The number of deep hits in the results
     *
     * @var int
     */
    protected $_deepHits = 0;
    
    /**
     * The results
     *
     * @var DOMNodeList
     */
    protected $_results;
    
    /**
     * The current index of the iterator
     *
     * @var int
     */
    protected $_currentIndex = 0;
    
    /**
     * The result class
     *
     * @var string
     */
    protected $_resultClass;
    
    /**
     * The results element name in the XML response
     *
     * @var string
     */
    protected $_resultSetElement;
    
    /**
     * Constructor
     *
     * @param DOMDocument $dom 
     * @param Noginn_Service_YahooBoss $boss 
     */
    public function __construct(DOMDocument $dom)
    {
        $xpath = new DOMXPath($dom);
        $xpath->registerNamespace('boss', Noginn_Service_YahooBoss::API_RESPONSE_NAMESPACE);
        
        $node = $xpath->query('//boss:' . $this->_resultSetElement);
        if ($node->length == 1) {
            $resultSet = $node->item(0);
            
            // Get the attributes from the resultset element
            $this->_count = (int) $resultSet->getAttribute('count');
            $this->_start = (int) $resultSet->getAttribute('start');
            $this->_totalHits = (string) $resultSet->getAttribute('totalhits');
            $this->_deepHits = (string) $resultSet->getAttribute('deephits');
            
            // Fetch all of the results
            $this->_results = $xpath->query('//boss:result');
        }
    }
    
    /**
     * Returns the number of results in the result set
     *
     * @return int
     */
    public function getCount()
    {
        return $this->_count;
    }
    
    /**
     * Returns the offset of the search
     *
     * @return int
     */
    public function getStart()
    {
        return $this->_start;
    }
    
    /**
     * Returns the total number of hits for the search
     *
     * @return int
     */
    public function getTotalHits()
    {
        return $this->_totalHits;
    }
    
    /**
     * Returns the number of deep hits for the search
     *
     * @return void
     * @author Tom Graham
     */
    public function getDeepHits()
    {
        return $this->_deepHits;
    }
    
    /**
     * Implements Countable::count()
     *
     * @return int
     */
    public function count()
    {
        return $this->getCount();
    }
    
    /**
     * Implements SeekableIterator::current().
     *
     * @return  void
     * @throws  Zend_Service_Exception
     * @abstract
     */
    public function current()
    {
        if ($this->_resultClass === null) {
            throw new Zend_Service_Exception('Result class not provided');
        }
        
        $class = $this->_resultClass;
        return new $class($this->_results->item($this->_currentIndex));
    }

    /**
     * Implements SeekableIterator::key().
     *
     * @return  int
     */
    public function key()
    {
        return $this->_currentIndex;
    }

    /**
     * Implements SeekableIterator::next().
     *
     * @return  void
     */
    public function next()
    {
        $this->_currentIndex += 1;
    }

    /**
     * Implements SeekableIterator::rewind().
     *
     * @return  bool
     */
    public function rewind()
    {
        $this->_currentIndex = 0;
        return true;
    }

    /**
     * Implement SeekableIterator::seek().
     *
     * @param   int $index
     * @return  void
     * @throws  OutOfBoundsException
     */
    public function seek($index)
    {
        $index = (int) $index;
        if ($index >= 0 && $index < $this->count()) {
            $this->_currentIndex = $index;
        } else {
            throw new OutOfBoundsException("Illegal index '$index'");
        }
    }

    /**
     * Implement SeekableIterator::valid().
     *
     * @return boolean
     */
    public function valid()
    {
        return $this->_currentIndex < $this->count();
    }
}
