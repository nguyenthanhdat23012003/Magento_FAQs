<?php

namespace Bss\FAQs\Controller\Adminhtml\Categories;

use Bss\FAQs\Model\Category\DataExampleFactory;
use Bss\FAQs\Model\Category\ResourceModel\DataExample;
use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;


/**
 * class Save
 */
class Save extends Action
{

    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Bss_FAQs::Category_save';

    /**
     * @var PostDataProcessor
     */
    protected PostDataProcessor $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected DataPersistorInterface $dataPersistor;

    /**
     * @var DataExampleFactory
     */
    protected DataExampleFactory $categoryFactory;

    /**
     * @var DataExample
     */
    protected DataExample $categoryResource;

    /**
     * @param Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param DataExampleFactory $categoryFactory
     * @param DataExample $categoryResource
     */
    public function __construct(
        Action\Context         $context,
        PostDataProcessor      $dataProcessor,
        DataPersistorInterface $dataPersistor,
        DataExampleFactory     $categoryFactory,
        DataExample            $categoryResource,
    )
    {
        $this->categoryResource = $categoryResource;
        $this->categoryFactory = $categoryFactory;
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed($this::ADMIN_RESOURCE);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getParam('general');

        if ($data) {
            // Optimize data
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = \Bss\FAQs\Model\Category\DataExample::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }
            if (empty($data['icons'])) {
                $data['icons'] = null;
            } else {
                if ($data['icons'][0] && $data['icons'][0]['name']) {
                    $data['icon'] = $data['icons'][0]['name'];
                } else {
                    $data['icon'] = null;
                }
            }

            // Init model and load by ID if exists
            $model = $this->categoryFactory->create();
            $id = $data['id'];
            if ($id) {
                $this->categoryResource->load($model, $id);
            }

            // Validate data
            if (!$this->dataProcessor->validateRequireEntry($data)) {
                // Redirect to Edit page if has error
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
            }

            // Update model
            $model->setStatus($data['status']);
            $model->setTitle($data['title']);
            if ($model->getIcon() == $data['icon']) {
                $model['upLoad'] = false;
            } else {
                $model->setIcon($data['icon']);
                $model['upLoad'] = true;
            }

            // Save data to database
            try {
                $this->categoryResource->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the FAQs Category.'));
                $this->dataPersistor->clear('bss_faq_categories');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the image.'));
            }

            $this->dataPersistor->set('bss_faq_categories', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        // Redirect to List page
        return $resultRedirect->setPath('*/*/');
    }
}
