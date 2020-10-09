<?php
/**
 * Copyright © 2018 Audere Commerce Limited. All rights reserved.
 */

namespace AudereCommerce\AccountsIntegration\Api\Data;

interface AccountSearchResultsInterface
{

    /**
     * @return \AudereCommerce\AccountsIntegration\Api\Data\AccountInterface[]
     */
    public function getItems();

}