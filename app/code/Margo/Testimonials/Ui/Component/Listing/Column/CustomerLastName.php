<?php
/**
 * Created by PhpStorm.
 * User: michael
 * Date: 20.12.17
 * Time: 18:47
 */

namespace Margo\Testimonials\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\Escaper;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Customer\Model\Customer;

class CustomerLastName extends Column
{
    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * CustomerLastName constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Customer $customer
     * @param Escaper $escaper
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Customer $customer,
        Escaper $escaper,
        array $components = [],
        array $data = []
    ) {
        $this->escaper = $escaper;
        $this->customer = $customer;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        // Перевіряєм чи є елементи в масиві
        if (isset($dataSource['data']['items'])) { // Якщо умова вірна
            // Пероходимось по всім елементам в масиві і вибираємо їх по ссилці
            foreach ($dataSource['data']['items'] as & $item) {
                // Ініціалізуємо змінну $customer і приєднюємо їй екземпляр моделі customer з загрузкою катомера по ID
                $customer = $this->customer->load($item['customer_id']);
                // По ссилці в массив $item і його елемент добавляємо дані
                $item[$this->getData('name')] =
                    // З обєкту $customer витягуємо дані по ключу lastname
                    $this->escaper->escapeHtml($customer->getData('lastname'));

            }
        }

        return $dataSource;
    }
}