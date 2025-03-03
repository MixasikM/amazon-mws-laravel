<?php
use MixasikM\AmazonMws\AmazonReportRequest;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-12 at 13:17:14.
 */
class AmazonReportRequestTest extends PHPUnit_Framework_TestCase {

    /**
     * @var AmazonReportRequest
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        resetLog();
        $this->object = new AmazonReportRequest('testStore', true, null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    
    public function testSetReportType(){
        $this->assertFalse($this->object->setReportType(null)); //can't be nothing
        $this->assertFalse($this->object->setReportType(5)); //can't be an int
        $this->assertNull($this->object->setReportType('Type'));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('ReportType',$o);
        $this->assertEquals('Type',$o['ReportType']);
    }
    
    /**
    * @return array
    */
    public function timeProvider() {
        return array(
            array(null, null, false, false), //nothing given, so no change
            array(true, true, false, false), //not strings or numbers
            array('', '', false, false), //strings, but empty
            array('-1 min', null, true, false), //one set
            array(null, '-1 min', false, true), //other set
            array('-1 min', '-1 min', true, true), //both set
        );
    }
    
    /**
     * @dataProvider timeProvider
     */
    public function testSetTimeLimits($a, $b, $c, $d){
        $this->object->setTimeLimits($a,$b);
        $o = $this->object->getOptions();
        if ($c){
            $this->assertArrayHasKey('StartDate',$o);
            $this->assertStringMatchesFormat('%d-%d-%dT%d:%d:%d%i',$o['StartDate']);
        } else {
            $this->assertArrayNotHasKey('StartDate',$o);
        }
        
        if ($d){
            $this->assertArrayHasKey('EndDate',$o);
            $this->assertStringMatchesFormat('%d-%d-%dT%d:%d:%d%i',$o['EndDate']);
        } else {
            $this->assertArrayNotHasKey('EndDate',$o);
        }
    }
    
    public function testResetTimeLimit(){
        $this->object->setTimeLimits('-1 min','-1 min');
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('StartDate',$o);
        $this->assertArrayHasKey('EndDate',$o);
        
        $this->object->resetTimeLimits();
        $check = $this->object->getOptions();
        $this->assertArrayNotHasKey('StartDate',$check);
        $this->assertArrayNotHasKey('EndDate',$check);
    }
    
    public function testSetShowSalesChannel(){
        $this->assertFalse($this->object->setShowSalesChannel(null)); //can't be nothing
        $this->assertFalse($this->object->setShowSalesChannel(5)); //can't be an int
        $this->assertFalse($this->object->setShowSalesChannel('banana')); //can't be a random word
        $this->assertNull($this->object->setShowSalesChannel(false));
        $this->assertNull($this->object->setShowSalesChannel(true));
        $this->assertNull($this->object->setShowSalesChannel('false'));
        $this->assertNull($this->object->setShowSalesChannel('true'));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('ReportOptions=ShowSalesChannel',$o);
        $this->assertEquals('true',$o['ReportOptions=ShowSalesChannel']);
    }
    
    public function testSetMarketplaces(){
        $this->assertFalse($this->object->setMarketplaces(null)); //can't be nothing
        $this->assertFalse($this->object->setMarketplaces(5)); //can't be an int
        
        $list = array('One','Two','Three');
        $this->assertNull($this->object->setMarketplaces($list));
        
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('MarketplaceIdList.Id.1',$o);
        $this->assertEquals('One',$o['MarketplaceIdList.Id.1']);
        $this->assertArrayHasKey('MarketplaceIdList.Id.2',$o);
        $this->assertEquals('Two',$o['MarketplaceIdList.Id.2']);
        $this->assertArrayHasKey('MarketplaceIdList.Id.3',$o);
        $this->assertEquals('Three',$o['MarketplaceIdList.Id.3']);
        
        $this->assertNull($this->object->setMarketplaces('Four')); //will cause reset
        $o2 = $this->object->getOptions();
        $this->assertArrayHasKey('MarketplaceIdList.Id.1',$o2);
        $this->assertEquals('Four',$o2['MarketplaceIdList.Id.1']);
        $this->assertArrayNotHasKey('MarketplaceIdList.Id.2',$o2);
        $this->assertArrayNotHasKey('MarketplaceIdList.Id.3',$o2);
        
        $this->object->resetMarketplaces();
        $o3 = $this->object->getOptions();
        $this->assertArrayNotHasKey('MarketplaceIdList.Id.1',$o3);
    }
    
