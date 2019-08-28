/**
 * Every piece of UI that requires javascript should have its own
 * javascript file. Use this file as a template for structuring
 * all JS source files.
 *
 * {Title}
 *
 * {Description}
 */


var MyClass = function(el){
    this.init();
};

MyClass.prototype.init = function(){
    // do something
};

$(document).ready(function(){
    $('.My-class').each(function(){
        new MyClass(this);
    });

});



/**
 * Every piece of UI that requires javascript should have its own
 * javascript file. Use this file as a template for structuring
 * all JS source files.
 *
 * {Title}
 * 
 * {Description}
 */

( function( window, $ ) {
	'use strict';
	var document = window.document;

    var MyClass = function(el){
        this.init();
    };

    MyClass.prototype.init = function(){
        // do something
    };

    $(document).ready(function(){
        $('.My-class').each(function(){
            new MyClass(this);
        });

    });

} )( window, jQuery );

/**
 * Every piece of UI that requires javascript should have its own
 * javascript file. Use this file as a template for structuring
 * all JS source files.
 *
 * {Title}
 *
 * {Description}
 */

var _Class = (function () {

    var proto = {};

    proto.stuff = function(){

    };

    return proto;
}());



/**
 * Every piece of UI that requires javascript should have its own
 * javascript file. Use this file as a template for structuring
 * all JS source files.
 *
 * {Title}
 * 
 * {Description}
 */
    (function (window, $ ) {

        var NewClass = function NewClass(el) {
            //ser the $el variable
            this.$el = $(el);

            this.init();


        };

        //Place initializer events and event handlers here
        NewClass.prototype.init = function () {
            //load all the modules
            this.DOM        = this.DOMObj();
            this.model      = this.modelObj();
            this.CB         = this.CB_Obj();
            this.setup      = this.setUpObj();
            
            //events
            //element.on('click', this._clickHandler.bind(this));

        };

        //if we need to save any data
        NewClass.prototype.modelObj = function () {
            return {

            };

        };

        // //object with access to cached DOM elements
        NewClass.prototype.DOMObj = function () {

            //return the DOM elements in an object
            return {

            };
        };

        //these are callback functions for events in the init
        NewClass.prototype.CB_Obj = function () {

            return {

            };


        };

        //helpers are useful bits for processing data
        NewClass.prototype.setUpObj = function () {
            return {

            };
        };



        $('.class').each(function () {
            new NewClass(this);
        });
    })(this, jQuery);



((window, $ ) => {
    var MyClass = function( el ){

        //global variables

        this.$el = $(el);

        this.init = function(){


        };

        this.DOM = {


        };

        this.events = {



        };

        this.helpers = {

        };

        //this.init();

    };

    $(document).ready(function(){
        $('.papahello').each(function(){
            var instance = new MyClass(this);
            instance.init();
        });
    });


})( window, jQuery );