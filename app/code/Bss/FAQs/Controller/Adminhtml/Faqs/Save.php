<?php

namespace Bss\FAQs\Controller\Adminhtml\Faqs;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Bss\FAQs\Model\FAQs\DataExampleFactory;
use Bss\FAQs\Model\FAQs\ResourceModel\DataExample;


/**
 * Class Save
 */
class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Bss_FAQs::save';

    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var DataExampleFactory
     */
    protected $faqFactory;

    /**
     * @var DataExample
     */
    protected $faqResource;

    /**
     * @param Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param DataExampleFactory $faqFactory
     * @param DataExample $faqResource
     */
    public function __construct(
        Action\Context         $context,
        PostDataProcessor      $dataProcessor,
        DataPersistorInterface $dataPersistor,
        DataExampleFactory $faqFactory,
        DataExample $faqResource,
    ) {
        $this->faqResource = $faqResource;
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        $this->faqFactory = $faqFactory;

        parent::__construct($context);
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
                $data['status'] = \Bss\FAQs\Model\FAQs\DataExample::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }
            if (empty($data['viewed'])) {
                $data['viewed'] = 0;
            }
            if (empty($data['liked'])) {
                $data['liked'] = 0;
            }
            if (empty($data['disliked'])) {
                $data['disliked'] = 0;
            }
            if (empty($data['created_by'])) {
                $data['created_by'] = 'Admin';
            }
            if (empty($data['created'])) {
                $data['created'] = date("Y-m-d H:i:s");
            }
            if (empty($data['modified'])) {
                $data['modified'] = $data['created'];
            } else {
                $data['modified'] = date("Y-m-d H:i:s");
            }
            // Init model and load by ID if exists;
            $model = $this->faqFactory->create();
            $id = $data['id'];
            if ($id) {
                $this->faqResource->load($model, $id);
            }


            // Validate data
            if (!$this->dataProcessor->validateRequireEntry($data)) {
                // Redirect to Edit page if has error
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
            }

            // Update model
            $model->setData($data);

            // Save data to database
            try {
                $this->faqResource->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the FAQs Category.'));
                $this->dataPersistor->clear('bss_faq');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the image.'));
            }

            $this->dataPersistor->set('bss_faq', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }

        // Redirect to List page
        return $resultRedirect->setPath('*/*/');
    }
}
