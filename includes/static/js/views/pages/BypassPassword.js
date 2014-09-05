
/**
 * BypassPasswordPageView
 * 
 * @extends View
 */
var BypassPasswordPageView = View.extend({

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
     * @return void
     */
    init: function(element) {
        this._super(element);
        this._setupForm();

        // Focus
        var input = this._element.find('input[name="email"]');
        input.focus();
    },

    /**
     * _setupForm
     * 
     * @public
     * @return void
     */
    _setupForm: function(element) {
        this._form = (new FormView(
            this._element.find('form'),
            function(response) {
                if (response.success === true) {
                    location.href = '/recover?sent';
                }
            }
        ));
    }
});
