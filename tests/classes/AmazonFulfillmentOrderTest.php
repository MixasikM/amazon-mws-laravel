<?php
use MixasikM\AmazonMws\AmazonFulfillmentOrder;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-12 at 13:17:14.
 */
class AmazonFulfillmentOrderTest extends PHPUnit_Framework_TestCase {

    /**
     * @var AmazonFulfillmentOrder
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        resetLog();
        $this->object = new AmazonFulfillmentOrder('testStore', null, true, null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    
    public function testSetUp(){
        $obj = new AmazonFulfillmentOrder('testStore', '77');
        
        $o = $obj->getOptions();
        $this->assertArrayHasKey('SellerFulfillmentOrderId',$o);
        $this->assertEquals('77', $o['SellerFulfillmentOrderId']);
    }
    
    public function testSetOrderId(){
        $ok = $this->object->setOrderId('777');
        $this->assertNull($ok);
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('SellerFulfillmentOrderId',$o);
        $this->assertEquals('777',$o['SellerFulfillmentOrderId']);
        $this->assertFalse($this->object->setOrderId(777)); //won't work for ints
        $this->assertFalse($this->object->setOrderId(null)); //won't work for other things
    }
    
    public function testFetchOrder(){
        resetLog();
        $this->object->setMock(true,'fetchFulfillmentOrder.xml');
        
        $this->assertFalse($this->object->fetchOrder()); //no order ID set yet
        
        $this->object->setOrderId('777');
        $ok = $this->object->fetchOrder(); //now it is good
        $this->assertNull($ok);
        
        $o = $this->object->getOptions();
        $this->assertEquals('GetFulfillmentOrder',$o['Action']);
        
        $check = parseLog();
        $this->assertEquals('Single Mock File set: fetchFulfillmentOrder.xml',$check[1]);
        $this->assertEquals('Fulfillment Order ID must be set in order to fetch it!',$check[2]);
        $this->assertEquals('Fetched Mock File: mock/fetchFulfillmentOrder.xml',$check[3]);
        
        $get = $this->object->getOrder();
        $this->assertInternalType('array',$get);
        
        return $this->object;
        
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetOrder($o){
        $get = $o->getOrder();
        $this->assertInternalType('array',$get);
        $this->assertArrayHasKey('Details',$get);
        $this->assertArrayHasKey('Items',$get);
        $this->assertArrayHasKey('Shipments',$get);
        $this->assertInternalType('array',$get['Details']);
        $this->assertInternalType('array',$get['Items']);
        $this->assertInternalType('array',$get['Shipments']);
        
        $x = array();
        $xd = array();
        $xd['SellerFulfillmentOrderId'] = 'extern_id_1154539615776';
        $xd['DisplayableOrderId'] = 'test_displayable_id';
        $xd['DisplayableOrderDateTime'] = '2006-08-02T17:26:56Z';
        $xd['DisplayableOrderComment'] = 'Sample comment.';
        $xd['ShippingSpeedCategory'] = 'Standard';
        $xd['DestinationAddress']['Name'] = 'Greg Miller';
        $xd['DestinationAddress']['Line1'] = '123 Some St.';
        $xd['DestinationAddress']['Line2'] = 'Apt. 321';
        $xd['DestinationAddress']['Line3'] = 'Suite 16';
        $xd['DestinationAddress']['DistrictOrCounty'] = 'Oldsborough';
        $xd['DestinationAddress']['City'] = 'Seattle';
        $xd['DestinationAddress']['StateOrProvinceCode'] = 'WA';
        $xd['DestinationAddress']['CountryCode'] = 'US';
        $xd['DestinationAddress']['PostalCode'] = '98101';
        $xd['DestinationAddress']['PhoneNumber'] = '206-555-1928';
        $xd['FulfillmentPolicy'] = 'FillOrKill';
        $xd['FulfillmentMethod'] = 'Consumer';
        $xd['ReceivedDateTime'] = '2006-08-02T17:26:56Z';
        $xd['FulfillmentOrderStatus'] = 'PROCESSING';
        $xd['StatusUpdatedDateTime'] = '2006-09-28T23:48:48Z';
        $xd['NotificationEmailList'][0] = 'o8c2EXAMPLsfr7o@marketplace.amazon.com';
        
        $x['Details'] = $xd;
        
        $xi = array();
        $xi[0]['SellerSKU'] = 'ssof_dev_drt_afn_item';
        $xi[1]['SellerSKU'] = 'ssof_dev_drt_keep_this_afn_always';
        $xi[0]['SellerFulfillmentOrderItemId'] = 'test_merchant_order_item_id_2';
        $xi[1]['SellerFulfillmentOrderItemId'] = 'test_merchant_order_item_id_1';
        $xi[0]['Quantity'] = '5';
        $xi[1]['Quantity'] = '5';
        $xi[0]['GiftMessage'] = 'test_giftwrap_message';
        $xi[1]['GiftMessage'] = 'test_giftwrap_message';
        $xi[0]['DisplayableComment'] = 'test_displayable_comment';
        $xi[1]['DisplayableComment'] = 'test_displayable_comment';
        $xi[1]['FulfillmentNetworkSKU'] = 'SKUSKUSKU';
        $xi[0]['OrderItemDisposition'] = 'Sellable';
        $xi[1]['OrderItemDisposition'] = 'Sellable';
        $xi[0]['CancelledQuantity'] = '1';
        $xi[1]['CancelledQuantity'] = '1';
        $xi[0]['UnfulfillableQuantity'] = '0';
        $xi[1]['UnfulfillableQuantity'] = '2';
        $xi[0]['EstimatedShipDateTime'] = '2008-03-08T07:07:53Z';
        $xi[1]['EstimatedShipDateTime'] = '2008-03-09T07:07:53Z';
        $xi[0]['EstimatedArrivalDateTime'] = '2008-03-08T08:07:53Z';
        $xi[1]['EstimatedArrivalDateTime'] = '2008-03-09T08:07:53Z';
        $xi[0]['PerUnitDeclaredValue']['CurrencyCode'] = 'USD';
        $xi[0]['PerUnitDeclaredValue']['Value'] = '999.99';
        
        $x['Items'] = $xi;
        
        $xs = array();
        $xs[0]['AmazonShipmentId'] = 'DnMDLWJWN';
        $xs[1]['AmazonShipmentId'] = 'DKMKLXJmN';
        $xs[0]['FulfillmentCenterId'] = 'RNO1';
        $xs[1]['FulfillmentCenterId'] = 'TST1';
        $xs[0]['FulfillmentShipmentStatus'] = 'PENDING';
        $xs[1]['FulfillmentShipmentStatus'] = 'SHIPPED';
        $xs[0]['ShippingDateTime'] = '2006-08-04T07:00:00Z';
        $xs[1]['ShippingDateTime'] = '2006-08-03T07:00:00Z';
        $xs[0]['EstimatedArrivalDateTime'] = '2006-08-12T07:00:00Z';
        $xs[1]['EstimatedArrivalDateTime'] = '2006-08-12T07:00:00Z';
        $xs[0]['FulfillmentShipmentItem'][0]['SellerSKU'] = 'ssof_dev_drt_afn_item';
        $xs[1]['FulfillmentShipmentItem'][0]['SellerSKU'] = 'ssof_dev_drt_afn_item';
        $xs[0]['FulfillmentShipmentItem'][0]['SellerFulfillmentOrderItemId'] = 'test_merchant_order_item_id_2';
        $xs[1]['FulfillmentShipmentItem'][0]['SellerFulfillmentOrderItemId'] = 'test_merchant_order_item_id_2';
        $xs[0]['FulfillmentShipmentItem'][0]['Quantity'] = '2';
        $xs[1]['FulfillmentShipmentItem'][0]['Quantity'] = '1';
        $xs[0]['FulfillmentShipmentItem'][0]['PackageNumber'] = '0';
        $xs[1]['FulfillmentShipmentItem'][0]['PackageNumber'] = '1';
        $xs[1]['FulfillmentShipmentPackage'][0]['PackageNumber'] = '1';
        $xs[1]['FulfillmentShipmentPackage'][0]['CarrierCode'] = 'UPS';
        $xs[1]['FulfillmentShipmentPackage'][0]['TrackingNumber'] = '93ZZ00';
        $xs[1]['FulfillmentShipmentPackage'][0]['EstimatedArrivalDateTime'] = '2012-12-12T12:12:12Z';
        
        $x['Shipments'] = $xs;
        
        $this->assertEquals($x,$get);
        
        $this->assertFalse($this->object->getOrder()); //not fetched yet for this object
    }
    
    public function testCancelOrder(){
        resetLog();
        $this->object->setMock(true,200);
        
        $this->assertFalse($this->object->cancelOrder()); //no ID set yet
        $this->object->setOrderId('777');
        $ok = $this->object->cancelOrder();
        $this->assertTrue($ok);
        
        $check = parseLog();
        $this->assertEquals('Single Mock Response set: 200',$check[1]);
        $this->assertEquals('Fulfillment Order ID must be set in order to cancel it!',$check[2]);
        $this->assertEquals('Returning Mock Response: 200',$check[3]);
        $this->assertEquals('Successfully deleted Fulfillment Order 777',$check[4]);
        
        $o = $this->object->getOptions();
        $this->assertEquals('CancelFulfillmentOrder',$o['Action']);
    }
    
    public function testFetchMockResponse(){
        resetLog();
        $this->object->setOrderId('777');
        
        $this->object->setMock(true,array());
        $this->assertFalse($this->object->cancelOrder()); //no mock response
        $this->object->setMock(true,'oopsafile.xml');
        $this->assertFalse($this->object->cancelOrder()); //no strings allowed
        
        $this->object->setMock(true,array(404,503,400,200));
        $this->assertFalse($this->object->cancelOrder()); //404
        $this->assertFalse($this->object->cancelOrder()); //503
        $this->assertFalse($this->object->cancelOrder()); //400
        $this->assertTrue($this->object->cancelOrder()); //200
        $this->assertFalse($this->object->cancelOrder()); //loop back to 404
        
        $check = parseLog();
        $this->assertEquals('Mock files array set.',$check[1]);
        $this->assertEquals('Attempted to retrieve mock responses, but no mock responses present',$check[2]);
        $this->assertEquals('No Response found',$check[3]);
        $this->assertEquals('Mock Mode set to ON',$check[4]);
        $this->assertEquals('Single Mock File set: oopsafile.xml',$check[5]);
        $this->assertEquals('fetchMockResponse only works with response code numbers',$check[6]);
        $this->assertEquals('No Response found',$check[7]);
        $this->assertEquals('Mock Mode set to ON',$check[8]);
        $this->assertEquals('Mock files array set.',$check[9]);
        $this->assertEquals('Returning Mock Response: 404',$check[10]);
        $this->assertEquals('Bad Response! 404 Not Found: Not Found - Not Found',$check[11]);
        $this->assertEquals('Returning Mock Response: 503',$check[12]);
        $this->assertEquals('Bad Response! 503 Service Unavailable: Service Unavailable - Service Unavailable',$check[13]);
        $this->assertEquals('Returning Mock Response: 400',$check[14]);
        $this->assertEquals('Bad Response! 400 Bad Request: Bad Request - Bad Request',$check[15]);
        $this->assertEquals('Returning Mock Response: 200',$check[16]);
        $this->assertEquals('Successfully deleted Fulfillment Order 777',$check[17]);
        $this->assertEquals('End of Mock List, resetting to 0',$check[18]);
        $this->assertEquals('Mock List index reset to 0',$check[19]);
        $this->assertEquals('Returning Mock Response: 404',$check[20]);
        $this->assertEquals('Bad Response! 404 Not Found: Not Found - Not Found',$check[21]);
    }
    
}

require_once(__DIR__.'/../helperFunctions.php');