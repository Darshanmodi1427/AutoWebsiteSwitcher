<?php
namespace Darsh\WebsiteSwitch\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Store\Model\StoreManager;
use Magento\Framework\App\ObjectManager;
use Magento\Customer\Model\Session as CustomerSession;

class siteSwitcher implements ObserverInterface
{

    protected $resultRedirectFactory;
    protected $_customerSession;

    public function __construct(
    ResultFactory $resultFactory, StoreManager $storeManager, CustomerSession $customerSession
    )
    {
        $this->resultFactory = $resultFactory;
        $this->storeManager = $storeManager;
        $this->_customerSession = $customerSession;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $helper = ObjectManager::getInstance()->get('Darsh\WebsiteSwitch\Helper\Data');        
        if ($helper->isEnabled()) {
            if (empty($this->_customerSession->getCurrentCountryGeoIp())) {
                $baseUrl = $this->storeManager->getStore()->getBaseUrl();
                $ipc = $helper->loadIp2Country();
                $ipAddress = $helper->getIpAddress();

                if (!$helper->checkValidIp($ipAddress)) {
                    return null;
                }

                $countryCode = $ipc->lookup($ipAddress);
                if (!empty($countryCode)) {
                    $this->_customerSession->setCurrentCountryGeoIp($countryCode);
                    switch ($countryCode) {
                        case 'GB':                            
                            $observer->getControllerAction()->getResponse()->setRedirect($baseUrl . 'uk/');
                            break;
                        case 'US':
                            $observer->getControllerAction()->getResponse()->setRedirect($baseUrl . 'usa/');
                            break;
                        case 'IN':                                                       
                            $observer->getControllerAction()->getResponse()->setRedirect($baseUrl . 'in/');                            
                            break;
                        case 'CA':
                            $observer->getControllerAction()->getResponse()->setRedirect($baseUrl . 'canada/');
                            break;
                        case 'MX':
                            $observer->getControllerAction()->getResponse()->setRedirect($baseUrl . 'mexico/');
                            break;
                        case 'EU':
                            $observer->getControllerAction()->getResponse()->setRedirect($baseUrl . 'eu/');
                            break;
                        default:
                            $observer->getControllerAction()->getResponse()->setRedirect($baseUrl);
                    }
                }
            }
        }
    }
}
