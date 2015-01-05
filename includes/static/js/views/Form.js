
/**
 * FormView
 * 
 * @extends View
 */
var FormView = View.extend({

    /**
     * _callback
     * 
     * @protected
     * @var       Function (default: null)
     */
    _callback: null,

    /**
     * _enabled
     * 
     * @protected
     * @var       Boolean (default: true)
     */
    _enabled: true,

    /**
     * init
     * 
     * @public
     * @param  jQuery element
     * @param  Function callback
     * @return void
     */
    init: function(element, callback) {
        this._super(element);
        this._callback = callback;
        this._addFormEvents();
        if (typeof $.fn.serializeObject === 'undefined') {
            this._addSerializeFunction();
        }
    },

    /**
     * _addSerializeFunction
     * 
     * @protected
     * @return    void
     */
    _addSerializeFunction: function() {

        /**
         * Add element serialization method
         * 
         * @see http://stackoverflow.com/questions/1184624/convert-form-data-to-js-object-with-jquery
         */
        $.fn.serializeObject = function() {
            var o = {};
            var a = this.serializeArray();
            $.each(
                a,
                function() {
                    if (o[this.name] !== undefined) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                }
            );
            return o;
        };
    },

    /**
     * _addFormEvents
     * 
     * @protected
     * @return    void
     */
    _addFormEvents: function() {

        // Scope
        var _this = this;

        // Inputs
        this._element.find('input').keypress(
            function(event) {
                if (event.which === 13) {
                    event.preventDefault();
                    _this._submit();
                }
            }
        );

        // Submit buttons
        this._element.find('*[data-submit="true"]').click(
            function(event) {
                event.preventDefault();
                _this._submit();
            }
        );

        // Submission
        this._element.submit(
            function(event) {
                event.preventDefault();
                _this._submit();
            }
        );
    },

    /**
     * _submit
     * 
     * @protected
     * @return    void
     */
    _submit: function() {
        if (this._enabled === true) {
            this.disable();

            // Submission
            var _this = this,
                callback = function() {

                    // UI updates
                    _this.clearSuccess();
                    _this.clearErrors();

                    // Post it
                    var method = _this._element.attr('method');
                    jQuery[method](
                        _this._element.attr('action'),
                        _this._element.serializeObject(),
                        jQuery.proxy(_this._submitCallback, _this),
                        'json'
                    ).fail(function() {
                        window['log'] && log('Failed submitting');
                    });
                };

            // Let's do this
            callback();
        }
    },

    /**
     * _handleError
     * 
     * @protected
     * @param     Object error
     * @return    void
     */
    _handleError: function(error) {

        // Add error class
        var input = error.input;
        if (typeof error.input === 'string') {
            input = this._element.find('input[name="' + (error.input) + '"]');
        }
        input.addClass('error');

        // Show the error message
        var calloutElement = this._element.find('.callout.errors');
        calloutElement.find('p').html(error.message);
        calloutElement.removeClass('hidden');

        // Focus on the input
        input.focus();
    },

    /**
     * _submitCallback
     * 
     * @protected
     * @param     Object response
     * @return    void
     */
    _submitCallback: function(response) {
        var _this = this;
        setTimeout(
            function() {
                if (response.success === false) {
                    var error = response.failedRules[0].error;
                    _this.enable();

                    // Error is with a specific input
                    if (error.input) {
                        _this._handleError(error);
                    }
                    else {
                        var defaultMessage = 'Please refresh and try again',
                            selector = 'input[type="email"],' +
                                'input[type="text"],' +
                                'input[type="password"]';
                        _this._handleError({
                            message: error.message || defaultMessage,
                            input: _this._element.find(selector).first()
                        });
                    }
                } else {
                    _this._callback(response);
                }
            },
            2500
        );
    },

    /**
     * clearErrors
     * 
     * @public
     * @return void
     */
    clearErrors: function() {
        this._element.find('input.error').removeClass('error');
        this._element.find('div.callout.errors').addClass('hidden');
    },

    /**
     * clearSuccess
     * 
     * @public
     * @return void
     */
    clearSuccess: function() {
        this._element.find('div.callout.success').addClass('hidden');
    },

    /**
     * disable
     * 
     * @public
     * @return void
     */
    disable: function() {
        this._element.addClass('loading');
        this._enabled = false;
        var selector = 'input[type="password"], ' +
            'input[type="email"], ' +
            'select, ' +
            'input[type="text"]';
        this._element.find(selector).blur();
        this._element.find(selector).attr('readonly', true);
    },

    /**
     * enable
     * 
     * @public
     * @return void
     */
    enable: function() {
        this._element.removeClass('loading');
        this._enabled = true;
        var selector = 'input[type="password"], ' +
            'input[type="email"], ' +
            'select, ' +
            'input[type="text"]';
        this._element.find(selector).attr('readonly', false);
    },

    /**
     * isEnabled
     * 
     * @public
     * @return Boolean
     */
    isEnabled: function() {
        return this._enabled === true;
    }
});
