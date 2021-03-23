<?php
use MixasikM\AmazonMws\AmazonShipment;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-12 at 13:17:14.
 */
class AmazonShipmentTest extends PHPUnit_Framework_TestCase {

    /**
     * @var AmazonShipment
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        resetLog();
        $this->object = new AmazonShipment('testStore', true, null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    
    public function testSetAddress(){
        $this->assertFalse($this->object->setAddress(null)); //can't be nothing
        $this->assertFalse($this->object->setAddress('address')); //can't be a string
        $this->assertFalse($this->object->setAddress(array())); //can't be empty
        $this->assertFalse($this->object->setAddress(array('address' => 'address'))); //missing keys
        
        $check = parseLog();
        $this->assertEquals('Tried to set address to invalid values',$check[1]);
        $this->assertEquals('Tried to set address to invalid values',$check[2]);
        $this->assertEquals('Tried to set address to invalid values',$check[3]);
        $this->assertEquals('Tried to set address with invalid array',$check[4]);
        
        $a1 = array();
        $a1['Name'] = 'Name';
        $a1['AddressLine1'] = 'AddressLine1';
        $a1['AddressLine2'] = 'AddressLine2';
        $a1['City'] = 'City';
        $a1['DistrictOrCounty'] = 'DistrictOrCounty';
        $a1['StateOrProvinceCode'] = 'StateOrProvinceCode';
        $a1['CountryCode'] = 'CountryCode';
        $a1['PostalCode'] = 'PostalCode';
        
        $this->assertNull($this->object->setAddress($a1));
        
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('InboundShipmentHeader.ShipFromAddress.Name',$o);
        $this->assertEquals('Name',$o['InboundShipmentHeader.ShipFromAddress.Name']);
        $this->assertArrayHasKey('InboundShipmentHeader.ShipFromAddress.AddressLine1',$o);
        $this->assertEquals('AddressLine1',$o['InboundShipmentHeader.ShipFromAddress.AddressLine1']);
        $this->assertArrayHasKey('InboundShipmentHeader.ShipFromAddress.AddressLine2',$o);
        $this->assertEquals('AddressLine2',$o['InboundShipmentHeader.ShipFromAddress.AddressLine2']);
        $this->assertArrayHasKey('InboundShipmentHeader.ShipFromAddress.DistrictOrCounty',$o);
        $this->assertEquals('DistrictOrCounty',$o['InboundShipmentHeader.ShipFromAddress.DistrictOrCounty']);
        $this->assertArrayHasKey('InboundShipmentHeader.ShipFromAddress.City',$o);
        $this->assertEquals('City',$o['InboundShipmentHeader.ShipFromAddress.City']);
        $this->assertArrayHasKey('InboundShipmentHeader.ShipFromAddress.StateOrProvinceCode',$o);
        $this->assertEquals('StateOrProvinceCode',$o['InboundShipmentHeader.ShipFromAddress.StateOrProvinceCode']);
        $this->assertArrayHasKey('InboundShipmentHeader.ShipFromAddress.CountryCode',$o);
        $this->assertEquals('CountryCode',$o['InboundShipmentHeader.ShipFromAddress.CountryCode']);
        $this->assertArrayHasKey('InboundShipmentHeader.ShipFromAddress.PostalCode',$o);
        $this->assertEquals('PostalCode',$o['InboundShipmentHeader.ShipFromAddress.PostalCode']);
        
        $a2 = array();
        $a2['Name'] = 'Name2';
        $a2['AddressLine1'] = 'AddressLine1-2';
        $a2['City'] = 'City2';
        $a2['StateOrProvinceCode'] = 'StateOrProvinceCode2';
        $a2['CountryCode'] = 'CountryCode2';
        $a2['PostalCode'] = 'PostalCode2';
        
        $this->assertNull($this->object->setAddress($a2)); //testing reset
        
        $o2 = $this->object->getOptions();
        $this->assertArrayHasKey('InboundShipmentHeader.ShipFromAddress.Name',$o2);
        $this->assertEquals('Name2',$o2['InboundShipmentHeader.ShipFromAddress.Name']);
        $this->assertNull($o2['InboundShipmentHeader.ShipFromAddress.AddressLine2']);
        $this->assertNull($o2['InboundShipmentHeader.ShipFromAddress.DistrictOrCounty']);
        
    }
    
    public function testSetItems(){
        $this->assertFalse($this->object->setItems(null)); //can't be nothing
        $this->assertFalse($this->object->setItems('item')); //can't be a string
        $this->assertFalse($this->object->setItems(array())); //can't be empty
        
        $break = array();
        $break[0]['Bork'] = 'bork bork';
        
        $this->assertFalse($this->object->setItems($break)); //missing seller sku
        
        $break[0]['SellerSKU'] = 'some sku';
        
        $this->assertFalse($this->object->setItems($break)); //missing quantity
        
        $check = parseLog();
        $this->assertEquals('Tried to set Items to invalid values',$check[1]);
        $this->assertEquals('Tried to set Items to invalid values',$check[2]);
        $this->assertEquals('Tried to set Items to invalid values',$check[3]);
        $this->assertEquals('Tried to set Items with invalid array',$check[4]);
        $this->assertEquals('Tried to set Items with invalid array',$check[5]);
        
        $i = array();
        $i[0]['SellerSKU'] = 'SellerSKU';
        $i[0]['Quantity'] = 'Quantity';
        $i[0]['QuantityInCase'] = 'QuantityInCase';
        $i[1]['SellerSKU'] = 'SellerSKU2';
        $i[1]['Quantity'] = 'Quantity2';
        
        $this->assertNull($this->object->setItems($i));
        
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('InboundShipmentItems.member.1.SellerSKU',$o);
        $this->assertEquals('SellerSKU',$o['InboundShipmentItems.member.1.SellerSKU']);
        $this->assertArrayHasKey('InboundShipmentItems.member.1.QuantityShipped',$o);
        $this->assertEquals('Quantity',$o['InboundShipmentItems.member.1.QuantityShipped']);
        $this->assertArrayHasKey('InboundShipmentItems.member.1.QuantityInCase',$o);
        $this->assertEquals('QuantityInCase',$o['InboundShipmentItems.member.1.QuantityInCase']);
        $this->assertArrayHasKey('InboundShipmentItems.member.1.SellerSKU',$o);
        $this->assertEquals('SellerSKU2',$o['InboundShipmentItems.member.2.SellerSKU']);
        $this->assertArrayHasKey('InboundShipmentItems.member.2.QuantityShipped',$o);
        $this->assertEquals('Quantity2',$o['InboundShipmentItems.member.2.QuantityShipped']);
        
        $i2 = array();
        $i2[0]['SellerSKU'] = 'NewSellerSKU';
        $i2[0]['Quantity'] = 'NewQuantity';
        
        $this->assertNull($this->object->setItems($i2)); //will cause reset
        
        $o2 = $this->object->getOptions();
        $this->assertArrayHasKey('InboundShipmentItems.member.1.SellerSKU',$o2);
        $this->assertEquals('NewSellerSKU',$o2['InboundShipmentItems.member.1.SellerSKU']);
        $this->assertArrayHasKey('InboundShipmentItems.member.1.QuantityShipped',$o2);
        $this->assertEquals('NewQuantity',$o2['InboundShipmentItems.member.1.QuantityShipped']);
        $this->assertArrayNotHasKey('InboundShipmentItems.member.1.QuantityInCase',$o2);
        $this->assertArrayNotHasKey('InboundShipmentItems.member.2.SellerSKU',$o2);
        $this->assertArrayNotHasKey('InboundShipmentItems.member.2.QuantityShipped',$o2);
    }
    
    public function testSetStatus(){
        $this->assertFalse($this->object->setStatus(null)); //can't be nothing
        $this->assertFalse($this->object->setStatus(5)); //can't be an int
        $this->assertFalse($this->object->setStatus('wrong')); //not a valid value
        $this->assertNull($this->object->setStatus('WORKING'));
        $this->assertNull($this->object->setStatus('SHIPPED'));
        $this->assertNull($this->object->setStatus('CANCELLED'));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('InboundShipmentHeader.ShipmentStatus',$o);
        $this->assertEquals('CANCELLED',$o['InboundShipmentHeader.ShipmentStatus']);
    }
    
    public function testSetShipmentId(){
        $this->assertFalse($this->object->setShipmentId(null)); //can't be nothing
        $this->assertFalse($this->object->setShipmentId(5)); //can't be an int
        $this->assertNull($this->object->setShipmentId('777'));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('ShipmentId',$o);
        $this->assertEquals('777',$o['ShipmentId']);
    }
    
    public function testUsePlan(){
        $planner = new AmazonShipmentPlanner('testStore', true, 'fetchPlan.xml', __DIR__.'/../../test-config.php');
        $a = array();
        $a['Name'] = 'Name';
        $a['AddressLine1'] = 'AddressLine1';
        $a['City'] = 'City';
        $a['StateOrProvinceCode'] = 'StateOrProvinceCode';
        $a['CountryCode'] = 'CountryCode';
        $a['PostalCode'] = 'PostalCode';
        $planner->setAddress($a);
        $i = array();
        $i[0]['SellerSKU'] = 'NewSellerSKU';
        $i[0]['Quantity'] = 'NewQuantity';
        $planner->setItems($i);
        $this->assertNull($planner->fetchPlan());
        $plan = $planner->getPlan(0);
        $this->assertNull($this->object->usePlan($plan));
        
        $o = $this->object->getOptions();
        $this->assertEquals('FBA63J76R',$o['InboundShipmentHeader.ShipmentId']);
        $this->assertEquals('PHX6',$o['InboundShipmentHeader.DestinationFulfillmentCenterId']);
        $this->assertEquals('NO_LABEL',$o['InboundShipmentHeader.LabelPrepType']);
        $this->assertEquals('Amazon.com',$o['InboundShipmentHeader.ShipFromAddress.Name']);
        $this->assertEquals('4750 West Mohave St',$o['InboundShipmentHeader.ShipFromAddress.AddressLine1']);
        $this->assertEquals(null,$o['InboundShipmentHeader.ShipFromAddress.AddressLine2']);
        $this->assertEquals('Phoenix',$o['InboundShipmentHeader.ShipFromAddress.City']);
        $this->assertEquals(null,$o['InboundShipmentHeader.ShipFromAddress.DistrictOrCounty']);
        $this->assertEquals('AZ',$o['InboundShipmentHeader.ShipFromAddress.StateOrProvinceCode']);
        $this->assertEquals('US',$o['InboundShipmentHeader.ShipFromAddress.CountryCode']);
        $this->assertEquals('85043',$o['InboundShipmentHeader.ShipFromAddress.PostalCode']);
        $this->assertEquals('Football2415',$o['InboundShipmentItems.member.1.SellerSKU']);
        $this->assertEquals('3',$o['InboundShipmentItems.member.1.QuantityShipped']);
        $this->assertEquals('TeeballBall3251',$o['InboundShipmentItems.member.2.SellerSKU']);
        $this->assertEquals('5',$o['InboundShipmentItems.member.2.QuantityShipped']);
        
        resetLog();
        $this->assertFalse($this->object->usePlan(null));
        $check = parseLog();
        $this->assertEquals('usePlan requires an array',$check[0]);
        
        return $this->object;
    }
    
    /**
     * @depends testUsePlan
     */
    public function testCreateShipment($o){
        resetLog();
        $this->object = new AmazonShipment('testStore',true, null);
        $this->assertFalse($this->object->createShipment()); //no ID set
        
        $this->object->setShipmentId('55');
        $this->assertFalse($this->object->createShipment()); //no header set
        
        $a = array();
        $a['Name'] = 'Name';
        $a['AddressLine1'] = 'AddressLine1';
        $a['City'] = 'City';
        $a['StateOrProvinceCode'] = 'StateOrProvinceCode';
        $a['CountryCode'] = 'CountryCode';
        $a['PostalCode'] = 'PostalCode';
        $this->object->setAddress($a);
        $this->assertFalse($this->object->createShipment()); //no items yet
        
        $o->setMock(true,'createShipment.xml');
        $this->assertTrue($o->createShipment()); //this one is good
        
        $op = $o->getOptions();
        $this->assertEquals('CreateInboundShipment',$op['Action']);
        
        $check = parseLog();
        $this->assertEquals('Shipment ID must be set in order to create it',$check[1]);
        $this->assertEquals('Header must be set in order to make a shipment',$check[2]);
        $this->assertEquals('Items must be set in order to make a shipment',$check[3]);
        $this->assertEquals('Single Mock File set: createShipment.xml',$check[5]);
        $this->assertEquals('Fetched Mock File: mock/createShipment.xml',$check[6]);
        $this->assertEquals('Successfully created Shipment #FBA63JX44',$check[7]);
        
        return $o;
    }
    
