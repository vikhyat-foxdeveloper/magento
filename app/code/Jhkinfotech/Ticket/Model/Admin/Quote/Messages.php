<?php
 
namespace Jhkinfotech\Ticket\Model\Admin\Quote;
 
use Magento\Security\Model\ResourceModel\AdminSessionInfo\Collection;
use Magento\Backend\Model\UrlInterface;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Notification\MessageInterface;
use Magento\Framework\Controller\ResultFactory;

class Messages implements MessageInterface
{
    
    protected $urlBuilder;
    private $adminSessionInfoCollection;
    protected $authSession;
    protected $_scopeConfig;
 
    public function __construct(
        Collection $adminSessionInfoCollection,
        \Magento\Framework\UrlInterface $urlBuilder,
        Session $authSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->authSession = $authSession;
        $this->urlBuilder = $urlBuilder;
        $this->adminSessionInfoCollection = $adminSessionInfoCollection;
        $this->_scopeConfig = $scopeConfig;
    }
 
    public function getText()
    {
        $url = $this->urlBuilder->getUrl('admin/system_config/index');
     //@codingStandardsIgnoreStart		
     $arro = "\u{2192}";
     $space = "&nbsp";
     return __('<strong>Warning!</strong> Support Ticket Configuration <v style="color: red">"Admin Notification Email"</v> field is required. %2 Step 1 %1 JHK, %2 Step 2 %1 Settings, %2 Step 3 %1 check field "Admin Notification Email"',$arro,$space);
	
	}
	public function getIdentity()
	{        
        return 'identity';
	}
	public function isDisplayed()
	{		
        $admin_email = $this->_scopeConfig ->getValue('ticket/general/admin_email', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        if($admin_email == ''){
         return true;
              }
        return false;
	}
            	public function getSeverity()
            	{
    // From here you can change notification message type.
    	return \Magento\Framework\Notification\MessageInterface::SEVERITY_CRITICAL;
	}
}
