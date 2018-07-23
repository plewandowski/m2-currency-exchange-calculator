define([
    'jquery',
    'mage/translate',
    'mage/storage',
    'Magento_Ui/js/modal/alert'
], function ($, $t, storage, alert) {
    'use strict';

    $.widget('mage.currencyExchangeCalculator', {

        _create: function () {
            this.config = {
                currencyCode: this.options.currencyCode || 'EUR'
            };

            this.element = $(this.element);

            this.actionButton = this.element.find('[data-action="calculate"]');
            this.inputField = this.element.find('[data-type="amount"]');
            this.resultField = this.element.find('[data-type="result"]');
            this.rateInfo = this.element.find('[data-type="rate"]');

            this.initObservers();

        },

        initObservers: function () {
            this.inputField.on('keyup', $.proxy(this.sanitizeInput, this));

            this.actionButton.click($.proxy(function (e) {
                e.preventDefault();

                if (!this.element.valid()) {
                    return false;
                }

                this.calculate();
            }, this));
        },

        sanitizeInput: function () {
            var value = this.inputField.val();
            value = value.replace(/,/, '.');
            value = value.replace(/[^0-9.]+/, '');

            this.inputField.val(value);
        },

        calculate: function () {
            if (this.rate) {
                this.displayResults();
                return;
            }

            this.toggleLoader(true);

            storage.get(this.getServiceUrl())
                .done($.proxy(function (response) {
                    this.toggleLoader(false);
                    this.updateRate(parseFloat(response.rate));
                    this.displayResults();

                }, this))
                .fail($.proxy(function (response) {
                    this.toggleLoader(false);
                    alert({
                        title: $t('Ooops!'),
                        content: $t('There was error during calculation :-(. Please try again later')
                    });
                }, this));
        },

        updateRate: function (rate) {
            this.rate = rate;
            this.rateInfo.html(
                $t('1 %1 converts to %2 PLN')
                    .replace('%1', this.config.currencyCode)
                    .replace('%2', this.rate)
            );
        },

        getInputAmount: function () {
            return parseFloat(this.inputField.val());
        },

        displayResults: function () {
            var result = this.getInputAmount() * this.rate;
            this.resultField.val(result.toFixed(2));
        },

        getServiceUrl: function () {
            return 'rest/V1/exchangeRate/__currencyCode__'.replace(/__currencyCode__/, this.config.currencyCode);
        },

        toggleLoader: function (displayState) {
            if (displayState === true) {
                this.element.addClass('loading');
            } else {
                this.element.removeClass('loading');
            }
        }
    });

    return $.mage.currencyExchangeCalculator;
});