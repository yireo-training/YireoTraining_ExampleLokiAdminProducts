<?php declare(strict_types=1);

namespace YireoTraining\ExampleLokiAdminProducts\Options;

use GuzzleHttp\Client;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class DurationUnitOptions implements ArgumentInterface, OptionSourceInterface
{
    public function toOptionArray()
    {
        $options = [];

        $options[] = [
            'value' => 'M',
            'label' => 'Month',
        ];


        $options[] = [
            'value' => 'Y',
            'label' => 'Year',
        ];

        return $options;
    }
}
