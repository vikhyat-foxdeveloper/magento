<?php 

namespace Jhkinfotech\Ticket\Controller\Index;
 
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;

class Download extends \Magento\Framework\App\Action\Action 
{
	/**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;
    /**
     * @param \Magento\Framework\App\Action\Context            $context
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory
    ) {
        $this->fileFactory = $fileFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $urlInterface = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\UrlInterface');
        $curenturl = $urlInterface->getCurrentUrl();        
        $url_data = parse_url($curenturl);
        parse_str($url_data['query'], $params); 
        $params['imgpath'];
        $params['filename'];
        $imgpath_img = $params['imgpath'].$params['filename'];
        sleep(2);
        $filePath = 'media/'.$imgpath_img;        
        $downloadName = $params['filename'];
        $content['type'] = 'filename';
        $content['value'] = $filePath;
        $content['rm'] = 0;
        return $this->fileFactory->create($downloadName, $content, DirectoryList::PUB);
    }
 
}