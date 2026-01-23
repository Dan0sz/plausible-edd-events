(function (window, document) {
    'use strict';

    function onReady(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    onReady(function () {
        if (typeof window.plausible !== 'function') {
            console.warn('plausible() not available. Plausible EDD Events not loaded.');

            return;
        }

        function send(eventName, props = {}) {
            window.plausible(eventName, {props});
        }

        const PlausibleEDDEvents = {
            state: {
                contactCompleted: false,
                paymentMethodSelected: false,
                addressCompleted: false,
                termsAccepted: false,
                purchaseClicked: false
            },

            hasValue(selector) {
                const el = document.querySelector(selector);

                return !!(el && el.value && el.value.trim() !== '');
            },

            evaluateContact() {
                if (this.state.contactCompleted) return;

                if (
                    this.hasValue('#edd-email') &&
                    this.hasValue('#edd-first') &&
                    this.hasValue('#edd-last')
                ) {
                    this.state.contactCompleted = true;

                    send('Entered Contact Information');
                }
            },

            evaluateAddress() {
                if (this.state.addressCompleted) return;

                if (
                    this.hasValue('#card_address') &&
                    this.hasValue('#card_city') &&
                    this.hasValue('#card_zip') &&
                    this.hasValue('#billing_country')
                ) {
                    this.state.addressCompleted = true;

                    send('Entered Address Information');
                }
            },

            handleFocusOut(event) {
                const id = event.target.id;

                if (id === 'edd-email' || id === 'edd-first' || id === 'edd-last') {
                    this.evaluateContact();
                }

                if (
                    id === 'card_address' ||
                    id === 'card_city' ||
                    id === 'card_zip' ||
                    id === 'billing_country'
                ) {
                    this.evaluateAddress();
                }
            },

            handleChange(event) {
                const el = event.target;

                if (
                    el.name === 'payment-mode' &&
                    !this.state.paymentMethodSelected
                ) {
                    this.state.paymentMethodSelected = true;

                    send('Selected Payment Method', {method: el.value});
                }

                if (
                    el.id === 'edd_agree_to_terms' &&
                    el.checked &&
                    !this.state.termsAccepted
                ) {
                    this.state.termsAccepted = true;

                    send('Accepted Terms & Conditions');
                }
            },

            handleClick(event) {
                const el = event.target;

                if (
                    el.id === 'edd-purchase-button' &&
                    !this.state.purchaseClicked
                ) {
                    this.state.purchaseClicked = true;

                    send('Clicked Complete Purchase');
                }
            },

            init() {
                const form = document.querySelector('#edd_purchase_form');

                if (!form) {
                    console.warn('#edd_purchase_form not found. Plausible EDD Events not loaded.');
                    return;
                }

                form.addEventListener('focusout', e => this.handleFocusOut(e));
                form.addEventListener('change', e => this.handleChange(e));
                form.addEventListener('click', e => this.handleClick(e));
            }
        };

        // Expose for debugging
        window.PlausibleEDDEvents = PlausibleEDDEvents;

        PlausibleEDDEvents.init();
    });

})(window, document);
