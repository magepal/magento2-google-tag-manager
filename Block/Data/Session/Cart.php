<?php
/**
 * Blocks feeding datalayer
 *
 * @category  MagePal
 * @package   MagePal\GoogleTagManager
 * @author    Pascal Noisette <netpascal0123@aol.com>
 * @copyright 2017
 */
namespace MagePal\GoogleTagManager\Block\Data\Session;


/**
 * Block : Customer for all page
 *
 * @package MagePal\GoogleTagManager
 * @class   Customer
 */
class Cart extends \MagePal\GoogleTagManager\Block\Data\Session
{

    /**
     * Get active quote
     *
     * @return Quote
     */
    public function getQuote()
    {
        return $this->checkoutSession->getQuote();
    }

    /**
     * Add product data to datalayer
     *
     * @return $this
     */
    function _prepareLayout()
    {
        /** @var $tm \MagePal\GoogleTagManager\Block\Tm */
        $tm = $this->getParentBlock();

        if ($this->pageIsCachable()) {
            $tm->addVariable('cart', ['hasItems'=>false]);
        } else {
            $quote = $this->getQuote();
            $cart = [];
            
            $cart['hasItems'] = false;
    
            if ($quote->getItemsCount()) {
                $items = [];
                // set items
                foreach($quote->getAllVisibleItems() as $item){
                    $items[] = [
                        'sku' => $item->getSku(),
                        'name' => $item->getName(),
                        'price' => $item->getPrice(),
                        'quantity' => $item->getQty(),
                    ];
                }
                
                if(count($items) > 0){
                    $cart['hasItems'] = true;
                    $cart['items'] = $items; 
                }
                
                $cart['total'] = $quote->getGrandTotal();
                $cart['itemCount'] = $quote->getItemsCount();
                
                //set coupon code
                $coupon = $quote->getCouponCode();
                
                $cart['hasCoupons'] = $coupon ? true : false;
    
                if($coupon){
                    $cart['couponCode'] = $coupon;
                }
            }
        
            $tm->addVariable('cart', $cart);
        }
    }

    /**
     * Format Price
     *
     * @return float
     */
    public function formatPrice($price){
        return sprintf('%.2F', $price);
    }
}
