<?php
namespace Vikhyat\Website\Block;

use Magento\Store\Model\ScopeInterface;

class SwitchWebsite extends \Magento\Framework\View\Element\Template
{
	/**
	 * @var \Magento\Framework\App\Request\Http
	 */	
	protected $_request;
	
	/**
     * @var \Vikhyat\Website\Helper\Data
     */
    protected $_helper;
	
	/**
     * @var \Magento\Framework\View\Asset\Repository $assetRepo
     */
	protected $_assetRepo;
	
	/**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
	protected $_storeManager;
	
	/**
     * @var \Magento\Framework\Data\Helper\PostHelper
     */
    protected $_postDataHelper;

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Magento\Framework\App\Request\Http
     * @param \Vikhyat\Website\Helper\Data
     * @param \Magento\Framework\View\Asset\Repository
     * @param \Magento\Store\Model\StoreManagerInterface
     * @param \Magento\Framework\Data\Helper\PostHelper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\App\Request\Http $request,
        \Vikhyat\Website\Helper\Data $helper,
		\Magento\Framework\View\Asset\Repository $assetRepo,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Framework\Data\Helper\PostHelper $postDataHelper,
        array $data = []
    ) {
        
		$this->_helper = $helper;
		$this->_request = $request;
		$this->_assetRepo = $assetRepo;
		$this->_storeManager = $storeManager;
		$this->_postDataHelper = $postDataHelper;
        
		parent::__construct($context, $data);
    }
	
	/**
     * @return int|null|string
     */
    public function getCurrentWebsiteId()
    {
        return $this->_storeManager->getStore()->getWebsiteId();
    }
	
	/**
     * @return string
     */
    public function getCurrentWebsiteCode()
    {
        return $this->_storeManager->getStore()->getWebsiteCode();
    }

    /**
     * @return int
     */
    public function getCurrentStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }
	
	/**
     * @return array
     */
	public function getWebsites() {
		return $this->_storeManager->getWebsites();
	}
	
	/**
     * @return string
     */
	public function getWebsite($websiteId) {
		return $this->_storeManager->getWebsite($websiteId);
	}
	
	/**
     * @return string
     */
	public function getWebsiteUrlById($websiteId = 1) {
		return $this->_storeManager->getWebsite($websiteId)->getDefaultStore()->getBaseUrl();
	}
	
	/**
     * @return null|string
     */
	public function getCountryCodeByWebsiteCode($websiteCode) {
		$countryCodes = [
			'base'          => 'SG',
			'Website_uk' => 'UK',
			'Website_hk' => 'HK'
		];
		
		if(isset($countryCodes[$websiteCode]) && !empty($countryCodes[$websiteCode])) {
			return $countryCodes[$websiteCode];
		}
		
		return;
	}
	
	/**
     * @return null|string
     */
	public function getCountryByWebsiteCode($websiteCode) {
		$countries = [
			'SG' => __('Singapore'),
			'UK' => __('United Kingdom'),
			'HK' => __('Hong Kong')
		];
		
		if(isset($countries[$websiteCode]) && !empty($countries[$websiteCode])) {
			return $countries[$websiteCode];
		}
		
		return;
	}
	
	/**
     * @return null|string
     */
	public function getCountryFlagUrlByCode($countryCode) {
		 return $this->_assetRepo->getUrl('Vikhyat_Website::images/flags/'.$countryCode.'.png');
	}
}