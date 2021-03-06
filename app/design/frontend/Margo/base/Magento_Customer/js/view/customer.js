/**
* Copyright © 2013-2017 Magento, Inc. All rights reserved.
* See COPYING.txt for license details.
*/
define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (Component, customerData) {
    'use strict';

    return Component.extend({
        initialize: function () {
            setTimeout(function () {
                this._super();

                this.customer = customerData.get('customer');
            }, 5000);
        }
    });
    alert('111');
});