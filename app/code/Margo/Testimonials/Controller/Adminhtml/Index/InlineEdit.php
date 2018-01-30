<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 07.11.17
 * Time: 16:27
 */

namespace Margo\Testimonials\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Margo\Testimonials\Model\TestimonialsFactory;
use Magento\Backend\App\Action\Context;

class InlineEdit extends Action
{
    /**
     * JSON Factory
     *
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_jsonFactory;

    /**
     * Post Factory
     *
     * @var \Margo\Testimonials\Model\Resource\TestimonialsFactory
     */
    protected $_postFactory;

    /**
     * constructor
     *
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Margo\Testimonials\Model\TestimonialsFactory $postFactory
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        JsonFactory $jsonFactory,
        TestimonialsFactory $postFactory,
        Context $context
    ){
        $this->_jsonFactory = $jsonFactory;
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->_jsonFactory->create();
        $error = false;
        $messages = [];
        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        foreach (array_keys($postItems) as $postId) {
            /** @var \Margo\Testimonials\Model\Testimonials $post */
            $post = $this->_postFactory->create()->load($postId);
            try {
                $postData = $postItems[$postId];//todo: handle dates
                $post->addData($postData);
                $post->save();
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithPostId($post, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithPostId($post, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithPostId(
                    $post,
                    __('Something went wrong while saving the Post.')
                );
                $error = true;
            }
        }
        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * Add Post id to error message
     *
     * @param \Margo\Testimonials\Model\Testimonials $post
     * @param string $errorText
     * @return string
     */
    protected function getErrorWithPostId(\Margo\Testimonials\Model\Testimonials $post, $errorText)
    {
        return '[ID: ' . $post->getId() . '] ' . $errorText;
    }
}