    /**
     * @depends testCreateShipment
     */
    public function testGetShipmentId($o){
        $get = $o->getShipmentId();
        $this->assertEquals('FBA63JX44',$get);
        
        $this->assertFalse($this->object->getShipmentId()); //not fetched yet for this object
    }
    
    /**
     * @depends testUsePlan
     */
    public function testUpdateShipment($o){
        resetLog();
        $this->object = new AmazonShipment('testStore', true, null);
        $this->assertFalse($this->object->updateShipment()); //no ID set
        
        $this->object->setShipmentId('55');
        $this->assertFalse($this->object->updateShipment()); //no header set
        
        $a = array();
        $a['Name'] = 'Name';
        $a['AddressLine1'] = 'AddressLine1';
        $a['City'] = 'City';
        $a['StateOrProvinceCode'] = 'StateOrProvinceCode';
        $a['CountryCode'] = 'CountryCode';
        $a['PostalCode'] = 'PostalCode';
        $this->object->setAddress($a);
        $this->assertFalse($this->object->updateShipment()); //no items yet
        
        $o->setMock(true,'updateShipment.xml');
        $this->assertTrue($o->updateShipment()); //this one is good
        
        $op = $o->getOptions();
        $this->assertEquals('UpdateInboundShipment',$op['Action']);
        
        $check = parseLog();
        $this->assertEquals('Shipment ID must be set in order to update it',$check[1]);
        $this->assertEquals('Header must be set in order to update a shipment',$check[2]);
        $this->assertEquals('Items must be set in order to update a shipment',$check[3]);
        $this->assertEquals('Single Mock File set: updateShipment.xml',$check[5]);
        $this->assertEquals('Fetched Mock File: mock/updateShipment.xml',$check[6]);
        $this->assertEquals('Successfully updated Shipment #FBA63J76R',$check[7]);
    }
    
}

require_once(__DIR__.'/../helperFunctions.php');