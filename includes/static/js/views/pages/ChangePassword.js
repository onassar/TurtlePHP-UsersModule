
/**
 * ChangePasswordPageView
 * 
 * @extends View
 */
var ChangePasswordPageView = View.extend({

    /**
     * _callback
     * 
     * @protected
     * @var       Function
     */
    _callback: function(response) {
        if (response.success === true) {
            location.href = (location.pathname) + '?saved';
        }
    },

    /**
     * _form
     * 
     * @protected
     * @var       FormView (default: null)
     */
    _form: null,

    /**
     * init
     * 
     * @public
     * @param  jQuery element
     * @param  Function|undefined callback
     * @return void
     */
    init: function(element, callback) {
        this._super(element);
        this._callback = callback || this._callback;
        this._setupForm();

        // Focus
        var input = this._element.find('input[name="password"]');
        input.focus();
    },

    /**
     * _setupForm
     * 
     * @public
     * @return void
     */
    _setupForm: function(element) {
        var _this = this;
        this._form = (new FormView(
            this._element.find('form'),
            function(response) {
                _this._callback(response);
            }
        ));
    }
});
