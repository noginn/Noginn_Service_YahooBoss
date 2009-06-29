<?php

/**
 * Test helper
 */
require_once dirname(__FILE__) . '/../../../TestHelper.php';

class Noginn_Service_YahooBoss_OfflineTest extends PHPUnit_Framework_TestCase
{
    /**
     * Reference to Yahoo BOSS service consumer object
     *
     * @var Noginn_Service_YahooBoss
     */
    protected $_boss;

    /**
     * Path to test data files
     *
     * @var string
     */
    protected $_filesPath;

    /**
     * HTTP client adapter for testing
     *
     * @var Zend_Http_Client_Adapter_Test
     */
    protected $_httpClientAdapterTest;

    /**
     * Sets up this test case
     *
     * @return void
     */
    public function setUp()
    {
        $this->_boss = new Noginn_Service_YahooBoss(constant('TESTS_NOGINN_SERVICE_YAHOOBOSS_ONLINE_APPID'));
        $this->_filesPath = dirname(__FILE__) . '/_files';
        $this->_httpClientAdapterTest = new Zend_Http_Client_Adapter_Test();
    }
    
    public function testWebSearchBasic()
    {
        $this->_boss->getHttpClient()->setAdapter($this->_httpClientAdapterTest);
        $this->_httpClientAdapterTest->setResponse($this->_loadResponse(__FUNCTION__));
        
        $options = array(
            'start' => 0,
            'count' => 10,
        );
        $resultSet = $this->_boss->webSearch('zend framework', $options);
        
        // Check the meta-data
        $this->assertEquals(10, $resultSet->getCount());
        $this->assertEquals(0, $resultSet->getStart());
        $this->assertEquals(417996, $resultSet->getTotalHits());
        $this->assertEquals(10500000, $resultSet->getDeepHits());
        
        $this->assertEquals(0, $resultSet->key());
        
        // Attempt to seek below the lower bound
        try {
            $resultSet->seek(-1);
            $this->fail('Expected OutOfBoundsException not thrown');
        } catch (OutOfBoundsException $e) {
            $this->assertContains('Illegal index', $e->getMessage());
        }
        
        $resultSet->seek(9);
        
        // Attempt to seek above the upper bound
        try {
            $resultSet->seek(10);
            $this->fail('Expected OutOfBoundsException not thrown');
        } catch (OutOfBoundsException $e) {
            $this->assertContains('Illegal index', $e->getMessage());
        }
        
        $resultSet->rewind();
        $this->assertTrue($resultSet->valid());
        
        // Check the results are available
        $result = $resultSet->current();
        $this->assertEquals('Data-centric Adobe Flash Builder development with the <b>Zend</b> <b>Framework</b> <b>...</b> Jeroen Keppens on: Creating a modular application with <b>Zend</b> <b>Framework</b> <b>...</b>', $result->getAbstract());
        $this->assertEquals('<b>Zend</b> <b>Framework</b>', $result->getTitle());
        $this->assertEquals('http://framework.zend.com/', $result->getUrl());
        $this->assertEquals('http://lrd.yahooapis.com/_ylc=X3oDMTQ4dGRvaGxvBF9TAzIwMjMxNTI3MDIEYXBwaWQDQkVEVmZRWElrWTBKUExtS002QkFYd2ZnRnQxLkVFYy0EY2xpZW50A2Jvc3MEc2VydmljZQNCT1NTBHNsawN0aXRsZQRzcmNwdmlkA0RIX2F0V0tJY3JvQXE3cEdPQlZ5R0FFWVZnNFdBMHBGUmlvQUNRU0M-/SIG=10vtopo9u/**http%3A//framework.zend.com/', $result->getClickUrl());
        $this->assertEquals('<b>framework.zend.com</b>', $result->getDisplayUrl());
        $this->assertEquals('14409', $result->getSize());
        $this->assertEquals('2009/06/18', $result->getDate());
    }
    