    public function testRequestReport(){
        resetLog();
        $this->object->setMock(true,'requestReport.xml');
        $this->assertFalse($this->object->requestReport());
        $this->object->setReportType('Type');
        
        $this->assertNull($this->object->requestReport());
        
        $o = $this->object->getOptions();
        $this->assertEquals('RequestReport',$o['Action']);
        
        $check = parseLog();
        $this->assertEquals('Single Mock File set: requestReport.xml',$check[1]);
        $this->assertEquals('Report Type must be set in order to request a report!',$check[2]);
        $this->assertEquals('Fetched Mock File: mock/requestReport.xml',$check[3]);
        
        return $this->object;
    }
    
    /**
     * @depends testRequestReport
     */
    public function testGetReportRequestId($o){
        $get = $o->getReportRequestId();
        $this->assertEquals('2291326454',$get);
        
        $this->assertFalse($this->object->getReportRequestId()); //not fetched yet for this object
    }
    
    /**
     * @depends testRequestReport
     */
    public function testGetReportType($o){
        $get = $o->getReportType();
        $this->assertEquals('_GET_MERCHANT_LISTINGS_DATA_',$get);
        
        $this->assertFalse($this->object->getReportType()); //not fetched yet for this object
    }
    
    /**
     * @depends testRequestReport
     */
    public function testGetStartDate($o){
        $get = $o->getStartDate();
        $this->assertEquals('2009-01-21T02:10:39+00:00',$get);
        
        $this->assertFalse($this->object->getStartDate()); //not fetched yet for this object
    }
    
    /**
     * @depends testRequestReport
     */
    public function testGetEndDate($o){
        $get = $o->getEndDate();
        $this->assertEquals('2009-02-13T02:10:39+00:00',$get);
        
        $this->assertFalse($this->object->getEndDate()); //not fetched yet for this object
    }
    
    /**
     * @depends testRequestReport
     */
    public function testGetIsScheduled($o){
        $get = $o->getIsScheduled();
        $this->assertEquals('false',$get);
        
        $this->assertFalse($this->object->getIsScheduled()); //not fetched yet for this object
    }
    
    /**
     * @depends testRequestReport
     */
    public function testGetSubmittedDate($o){
        $get = $o->getSubmittedDate();
        $this->assertEquals('2009-02-20T02:10:39+00:00',$get);
        
        $this->assertFalse($this->object->getSubmittedDate()); //not fetched yet for this object
    }
    
    /**
     * @depends testRequestReport
     */
    public function testGetStatus($o){
        $get = $o->getStatus();
        $this->assertEquals('_SUBMITTED_',$get);
        
        $this->assertFalse($this->object->getStatus()); //not fetched yet for this object
    }
    
    /**
     * @depends testRequestReport
     */
    public function testGetResponse($o){
        $x = array();
        $x['ReportRequestId'] = '2291326454';
        $x['ReportType'] = '_GET_MERCHANT_LISTINGS_DATA_';
        $x['StartDate'] = '2009-01-21T02:10:39+00:00';
        $x['EndDate'] = '2009-02-13T02:10:39+00:00';
        $x['Scheduled'] = 'false';
        $x['SubmittedDate'] = '2009-02-20T02:10:39+00:00';
        $x['ReportProcessingStatus'] = '_SUBMITTED_';
        
        $this->assertEquals($x,$o->getResponse());
        
        $this->assertFalse($this->object->getResponse()); //not fetched yet for this object
    }
    
}

require_once(__DIR__.'/../helperFunctions.php');