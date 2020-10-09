<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\KamarinEcommerceLink\Api\Upload;

use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\VatRateInterface;
use AudereCommerce\KamarinEcommerceLink\Api\Data\Upload\VatRateSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;

interface VatRateRepositoryInterface
{
    /**
     * @param VatRateInterface $vatRate
     * @return VatRateInterface
     */
    public function save(VatRateInterface $vatRate);
    
    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return VatRateSearchResultsInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);    
}