    public function testImageSearchBasic()
    {
        $this->_boss->getHttpClient()->setAdapter($this->_httpClientAdapterTest);
        $this->_httpClientAdapterTest->setResponse($this->_loadResponse(__FUNCTION__));
        
        $options = array(
            'start' => 0,
            'count' => 10,
        );
        $resultSet = $this->_boss->imageSearch('tom graham', $options);
        
        // Check the meta-data
        $this->assertEquals(10, $resultSet->getCount());
        $this->assertEquals(0, $resultSet->getStart());
        $this->assertEquals(21971, $resultSet->getTotalHits());
        $this->assertEquals(21971, $resultSet->getDeepHits());
        
        $this->assertEquals(0, $resultSet->key());
        
        // Attempt to seek below the lower bound
        try {
            $resultSet->seek(-1);
            $this->fail('Expected OutOfBoundsException not thrown');
        } catch (OutOfBoundsException $e) {
            $this->assertContains('Illegal index', $e->getMessage());
        }
        
        $resultSet->seek(9);
        
        // Attempt to seek above the upper bound
        try {
            $resultSet->seek(10);
            $this->fail('Expected OutOfBoundsException not thrown');
        } catch (OutOfBoundsException $e) {
            $this->assertContains('Illegal index', $e->getMessage());
        }
        
        $resultSet->rewind();
        $this->assertTrue($resultSet->valid());
        
        // Check the results are available
        $result = $resultSet->current();
        $this->assertEquals('with other guests of honour commemorated the official opening of the Tom Graham Arena Complex and the new Richmond Hill Sports Hall of Fame as well as the 50th anniversary of the R H A A', $result->getAbstract());
        $this->assertEquals('gallery tom graham open a jpg', $result->getTitle());
        $this->assertEquals('gallery tom graham open a jpg', $result->getFilename());
        $this->assertEquals('http://www.richmondhill.ca/images/subpage/gallery_tom_graham_open_a.jpg', $result->getUrl());
        $this->assertEquals('http://lrd.yahooapis.com/_ylc=X3oDMTQ4N3RuYmxkBF9TAzIwMjMxNTI3MDIEYXBwaWQDQkVEVmZRWElrWTBKUExtS002QkFYd2ZnRnQxLkVFYy0EY2xpZW50A2Jvc3MEc2VydmljZQNCT1NTBHNsawN0aXRsZQRzcmNwdmlkA1RfNjBWR0tJY3JwVG9Ba2t0d2lXamdKRFZnNFdBMHBGVHpJQUEzRkg-/SIG=12ck6ci5r/**http%3A//www.richmondhill.ca/images/subpage/gallery_tom_graham_open_a.jpg', $result->getClickUrl());
        $this->assertEquals('jpeg', $result->getFormat());
        $this->assertEquals(324, $result->getHeight());
        $this->assertEquals(432, $result->getWidth());
        $this->assertEquals('2005/06/08', $result->getDate());
        $this->assertEquals('image/jpeg', $result->getMimeType());
        $this->assertEquals('http://lrd.yahooapis.com/_ylc=X3oDMTQ4N3RuYmxkBF9TAzIwMjMxNTI3MDIEYXBwaWQDQkVEVmZRWElrWTBKUExtS002QkFYd2ZnRnQxLkVFYy0EY2xpZW50A2Jvc3MEc2VydmljZQNCT1NTBHNsawN0aXRsZQRzcmNwdmlkA1RfNjBWR0tJY3JwVG9Ba2t0d2lXamdKRFZnNFdBMHBGVHpJQUEzRkg-/SIG=12is8v9or/**http%3A//www.richmondhill.ca/subpage.asp%3Fpageid=photo_gallery_tom_graham_open', $result->getRefererClickUrl());
        $this->assertEquals('http://thm-a01.yimg.com/image/7d165e8ec76b951e', $result->getThumbnailUrl());
        $this->assertEquals(105, $result->getThumbnailHeight());
        $this->assertEquals(140, $result->getThumbnailWidth());
    }
    
    public function testNewsSearchBasic()
    {
        
    }
    
    public function testSpellingSuggestion()
    {
        $this->_boss->getHttpClient()->setAdapter($this->_httpClientAdapterTest);
        $this->_httpClientAdapterTest->setResponse($this->_loadResponse(__FUNCTION__));
        
        $this->assertEquals('spelling', $this->_boss->getSpellingSuggestion('spellign'));
    }

    /**
     * Utility method for returning a string HTTP response, which is loaded from a file
     *
     * @param  string $name
     * @return string
     */
    protected function _loadResponse($name)
    {
        return file_get_contents($this->_filesPath . '/' . $name . '.response');
    }
}