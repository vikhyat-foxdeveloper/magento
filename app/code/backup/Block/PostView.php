<?php

/**
 * @copyright  Copyright (c) 2021 Jhkinfotech  (https://jhkinfotech.com/)
 */

namespace Jhkinfotech\Ticket\Block;

class PostView extends \Magento\Framework\View\Element\Template implements
    \Magento\Framework\DataObject\IdentityInterface
{

    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Jhkinfotech\Ticket\Model\Post $post
     * @param \Jhkinfotech\Ticket\Model\PostFactory $postFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Jhkinfotech\Ticket\Model\Post $post,
        \Jhkinfotech\Ticket\Model\PostFactory $postFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_post = $post;
        $this->_postFactory = $postFactory;
    }

    /**
     * @return \Jhkinfotech\Ticket\Model\Post
     */
    public function getPost()
    {
        // Check if posts has already been defined
        // makes our block nice and re-usable! We could
        // pass the 'posts' data to this block, with a collection
        // that has been filtered differently!
        if (!$this->hasData('post')) {
            if ($this->getPostId()) {
                /** @var \Jhkinfotech\Ticket\Model\Post $page */
                $post = $this->_postFactory->create();
            } else {
                $post = $this->_post;
            }
       
            $this->setData('post', $post);
        }
        return $this->getData('post');
    }

    /**
     * Return identifiers for produced content
     *
     * @return array
     */
    public function getIdentities()
    {
        return [\Jhkinfotech\Ticket\Model\Post::CACHE_TAG . '_' . $this->getPost()->getId()];
    }
}
