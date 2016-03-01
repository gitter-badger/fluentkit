import mdl from 'material-design-lite/material'

class Dropdown{

    constructor(element){

        this.CssClasses_ = {
            DROPDOWN_IS_ACTIVE: 'dropdown-is-active'
        };

        this.element_ = element;
        this.init();
    }

    init() {
        this.boundClickHandler = this.clickHandler.bind(this);
        this.element_.addEventListener('click', this.boundClickHandler);
    }

    clickHandler(event) {
        event.preventDefault();
        var target = event.target;
        if( ! target.classList.contains(this.CssClasses_.DROPDOWN_IS_ACTIVE)){

            target.classList.add(this.CssClasses_.DROPDOWN_IS_ACTIVE);
            target.nextElementSibling.classList.add(this.CssClasses_.DROPDOWN_IS_ACTIVE);

        } else {
            target.nextElementSibling.classList.remove(this.CssClasses_.DROPDOWN_IS_ACTIVE);
            target.classList.remove(this.CssClasses_.DROPDOWN_IS_ACTIVE);
        }
    }

    mdlDowngrade_() {
        this.element_.removeEventListener('click', this.boundClickHandler);
    }
}

mdl.componentHandler.register({
    constructor: Dropdown,
    classAsString: 'Dropdown',
    cssClass: 'js-dropdown'
});
mdl.componentHandler.upgradeDom();

export default Dropdown