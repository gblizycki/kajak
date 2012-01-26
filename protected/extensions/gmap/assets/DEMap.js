// the semi-colon before function invocation is a safety net against concatenated 
// scripts and/or other plugins which may not be closed properly.
;
(function ( $, window, document, undefined ) {

    //define some helpers
    Array.max = function( array ){
        return Math.max.apply( Math, array );
    };
    Array.min = function( array ){
        return Math.min.apply( Math, array );
    };
    Array.subset = function(array,index)
    {
        var values = [];
        for (var element in array)
        {
            values.push(array[element][index]);
        }
        return values;
    }
    Array.bounds = function(array)
    {
        console.log(array);
        var bounds = new google.maps.LatLngBounds();
        for (var element in array)
        {
            bounds.extend(new google.maps.LatLng(array[element][0],array[element][1]));
        }
        return bounds;
        
    }
    // undefined is used here as the undefined global variable in ECMAScript 3 is
    // mutable (ie. it can be changed by someone else). undefined isn't really being
    // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
    // can no longer be modified.

    // window and document are passed through as local variables rather than globals
    // as this (slightly) quickens the resolution process and can be more efficiently
    // minified (especially when both are regularly referenced in your plugin).

    // Create the defaults once
    var pluginName = 'DEMap',
    plugin,
    defaults = {
        baseUrl: "http://localhost/kajak2",
        iconUrl: "http://localhost/kajak2/css/icons.png",
        data: {}
    };

    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;
        
        // jQuery has an extend method which merges the contents of two or 
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
        this.options = $.extend( {}, defaults, options) ;

        this._defaults = defaults;
        this._name = pluginName;
        plugin = this;
        this.init();
        this.loadData(this.options.data);
    }

    Plugin.prototype.init = function () {
        // Place initialization logic here
        // You already have access to the DOM element and the options via the instance, 
        // e.g., this.element and this.options
        $(this.element).append('<div id="DEMap-map"></div><div id="DEMap-panel"></div>');
        this.panel = $(this.element).children('#DEMap-panel');
        this.element = $(this.element).children('#DEMap-map');
        
        $(this.element).gmap3(
        {
            action : 'tilesloaded',
            callback : function(){
                $(this).removeClass('hidden');
            }
        }
        );
        $('#DEMap-panel form input,#DEMap-panel form select,#DEMap-panel form textarea').live('change',function(){
            plugin.sendFilter(this);
        });
    };
    Plugin.prototype.loadData = function (data)
    {
        $.ajax({
            url: plugin.options.baseUrl+'/js/filter',
            type: 'GET',
            //data: {type: ['Place','Route','Area']}
            dataType: 'JSON',
            data: {
                type: ['Route'],
                Route: {
                    category:'4efaf3c0b1a7882d20000000'
                    //info:{data:{hardness:'WW2'}}
                }
            },
            success: plugin.processRespons
        });
    }
    Plugin.prototype.processRespons = function(data)
    {
        //render panel
        plugin.renderPanel(data.panel);
        //add objects
        //routes
        $(plugin.element).gmap3({action: 'clear'});
        $.each(data.objects.Route,plugin.addRoute);

    }
    Plugin.prototype.renderPanel = function(data)
    {
        $(plugin.panel).html(data);
    }
    Plugin.prototype.addRoute = function(index,route)
    {
        var path = [];
        $.each(route.points,function(index){
            point = this;
            path[index] = [this.latitude,this.longitude];
            $(plugin.element).gmap3({
                action: 'addMarker',
                latLng: path[index],
                marker:{
                    options:{
                        icon:new google.maps.MarkerImage(plugin.options.iconUrl, new google.maps.Size(32, 37), new google.maps.Point((parseInt(this.order)+1)*32, 0))
                    },
                    data: point
                }
            });
        //plugin.addPoint(this);
        });
        
        $(plugin.element).gmap3(
        {
            action: 'addPolyline',
            options:{
                strokeColor: "#FF00F0",
                strokeOpacity: 1.0,
                strokeWeight: 2,
                //editable: true,
                geodesic: true
            },
            path:path,
            tag: route._id
        }/*,
        {
            'action':'fitBounds',
            'args':[Array.bounds(path)]
        }*/
        );
    }
    Plugin.prototype.sendFilter = function(element)
    {
        $.ajax({
            url: plugin.options.baseUrl+'/js/filter',
            data: $(plugin.panel).children('form').serialize(),
            dataType: 'JSON',
            success: plugin.processRespons
        });
    }
    // A really lightweight plugin wrapper around the constructor, 
    // preventing against multiple instantiations
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
            }
        });
    }

})( jQuery, window, document );