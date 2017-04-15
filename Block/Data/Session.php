<?php
/**
 * Blocks feeding datalayer
 *
 * @category  MagePal
 * @package   MagePal\GoogleTagManager
 * @author    Pascal Noisette <netpascal0123@aol.com>
 * @copyright 2017
 */
namespace MagePal\GoogleTagManager\Block\Data;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterfaceFactory;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ViewInterface;
use Magento\Framework\Module\Manager as ModuleManager;
use Magento\Framework\View\LayoutInterface;

/**
 * Block : session for all page
 *
 * @package MagePal\GoogleTagManager
 * @class   Customer
 */
abstract class Session extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $checkoutSession;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var \Magento\Framework\View\LayoutInterface
     */
    protected $layout;

    /**
     * @var \Magento\Customer\Api\Data\CustomerInterfaceFactory
     */
    protected $customerFactory;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Framework\Module\Manager
     */
    protected $moduleManager;

    /**
     * @var \Magento\Framework\App\ViewInterface
     */
    protected $view;
    

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param\Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer
     * @param array $data
     *
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CustomerSession $customerSession,
        CheckoutSession $checkoutSession,
        LayoutInterface $layout,
        CustomerInterfaceFactory $customerFactory,
        CustomerRepositoryInterface $customerRepository,
        RequestInterface $request,
        ModuleManager $moduleManager,
        ViewInterface $view,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
        $this->layout = $layout;
        $this->customerFactory = $customerFactory;
        $this->customerRepository = $customerRepository;
        $this->request = $request;
        $this->moduleManager = $moduleManager;
        $this->view = $view;
        parent::__construct($context, $data);
    }
    
    /**
     * Check if page is cachable
     * 
     * @return bool
     */
    protected function pageIsCachable()
    {
        return $this->moduleManager->isEnabled('Magento_PageCache')
            && !$this->request->isAjax()
            && $this->view->isLayoutLoaded()
            && $this->layout->isCacheable();
    }
}
