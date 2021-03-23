<?php namespace MixasikM\AmazonMws;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/config/amazon-mws.php';
        $this->mergeConfigFrom($configPath, 'amazon-mws');

        $this->app->alias('AmazonCore', 'MixasikM\AmazonMws\AmazonCore');
        $this->app->alias('AmazonFeed', 'MixasikM\AmazonMws\AmazonFeed');
        $this->app->alias('AmazonFeedList', 'MixasikM\AmazonMws\AmazonFeedList');
        $this->app->alias('AmazonFeedResult', 'MixasikM\AmazonMws\AmazonFeedResult');
        $this->app->alias('AmazonFeedsCore', 'MixasikM\AmazonMws\AmazonFeedsCore');
        $this->app->alias('AmazonFinanceCore', 'MixasikM\AmazonMws\AmazonFinanceCore');
        $this->app->alias('AmazonFinancialEventList', 'MixasikM\AmazonMws\AmazonFinancialEventList');
        $this->app->alias('AmazonFinancialGroupList', 'MixasikM\AmazonMws\AmazonFinancialGroupList');
        $this->app->alias('AmazonFulfillmentOrder', 'MixasikM\AmazonMws\AmazonFulfillmentOrder');
        $this->app->alias('AmazonFulfillmentOrderCreator', 'MixasikM\AmazonMws\AmazonFulfillmentOrderCreator');
        $this->app->alias('AmazonFulfillmentOrderList', 'MixasikM\AmazonMws\AmazonFulfillmentOrderList');
        $this->app->alias('AmazonFulfillmentPreview', 'MixasikM\AmazonMws\AmazonFulfillmentPreview');
        $this->app->alias('AmazonInboundCore', 'MixasikM\AmazonMws\AmazonInboundCore');
        $this->app->alias('AmazonInventoryCore', 'MixasikM\AmazonMws\AmazonInventoryCore');
        $this->app->alias('AmazonInventoryList', 'MixasikM\AmazonMws\AmazonInventoryList');
        $this->app->alias('AmazonOrder', 'MixasikM\AmazonMws\AmazonOrder');
        $this->app->alias('AmazonOrderCore', 'MixasikM\AmazonMws\AmazonOrderCore');
        $this->app->alias('AmazonOrderItemList', 'MixasikM\AmazonMws\AmazonOrderItemList');
        $this->app->alias('AmazonOrderList', 'MixasikM\AmazonMws\AmazonOrderList');
        $this->app->alias('AmazonOrderSet', 'MixasikM\AmazonMws\AmazonOrderSet');
        $this->app->alias('AmazonOutboundCore', 'MixasikM\AmazonMws\AmazonOutboundCore');
        $this->app->alias('AmazonPackageTracker', 'MixasikM\AmazonMws\AmazonPackageTracker');
        $this->app->alias('AmazonParticipationList', 'MixasikM\AmazonMws\AmazonParticipationList');
        $this->app->alias('AmazonProduct', 'MixasikM\AmazonMws\AmazonProduct');
        $this->app->alias('AmazonProductInfo', 'MixasikM\AmazonMws\AmazonProductInfo');
        $this->app->alias('AmazonProductList', 'MixasikM\AmazonMws\AmazonProductList');
        $this->app->alias('AmazonProductSearch', 'MixasikM\AmazonMws\AmazonProductSearch');
        $this->app->alias('AmazonProductsCore', 'MixasikM\AmazonMws\AmazonProductsCore');
        $this->app->alias('AmazonReport', 'MixasikM\AmazonMws\AmazonReport');
        $this->app->alias('AmazonReportAcknowledger', 'MixasikM\AmazonMws\AmazonReportAcknowledger');
        $this->app->alias('AmazonReportList', 'MixasikM\AmazonMws\AmazonReportList');
        $this->app->alias('AmazonReportRequest', 'MixasikM\AmazonMws\AmazonReportRequest');
        $this->app->alias('AmazonReportRequestList', 'MixasikM\AmazonMws\AmazonReportRequestList');
        $this->app->alias('AmazonReportScheduleList', 'MixasikM\AmazonMws\AmazonReportScheduleList');
        $this->app->alias('AmazonReportScheduleManager', 'MixasikM\AmazonMws\AmazonReportScheduleManager');
        $this->app->alias('AmazonReportsCore', 'MixasikM\AmazonMws\AmazonReportsCore');
        $this->app->alias('AmazonSellersCore', 'MixasikM\AmazonMws\AmazonSellersCore');
        $this->app->alias('AmazonServiceStatus', 'MixasikM\AmazonMws\AmazonServiceStatus');
        $this->app->alias('AmazonShipment', 'MixasikM\AmazonMws\AmazonShipment');
        $this->app->alias('AmazonShipmentItemList', 'MixasikM\AmazonMws\AmazonShipmentItemList');
        $this->app->alias('AmazonShipmentList', 'MixasikM\AmazonMws\AmazonShipmentList');
        $this->app->alias('AmazonShipmentPlanner', 'MixasikM\AmazonMws\AmazonShipmentPlanner');
        $this->app->alias('AmazonSubscription', 'MixasikM\AmazonMws\AmazonSubscription');
        $this->app->alias('AmazonSubscriptionCore', 'MixasikM\AmazonMws\AmazonSubscriptionCore');
        $this->app->alias('AmazonSubscriptionDestinationList', 'MixasikM\AmazonMws\AmazonSubscriptionDestinationList');
        $this->app->alias('AmazonSubscriptionList', 'MixasikM\AmazonMws\AmazonSubscriptionList');
    }

    public function boot()
    {
        $configPath = __DIR__ . '/../../config/amazon-mws.php';
        $this->publishes([$configPath => config_path('amazon-mws.php')], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

}
