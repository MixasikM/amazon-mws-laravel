<?php
use MixasikM\AmazonMws\AmazonProductInfo;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2012-12-12 at 13:17:14.
 */
class AmazonProductInfoTest extends PHPUnit_Framework_TestCase {

    /**
     * @var AmazonProductInfo
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        resetLog();
        $this->object = new AmazonProductInfo('testStore', true, null);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
    
    public function testSetSKUs(){
        $this->object->setASINs('123456789');
        $this->assertNull($this->object->setSKUs(array('123','456')));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('SellerSKUList.SellerSKU.1',$o);
        $this->assertEquals('123',$o['SellerSKUList.SellerSKU.1']);
        $this->assertArrayHasKey('SellerSKUList.SellerSKU.2',$o);
        $this->assertEquals('456',$o['SellerSKUList.SellerSKU.2']);
        $this->assertArrayNotHasKey('ASINList.ASIN.1',$o);
        
        $this->assertNull($this->object->setSKUs('789')); //causes reset
        $o2 = $this->object->getOptions();
        $this->assertEquals('789',$o2['SellerSKUList.SellerSKU.1']);
        $this->assertArrayNotHasKey('SellerSKUList.SellerSKU.2',$o2);
        
        $this->assertFalse($this->object->setSKUs(null));
        $this->assertFalse($this->object->setSKUs(707));
    }
    
    public function testSetASINs(){
        $this->object->setSKUs('123456789');
        $this->assertNull($this->object->setASINs(array('123','456')));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('ASINList.ASIN.1',$o);
        $this->assertEquals('123',$o['ASINList.ASIN.1']);
        $this->assertArrayHasKey('ASINList.ASIN.2',$o);
        $this->assertEquals('456',$o['ASINList.ASIN.2']);
        $this->assertArrayNotHasKey('SellerSKUList.SellerSKU.1',$o);
        
        $this->assertNull($this->object->setASINs('789')); //causes reset
        $o2 = $this->object->getOptions();
        $this->assertEquals('789',$o2['ASINList.ASIN.1']);
        $this->assertArrayNotHasKey('ASINList.ASIN.2',$o2);
        
        $this->assertFalse($this->object->setASINs(null));
        $this->assertFalse($this->object->setASINs(707));
    }
    
    public function testSetConditionFilter(){
        $this->assertFalse($this->object->setConditionFilter(null)); //can't be nothing
        $this->assertFalse($this->object->setConditionFilter(5)); //can't be an int
        $this->assertNull($this->object->setConditionFilter('New'));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('ItemCondition',$o);
        $this->assertEquals('New',$o['ItemCondition']);
    }
    
    public function testSetExcludeSelf(){
        $this->assertFalse($this->object->setExcludeSelf(null)); //can't be nothing
        $this->assertFalse($this->object->setExcludeSelf(5)); //can't be an int
        $this->assertFalse($this->object->setExcludeSelf('banana')); //can't be a random word
        $this->assertNull($this->object->setExcludeSelf(false));
        $this->assertNull($this->object->setExcludeSelf(true));
        $this->assertNull($this->object->setExcludeSelf('false'));
        $this->assertNull($this->object->setExcludeSelf('true'));
        $o = $this->object->getOptions();
        $this->assertArrayHasKey('ExcludeMe',$o);
        $this->assertEquals('true',$o['ExcludeMe']);
    }
    
    public function testFetchCompetitivePricing(){
        resetLog();
        $this->object->setMock(true,'fetchCompetitivePricing.xml');
        $this->assertFalse($this->object->fetchCompetitivePricing()); //no IDs yet
        $this->object->setSKUs('789');
        
        $this->assertNull($this->object->fetchCompetitivePricing());
        $o = $this->object->getOptions();
        $this->assertEquals('GetCompetitivePricingForSKU',$o['Action']);
        
        $check = parseLog();
        $this->assertEquals('Single Mock File set: fetchCompetitivePricing.xml',$check[1]);
        $this->assertEquals('Product IDs must be set in order to look them up!',$check[2]);
        $this->assertEquals('Fetched Mock File: mock/fetchCompetitivePricing.xml',$check[3]);
        
        return $this->object;
    }
    
    /**
     * @depends testFetchCompetitivePricing
     */
    public function testGetProductCompetitivePricing($o){
        $product = $o->getProduct(0);
        $this->assertInternalType('object',$product);
        
        $list = $o->getProduct(null);
        $this->assertInternalType('array',$list);
        $this->assertArrayHasKey(0,$list);
        $this->assertEquals($product,$list[0]);
        
        $default = $o->getProduct();
        $this->assertEquals($list,$default);
        
        $check = $product->getData();
        $this->assertArrayHasKey('Identifiers',$check);
        $this->assertArrayHasKey('CompetitivePricing',$check);
        $this->assertArrayHasKey('SalesRankings',$check);
        
        $this->assertFalse($this->object->getProduct()); //not fetched yet for this object
    }
    
