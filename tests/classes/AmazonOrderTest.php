<?php
use MixasikM\AmazonMws\AmazonOrder;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-12 at 13:17:14.
 */
class AmazonOrderTest extends PHPUnit_Framework_TestCase {

    /**
     * @var AmazonOrder
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        resetLog();
        $this->object = new AmazonOrder('testStore', null, null, true, null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    
    public function testSetUp(){
        $obj = new AmazonOrder('testStore', '77');
        
        $o = $obj->getOptions();
        $this->assertArrayHasKey('AmazonOrderId.Id.1',$o);
        $this->assertEquals('77', $o['AmazonOrderId.Id.1']);
        
        $data = simplexml_load_file(__DIR__.'/../../mock/fetchOrder.xml');
        $obj2 = new AmazonOrder('testStore', null, $data->GetOrderResult->Orders->Order);
        
        $get = $obj2->getAmazonOrderId();
        $this->assertEquals('058-1233752-8214740', $get);
    }
    
    public function testSetOrderId(){
        $this->assertNull($this->object->setOrderId('777'));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('AmazonOrderId.Id.1',$o);
        $this->assertEquals('777',$o['AmazonOrderId.Id.1']);
        $this->assertNull($this->object->setOrderId(77));
        $o2 = $this->object->getOptions();
        $this->assertArrayHasKey('AmazonOrderId.Id.1',$o2);
        $this->assertEquals(77,$o2['AmazonOrderId.Id.1']);
        $this->assertFalse($this->object->setOrderId(array())); //won't work for this
        $this->assertFalse($this->object->setOrderId(null)); //won't work for other things
        
        $check = parseLog();
        $this->assertEquals('Attempted to set AmazonOrderId to invalid value',$check[1]);
        $this->assertEquals('Attempted to set AmazonOrderId to invalid value',$check[2]);
    }
    
    public function testFetchOrder(){
        resetLog();
        $this->object->setMock(true,'fetchOrder.xml');
        
        $this->assertFalse($this->object->fetchOrder()); //no order ID set yet
        
        $this->object->setOrderId('058-1233752-8214740');
        $this->assertNull($this->object->fetchOrder()); //now it is good
        
        $o = $this->object->getOptions();
        $this->assertEquals('GetOrder',$o['Action']);
        
        $check = parseLog();
        $this->assertEquals('Single Mock File set: fetchOrder.xml',$check[1]);
        $this->assertEquals('Order ID must be set in order to fetch it!',$check[2]);
        $this->assertEquals('Fetched Mock File: mock/fetchOrder.xml',$check[3]);
        
        $get = $this->object->getData();
        $this->assertInternalType('array',$get);
        
        return $this->object;
        
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetData($o){
        $get = $o->getData();
        $this->assertInternalType('array',$get);
        
        $x = array();
        $x['AmazonOrderId'] = '058-1233752-8214740';
        $x['SellerOrderId'] = '123ABC';
        $x['PurchaseDate'] = '2010-10-05T00:06:07.000Z';
        $x['LastUpdateDate'] = '2010-10-05T12:43:16.000Z';
        $x['OrderStatus'] = 'Unshipped';
        $x['FulfillmentChannel'] = 'MFN';
        $x['SalesChannel'] = 'Checkout by Amazon';
        $x['OrderChannel'] = 'OrderChannel';
        $x['ShipServiceLevel'] = 'Std DE Dom';
        $a = array();
            $a['Name'] = 'John Smith';
            $a['AddressLine1'] = '2700 First Avenue';
            $a['AddressLine2'] = 'Apartment 1';
            $a['AddressLine3'] = 'Suite 16';
            $a['City'] = 'Seattle';
            $a['County'] = 'County';
            $a['District'] = 'District';
            $a['StateOrRegion'] = 'WA';
            $a['PostalCode'] = '98102';
            $a['CountryCode'] = 'US';
            $a['Phone'] = '123';
        $x['ShippingAddress'] = $a;
        $x['OrderTotal']['Amount'] = '4.78';
        $x['OrderTotal']['CurrencyCode'] = 'USD';
        $x['NumberOfItemsShipped'] = '1';
        $x['NumberOfItemsUnshipped'] = '1';
        $x['PaymentExecutionDetail'][0]['Amount'] = '101.01';
        $x['PaymentExecutionDetail'][0]['CurrencyCode'] = 'USD';
        $x['PaymentExecutionDetail'][0]['SubPaymentMethod'] = 'COD';
        $x['PaymentExecutionDetail'][1]['Amount'] = '10.00';
        $x['PaymentExecutionDetail'][1]['CurrencyCode'] = 'USD';
        $x['PaymentExecutionDetail'][1]['SubPaymentMethod'] = 'GC';
        $x['PaymentMethod'] = 'COD';
        $x['MarketplaceId'] = 'ATVPDKIKX0DER';
        $x['BuyerName'] = 'Amazon User';
        $x['BuyerEmail'] = '5vlh04mgfmjh9h5@marketplace.amazon.com';
        $x['ShipServiceLevelCategory'] = 'Standard';
        
        $this->assertEquals($x,$get);
        
        $this->assertFalse($this->object->getData()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetAmazonOrderId($o){
        $get = $o->getAmazonOrderId();
        $this->assertEquals('058-1233752-8214740',$get);
        
        $this->assertFalse($this->object->getAmazonOrderId()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetSellerOrderId($o){
        $get = $o->getSellerOrderId();
        $this->assertEquals('123ABC',$get);
        
        $this->assertFalse($this->object->getSellerOrderId()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetPurchaseDate($o){
        $get = $o->getPurchaseDate();
        $this->assertEquals('2010-10-05T00:06:07.000Z',$get);
        
        $this->assertFalse($this->object->getPurchaseDate()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetLastUpdateDate($o){
        $get = $o->getLastUpdateDate();
        $this->assertEquals('2010-10-05T12:43:16.000Z',$get);
        
        $this->assertFalse($this->object->getLastUpdateDate()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetOrderStatus($o){
        $get = $o->getOrderStatus();
        $this->assertEquals('Unshipped',$get);
        
        $this->assertFalse($this->object->getOrderStatus()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetFulfillmentChannel($o){
        $get = $o->getFulfillmentChannel();
        $this->assertEquals('MFN',$get);
        
        $this->assertFalse($this->object->getFulfillmentChannel()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetSalesChannel($o){
        $get = $o->getSalesChannel();
        $this->assertEquals('Checkout by Amazon',$get);
        
        $this->assertFalse($this->object->getSalesChannel()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetOrderChannel($o){
        $get = $o->getOrderChannel();
        $this->assertEquals('OrderChannel',$get);
        
        $this->assertFalse($this->object->getOrderChannel()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetShipServiceLevel($o){
        $get = $o->getShipServiceLevel();
        $this->assertEquals('Std DE Dom',$get);
        
        $this->assertFalse($this->object->getShipServiceLevel()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetShippingAddress($o){
        $get = $o->getShippingAddress();
        $a = array();
            $a['Name'] = 'John Smith';
            $a['AddressLine1'] = '2700 First Avenue';
            $a['AddressLine2'] = 'Apartment 1';
            $a['AddressLine3'] = 'Suite 16';
            $a['City'] = 'Seattle';
            $a['County'] = 'County';
            $a['District'] = 'District';
            $a['StateOrRegion'] = 'WA';
            $a['PostalCode'] = '98102';
            $a['CountryCode'] = 'US';
            $a['Phone'] = '123';
        $this->assertEquals($a,$get);
        
        $this->assertFalse($this->object->getShippingAddress()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetOrderTotal($o){
        $get = $o->getOrderTotal();
        $x = array();
        $x['Amount'] = '4.78';
        $x['CurrencyCode'] = 'USD';
        $this->assertEquals($x,$get);
        
        $this->assertFalse($this->object->getOrderTotal()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetOrderTotalAmount($o){
        $get = $o->getOrderTotalAmount();
        $this->assertEquals('4.78',$get);
        
        $this->assertFalse($this->object->getOrderTotalAmount()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetNumberofItemsShipped($o){
        $get = $o->getNumberofItemsShipped();
        $this->assertEquals('1',$get);
        
        $this->assertFalse($this->object->getNumberofItemsShipped()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetNumberofItemsUnshipped($o){
        $get = $o->getNumberOfItemsUnshipped();
        $this->assertEquals('1',$get);
        
        $this->assertFalse($this->object->getNumberOfItemsUnshipped()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetPaymentExecutionDetail($o){
        $get = $o->getPaymentExecutionDetail();
        $x = array();
        $x[0]['Amount'] = '101.01';
        $x[0]['CurrencyCode'] = 'USD';
        $x[0]['SubPaymentMethod'] = 'COD';
        $x[1]['Amount'] = '10.00';
        $x[1]['CurrencyCode'] = 'USD';
        $x[1]['SubPaymentMethod'] = 'GC';
        $this->assertEquals($x,$get);
        
        $this->assertFalse($this->object->getPaymentExecutionDetail()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetPaymentMethod($o){
        $get = $o->getPaymentMethod();
        $this->assertEquals('COD',$get);
        
        $this->assertFalse($this->object->getPaymentMethod()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetMarketplaceId($o){
        $get = $o->getMarketplaceId();
        $this->assertEquals('ATVPDKIKX0DER',$get);
        
        $this->assertFalse($this->object->getMarketplaceId()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetBuyerName($o){
        $get = $o->getBuyerName();
        $this->assertEquals('Amazon User',$get);
        
        $this->assertFalse($this->object->getBuyerName()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetBuyerEmail($o){
        $get = $o->getBuyerEmail();
        $this->assertEquals('5vlh04mgfmjh9h5@marketplace.amazon.com',$get);
        
        $this->assertFalse($this->object->getBuyerEmail()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetShipServiceLevelCategory($o){
        $get = $o->getShipServiceLevelCategory();
        $this->assertEquals('Standard',$get);
        
        $this->assertFalse($this->object->getShipServiceLevelCategory()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testGetPercentShipped($o){
        $get = $o->getPercentShipped();
        $this->assertEquals(0.5,$get);
        
        $this->assertFalse($this->object->getPercentShipped()); //not fetched yet for this object
    }
    
    /**
     * @depends testFetchOrder
     */
    public function testFetchItems($o){
        $o->setMock(true,'fetchOrderItems.xml');
        $obj = $o->fetchItems();
        $get = $obj->getItems();
        
        $x = array();
        $x1 = array();
        $x1['ASIN'] = 'BT0093TELA';
        $x1['SellerSKU'] = 'CBA_OTF_1';
        $x1['OrderItemId'] = '68828574383266';
        $x1['Title'] = 'Example item name';
        $x1['QuantityOrdered'] = '1';
        $x1['QuantityShipped'] = '1';
        $x1['GiftMessageText'] = 'For you!';
        $x1['GiftWrapLevel'] = 'Classic';
        $x1['ItemPrice']['Amount'] = '25.99';
        $x1['ItemPrice']['CurrencyCode'] = 'USD';
        $x1['ShippingPrice']['Amount'] = '1.26';
        $x1['ShippingPrice']['CurrencyCode'] = 'USD';
        $x1['CODFee']['Amount'] = '10.00';
        $x1['CODFee']['CurrencyCode'] = 'USD';
        $x1['CODFeeDiscount']['Amount'] = '1.00';
        $x1['CODFeeDiscount']['CurrencyCode'] = 'USD';
        $x1['ItemTax'] = $x1['CODFeeDiscount'];
        $x1['ShippingTax'] = $x1['CODFeeDiscount'];
        $x1['GiftWrapTax'] = $x1['CODFeeDiscount'];
        $x1['ShippingDiscount'] = $x1['CODFeeDiscount'];
        $x1['PromotionDiscount'] = $x1['CODFeeDiscount'];
        $x1['GiftWrapPrice']['Amount'] = '1.99';
        $x1['GiftWrapPrice']['CurrencyCode'] = 'USD';
        $x[0] = $x1;
        $x2 = array();
        $x2['ASIN'] = 'BCTU1104UEFB';
        $x2['SellerSKU'] = 'CBA_OTF_5';
        $x2['OrderItemId'] = '79039765272157';
        $x2['Title'] = 'Example item name';
        $x2['QuantityOrdered'] = '2';
        $x2['ItemPrice']['Amount'] = '17.95';
        $x2['ItemPrice']['CurrencyCode'] = 'USD';
        $x2['PromotionIds'][0] = 'FREESHIP';
        $x[1] = $x2;
        
        $this->assertEquals($x,$get);
        
        $alt = $o->fetchItems(5); //boolean changed to false
        $altget = $alt->getItems();
        $this->assertEquals($x,$altget);
        
        $this->assertFalse($this->object->fetchItems()); //not fetched yet for this object
    }
    
}

require_once(__DIR__.'/../helperFunctions.php');