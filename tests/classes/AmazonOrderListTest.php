<?php
use MixasikM\AmazonMws\AmazonOrderList;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-12 at 13:17:14.
 */
class AmazonOrderListTest extends PHPUnit_Framework_TestCase {

    /**
     * @var AmazonOrderList
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        resetLog();
        $this->object = new AmazonOrderList('testStore', true, null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    
    public function testSetUseToken(){
        $this->assertNull($this->object->setUseToken());
        $this->assertNull($this->object->setUseToken(true));
        $this->assertNull($this->object->setUseToken(false));
        $this->assertFalse($this->object->setUseToken('wrong'));
    }
    
    public function testSetLimits(){
        $this->assertNull($this->object->setLimits('Modified'));
        $this->assertNull($this->object->setLimits('Created','-10 min','-2 min'));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('CreatedAfter',$o);
        $this->assertArrayHasKey('CreatedBefore',$o);
        $this->assertArrayNotHasKey('LastUpdatedAfter',$o);
        $this->assertArrayNotHasKey('LastUpdatedBefore',$o);
        
        $this->assertNull($this->object->setLimits('Modified','-5 min','-1 min'));
        $o2 = $this->object->getOptions();
        $this->assertArrayNotHasKey('CreatedAfter',$o2);
        $this->assertArrayNotHasKey('CreatedBefore',$o2);
        $this->assertArrayHasKey('LastUpdatedAfter',$o2);
        $this->assertArrayHasKey('LastUpdatedBefore',$o2);
        
        $this->assertFalse($this->object->setLimits('wrong'));
        $this->assertFalse($this->object->setLimits('Created',array(5)));
        $check = parseLog();
        $this->assertEquals('First parameter should be either "Created" or "Modified".',$check[1]);
        $this->assertEquals('Error: strtotime() expects parameter 1 to be string, array given',$check[2]);
    }
    
    public function testSetOrderStatusFilter(){
        $this->assertFalse($this->object->setOrderStatusFilter(null)); //can't be nothing
        $this->assertFalse($this->object->setOrderStatusFilter(5)); //can't be an int
        
        $list = array('One','Two','Three');
        $this->assertNull($this->object->setOrderStatusFilter($list));
        
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('OrderStatus.Status.1',$o);
        $this->assertEquals('One',$o['OrderStatus.Status.1']);
        $this->assertArrayHasKey('OrderStatus.Status.2',$o);
        $this->assertEquals('Two',$o['OrderStatus.Status.2']);
        $this->assertArrayHasKey('OrderStatus.Status.3',$o);
        $this->assertEquals('Three',$o['OrderStatus.Status.3']);
        
        $this->assertNull($this->object->setOrderStatusFilter('Four')); //will cause reset
        $o2 = $this->object->getOptions();
        $this->assertArrayHasKey('OrderStatus.Status.1',$o2);
        $this->assertEquals('Four',$o2['OrderStatus.Status.1']);
        $this->assertArrayNotHasKey('OrderStatus.Status.2',$o2);
        $this->assertArrayNotHasKey('OrderStatus.Status.3',$o2);
        
        $this->object->resetOrderStatusFilter();
        $o3 = $this->object->getOptions();
        $this->assertArrayNotHasKey('OrderStatus.Status.1',$o3);
    }
    
    public function testSetFulfillmentChannelFilter(){
        $this->assertNull($this->object->setFulfillmentChannelFilter('AFN'));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('FulfillmentChannel.Channel.1',$o);
        $this->assertEquals('AFN',$o['FulfillmentChannel.Channel.1']);
        
        $this->assertNull($this->object->setFulfillmentChannelFilter(null));
        $o2 = $this->object->getOptions();
        $this->assertArrayNotHasKey('FulfillmentChannel.Channel.1',$o2);
        
        $this->assertNull($this->object->setFulfillmentChannelFilter('MFN'));
        $o3 = $this->object->getOptions();
        $this->assertArrayHasKey('FulfillmentChannel.Channel.1',$o3);
        $this->assertEquals('MFN',$o3['FulfillmentChannel.Channel.1']);
        
        $this->assertFalse($this->object->setFulfillmentChannelFilter('wrong'));
    }
    
    public function testSetPaymentMethodFilter(){
        $this->assertFalse($this->object->setPaymentMethodFilter(null)); //can't be nothing
        $this->assertFalse($this->object->setPaymentMethodFilter(5)); //can't be an int
        
        $list = array('One','Two','Three');
        $this->assertNull($this->object->setPaymentMethodFilter($list));
        
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('PaymentMethod.1',$o);
        $this->assertEquals('One',$o['PaymentMethod.1']);
        $this->assertArrayHasKey('PaymentMethod.2',$o);
        $this->assertEquals('Two',$o['PaymentMethod.2']);
        $this->assertArrayHasKey('PaymentMethod.3',$o);
        $this->assertEquals('Three',$o['PaymentMethod.3']);
        
        $this->assertNull($this->object->setPaymentMethodFilter('Four')); //will cause reset
        $o2 = $this->object->getOptions();
        $this->assertArrayHasKey('PaymentMethod.1',$o2);
        $this->assertEquals('Four',$o2['PaymentMethod.1']);
        $this->assertArrayNotHasKey('PaymentMethod.2',$o2);
        $this->assertArrayNotHasKey('PaymentMethod.3',$o2);
        
        $this->object->resetPaymentMethodFilter();
        $o3 = $this->object->getOptions();
        $this->assertArrayNotHasKey('PaymentMethod.1',$o3);
    }
    
    public function testSetEmailFilter(){
        $this->object->setOrderStatusFilter('Status');
        $this->object->setPaymentMethodFilter('Payment');
        $this->object->setFulfillmentChannelFilter('AFN');
        $this->object->setLimits('Modified','-10 min','-2 min');
        $this->object->setSellerOrderIdFilter('123456');
        
        $this->assertNull($this->object->setEmailFilter('Email'));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('BuyerEmail',$o);
        $this->assertEquals('Email',$o['BuyerEmail']);
        $this->assertArrayNotHasKey('SellerOrderId',$o);
        $this->assertArrayNotHasKey('OrderStatus.Status.1',$o);
        $this->assertArrayNotHasKey('PaymentMethod.1',$o);
        $this->assertArrayNotHasKey('FulfillmentChannel.Channel.1',$o);
        $this->assertArrayNotHasKey('LastUpdatedAfter',$o);
        $this->assertArrayNotHasKey('LastUpdatedBefore',$o);
        
        $this->assertNull($this->object->setEmailFilter(null));
        $o2 = $this->object->getOptions();
        $this->assertArrayNotHasKey('BuyerEmail',$o2);
        
        $this->assertNull($this->object->setEmailFilter('Email2'));
        $o3 = $this->object->getOptions();
        $this->assertArrayHasKey('BuyerEmail',$o3);
        $this->assertEquals('Email2',$o3['BuyerEmail']);
        
        $this->assertFalse($this->object->setEmailFilter(array(5)));
    }
    
    public function testSetSellerOrderIdFilter(){
        $this->object->setOrderStatusFilter('Status');
        $this->object->setPaymentMethodFilter('Payment');
        $this->object->setFulfillmentChannelFilter('AFN');
        $this->object->setLimits('Modified','-10 min','-2 min');
        $this->object->setEmailFilter('Email');
        
        $this->assertNull($this->object->setSellerOrderIdFilter('123456'));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('SellerOrderId',$o);
        $this->assertEquals('123456',$o['SellerOrderId']);
        $this->assertArrayNotHasKey('BuyerEmail',$o);
        $this->assertArrayNotHasKey('OrderStatus.Status.1',$o);
        $this->assertArrayNotHasKey('PaymentMethod.1',$o);
        $this->assertArrayNotHasKey('FulfillmentChannel.Channel.1',$o);
        $this->assertArrayNotHasKey('LastUpdatedAfter',$o);
        $this->assertArrayNotHasKey('LastUpdatedBefore',$o);
        
        $this->assertNull($this->object->setSellerOrderIdFilter(null));
        $o2 = $this->object->getOptions();
        $this->assertArrayNotHasKey('SellerOrderId',$o2);
        
        $this->assertNull($this->object->setSellerOrderIdFilter('987654321'));
        $o3 = $this->object->getOptions();
        $this->assertArrayHasKey('SellerOrderId',$o3);
        $this->assertEquals('987654321',$o3['SellerOrderId']);
        
        $this->assertFalse($this->object->setSellerOrderIdFilter(array(5)));
    }
    
    public function testSetMaxResultsPerPage(){
        $this->assertFalse($this->object->setMaxResultsPerPage(null)); //can't be nothing
        $this->assertFalse($this->object->setMaxResultsPerPage(9.75)); //can't be decimal
        $this->assertFalse($this->object->setMaxResultsPerPage('75')); //can't be a string
        $this->assertFalse($this->object->setMaxResultsPerPage(array(5,7))); //not a valid value
        $this->assertFalse($this->object->setMaxResultsPerPage('banana')); //what are you even doing
        $this->assertNull($this->object->setMaxResultsPerPage(77));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('MaxResultsPerPage',$o);
        $this->assertEquals(77,$o['MaxResultsPerPage']);
        
    }
    
    public function testFetchOrders(){
        resetLog();
        $this->object->setMock(true,'fetchOrderList.xml'); //no token
        $this->assertNull($this->object->fetchOrders());
        
        $o = $this->object->getOptions();
        $this->assertEquals('ListOrders',$o['Action']);
        
        $check = parseLog();
        $this->assertEquals('Single Mock File set: fetchOrderList.xml',$check[1]);
        $this->assertEquals('Fetched Mock File: mock/fetchOrderList.xml',$check[2]);
        
        $this->assertFalse($this->object->hasToken());
        
        return $this->object;
    }
    
    public function testFetchOrdersToken1(){
        resetLog();
        $this->object->setMock(true,'fetchOrderListToken.xml'); //no token
        
        //without using token
        $this->assertNull($this->object->fetchOrders());
        $check = parseLog();
        $this->assertEquals('Single Mock File set: fetchOrderListToken.xml',$check[1]);
        $this->assertEquals('Fetched Mock File: mock/fetchOrderListToken.xml',$check[2]);
        $this->assertEquals('Mock Mode set to ON',$check[3]);
        $this->assertEquals('Mock files array set.',$check[4]);
        $this->assertEquals('Mock Mode set to ON',$check[5]);
        $this->assertEquals('Mock files array set.',$check[6]);
        
        $this->assertTrue($this->object->hasToken());
        $o = $this->object->getOptions();
        $this->assertEquals('ListOrders',$o['Action']);
        $r = $this->object->getList();
        $this->assertArrayHasKey(0,$r);
        $this->assertArrayHasKey(1,$r);
        $this->assertInternalType('object',$r[0]);
        $this->assertInternalType('object',$r[1]);
        $this->assertEquals(2,count($r));
        $this->assertArrayNotHasKey(2,$r);
    }
    
    public function testFetchOrdersToken2(){
        resetLog();
        $this->object->setMock(true,array('fetchOrderListToken.xml','fetchOrderListToken2.xml'));
        
        //with using token
        $this->object->setUseToken();
        $this->assertNull($this->object->fetchOrders());
        $check = parseLog();
        $this->assertEquals('Mock files array set.',$check[1]);
        $this->assertEquals('Fetched Mock File: mock/fetchOrderListToken.xml',$check[2]);
        $this->assertEquals('Mock Mode set to ON',$check[3]);
        $this->assertEquals('Mock files array set.',$check[4]);
        $this->assertEquals('Mock Mode set to ON',$check[5]);
        $this->assertEquals('Mock files array set.',$check[6]);
        $this->assertEquals('Recursively fetching more orders',$check[7]);
        $this->assertEquals('Fetched Mock File: mock/fetchOrderListToken2.xml',$check[8]);
        $this->assertEquals('Mock Mode set to ON',$check[9]);
        $this->assertEquals('Mock files array set.',$check[10]);
        $this->assertFalse($this->object->hasToken());
        $o = $this->object->getOptions();
        $this->assertEquals('ListOrdersByNextToken',$o['Action']);
        $this->assertArrayNotHasKey('CreatedAfter',$o);
        $r = $this->object->getList();
        $this->assertArrayHasKey(0,$r);
        $this->assertArrayHasKey(1,$r);
        $this->assertArrayHasKey(2,$r);
        $this->assertInternalType('object',$r[0]);
        $this->assertInternalType('object',$r[1]);
        $this->assertInternalType('object',$r[2]);
        $this->assertEquals(3,count($r));
        $this->assertNotEquals($r[0],$r[1]);
    }
    
    public function testFetchItems(){
        $this->object->setMock(true,array('fetchOrderList.xml','fetchOrderItems.xml'));
        $this->object->fetchOrders();
        resetLog();
        $get = $this->object->fetchItems();
        $this->assertInternalType('array',$get);
        $this->assertEquals(3,count($get));
        $this->assertInternalType('object',$get[0]);
        $this->assertInternalType('object',$get[1]);
        $this->assertInternalType('object',$get[2]);
        
        $getOne = $this->object->fetchItems('string', 0); //$token will be set to false
        $this->assertInternalType('object',$getOne);
        
        $o = new AmazonOrderList('testStore', true, null);
        $this->assertFalse($o->fetchItems()); //not fetched yet for this object
    }
    /**
     * @depends testFetchOrders
     */
    public function testGetList($o){
        $get = $o->getList();
        $this->assertInternalType('array',$get);
        $this->assertEquals(3,count($get));
        $this->assertInternalType('object',$get[0]);
        
        $this->assertFalse($this->object->getList()); //not fetched yet for this object
    }
    
}

require_once(__DIR__.'/../helperFunctions.php');