    public function testFetchLowestOffer(){
        resetLog();
        $this->object->setMock(true,'fetchLowestOffer.xml');
        $this->assertFalse($this->object->fetchLowestOffer()); //no IDs yet
        $this->object->setSKUs('789');
        
        $this->assertNull($this->object->fetchLowestOffer());
        $o = $this->object->getOptions();
        $this->assertEquals('GetLowestOfferListingsForSKU',$o['Action']);
        
        $check = parseLog();
        $this->assertEquals('Single Mock File set: fetchLowestOffer.xml',$check[1]);
        $this->assertEquals('Product IDs must be set in order to look them up!',$check[2]);
        $this->assertEquals('Fetched Mock File: mock/fetchLowestOffer.xml',$check[3]);
        $this->assertEquals('Special case: AllOfferListingsConsidered',$check[4]);
        
        return $this->object;
    }
    
    /**
     * @depends testFetchLowestOffer
     */
    public function testGetProductLowestOffer($o){
        $product = $o->getProduct(0);
        $this->assertInternalType('object',$product);
        
        $list = $o->getProduct(null);
        $this->assertInternalType('array',$list);
        $this->assertArrayHasKey(0,$list);
        $this->assertEquals($product,$list[0]);
        
        $default = $o->getProduct();
        $this->assertEquals($list,$default);
        
        $check = $product->getData();
        $this->assertInternalType('array',$check);
        $this->assertArrayHasKey('Identifiers',$check);
        $this->assertArrayHasKey('LowestOfferListings',$check);
        
        $this->assertFalse($this->object->getProduct()); //not fetched yet for this object
    }
    
    public function testFetchMyPrice(){
        resetLog();
        $this->object->setMock(true,'fetchMyPrice.xml');
        $this->assertFalse($this->object->fetchMyPrice()); //no IDs yet
        $this->object->setSKUs('789');
        
        $this->assertNull($this->object->fetchMyPrice());
        $o = $this->object->getOptions();
        $this->assertEquals('GetMyPriceForSKU',$o['Action']);
        
        $check = parseLog();
        $this->assertEquals('Single Mock File set: fetchMyPrice.xml',$check[1]);
        $this->assertEquals('Product IDs must be set in order to look them up!',$check[2]);
        $this->assertEquals('Fetched Mock File: mock/fetchMyPrice.xml',$check[3]);
        
        return $this->object;
    }
    
    /**
     * @depends testFetchMyPrice
     */
    public function testGetProductMyPrice($o){
        $product = $o->getProduct(0);
        $this->assertInternalType('object',$product);
        
        $list = $o->getProduct(null);
        $this->assertInternalType('array',$list);
        $this->assertArrayHasKey(0,$list);
        $this->assertEquals($product,$list[0]);
        
        $default = $o->getProduct();
        $this->assertEquals($list,$default);
        
        $check = $product->getData();
        $this->assertInternalType('array',$check);
        $this->assertArrayHasKey('Identifiers',$check);
        $this->assertArrayHasKey('Offers',$check);
        
        $this->assertFalse($this->object->getProduct()); //not fetched yet for this object
    }
    
    public function testFetchCategories(){
        resetLog();
        $this->object->setMock(true,'fetchCategories.xml');
        $this->assertFalse($this->object->fetchCategories()); //no IDs yet
        $this->object->setSKUs('789');
        $this->assertNull($this->object->fetchCategories());
        $o = $this->object->getOptions();
        $this->assertEquals('GetProductCategoriesForSKU',$o['Action']);
        
        $check = parseLog();
        $this->assertEquals('Single Mock File set: fetchCategories.xml',$check[1]);
        $this->assertEquals('Product IDs must be set in order to look them up!',$check[2]);
        $this->assertEquals('Fetched Mock File: mock/fetchCategories.xml',$check[3]);
        
        return $this->object;
    }
    
    /**
     * @depends testFetchCategories
     */
    public function testGetProductCategories($o){
        $product = $o->getProduct(0);
        $this->assertInternalType('object',$product);
        
        $list = $o->getProduct(null);
        $this->assertInternalType('array',$list);
        $this->assertArrayHasKey(0,$list);
        $this->assertArrayNotHasKey(1,$list);
        $this->assertEquals($product,$list[0]);
        
        $default = $o->getProduct();
        $this->assertEquals($list,$default);
        
        $check = $product->getData();
        $this->assertInternalType('array',$check);
        $this->assertArrayHasKey('Categories',$check);
        $this->assertArrayHasKey(0,$check['Categories']);
        $this->assertArrayHasKey(1,$check['Categories']);
        
        $this->assertFalse($this->object->getProduct()); //not fetched yet for this object
    }
    
}

require_once(__DIR__.'/../helperFunctions.php');