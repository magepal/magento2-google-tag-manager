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


/**
 * Block : Category for catalog category view page
 *
 * @package MagePal\GoogleTagManager
 * @class   Category
 */
class Category extends \Magento\Framework\View\Element\Template
{
    
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve current category model object
     *
     * @return \Magento\Catalog\Model\Category
     */
    public function getCurrentCategory()
    {
        if (!$this->hasData('current_category')) {
            $this->setData('current_category', $this->_coreRegistry->registry('current_category'));
        }
        return $this->getData('current_category');
    }

    /**
     * Add category data to datalayer
     *
     * @return $this
     */
    function _prepareLayout()
    {
        /** @var $tm \MagePal\GoogleTagManager\Block\Tm */
        $tm = $this->getParentBlock();

        /** @var $product \Magento\Catalog\Api\Data\ProductInterface */ 
        $category = $this->getCurrentCategory();

        $tm->addVariable(
            'list', 
            'category'
        );

        $tm->addVariable(
            'category', 
            [
                'id' => $category->getId(),
                'name' => $category->getName()
            ]
        );
    }
}
