/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * Please visit Magefan.com for license details (https://magefan.com/end-user-license-agreement).
 */

define([
    'Magento_Ui/js/grid/columns/select'
], function (Column) {
    'use strict';

    return Column.extend({
        getLabel: function (record) {
            var status = this._super(record);

            if (status !== '') {
                return '<span class="tooltip-severity ' + record.status + '"><span>' + status + '</span></span>';
            }

            return status;
        }
    });
});
