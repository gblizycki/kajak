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
        data: {},
        routeLod: 11
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
        this.container = this.element;
        this.panel = $(this.element).children('#DEMap-panel');
        this.element = $(this.element).children('#DEMap-map');
        $(this.element).gmap3(
        {
            action: 'init',
            events: {
                zoom_changed: plugin.map.zoomChanged
            }
        }
        );
        $(this.element).gmap3(
        {
            action : 'tilesloaded',
            callback : function(){
                $(this).removeClass('hidden');
            }
        }
        );
        $('#DEMap-panel form input,#DEMap-panel form select,#DEMap-panel form textarea').live('change',function(){plugin.request.send();});
        $('#DEMap-panel form').live('submit',function(){return false});
        $('#DEMap-panel .back-button').live('click',plugin.request.back);
    };
    Plugin.prototype.loadData = function (data)
    {
        plugin.request.start();
        $.ajax({
            url: plugin.options.baseUrl+'/js/filter',
            type: 'GET',
            dataType: 'JSON',
            data: {
                type: ['Route'],
                Route: {
                    category:'4efaf3c0b1a7882d20000000'
                }
            },
            success: plugin.request.process
        });
    }
    Plugin.prototype.renderPanel = function(data)
    {
        $(plugin.panel).html(data);
    }
    //Request object
    Plugin.prototype.request = {};
    Plugin.prototype.request.back = function(){
        plugin.request.start();
        $.ajax({
            url: $('#DEMap-panel a.back-button').attr('href'),
            dataType: 'JSON',
            success: plugin.request.process
        });
        return false;
        
    }
    Plugin.prototype.request.send = function()
    {
        plugin.request.start();
        $.ajax({
            url: plugin.options.baseUrl+'/js/filter',
            data: $(plugin.panel).children('form').serialize(),
            dataType: 'JSON',
            success: plugin.request.process
        });
    }
    Plugin.prototype.request.start = function()
    {
        $(plugin.container).addClass('loading');
    }
    Plugin.prototype.request.end = function()
    {
        $(plugin.container).removeClass('loading');
    }
    Plugin.prototype.request.process = function(data)
    {
        plugin.renderPanel(data.panel);
        $(plugin.panel).find('.buttons').buttonset();
        //clear all objects from map
        $(plugin.element).gmap3({
            action: 'clear'
        });
        if(data.objects.Route)
            $.each(data.objects.Route,plugin.route.add);
        if(data.objects.Area)
            $.each(data.objects.Area,plugin.area.add);
        plugin.map.zoomChanged();
        plugin.request.end();
    }
    //Map object
    Plugin.prototype.map = {};
    Plugin.prototype.map.zoomChanged = function()
    {
        return;
        if($(plugin.element).gmap3('get').getZoom()<plugin.options.routeLod)
            {
                //hide all markers
                
                $.each(plugin.Route,function(index,route){
                   $.each(route.markers,function(index,marker){
                       if(marker.getVisible())
                       marker.setVisible(false);
                   });
                });
            }
            else
            {
                $.each(plugin.Route,function(index,route){
                   $.each(route.markers,function(index,marker){
                       if(!marker.getVisible())
                       marker.setVisible(true);
                   });
                });
            }
    }
    //Route object
    Plugin.prototype.route = {};
    Plugin.prototype.route.add = function(index,route)
    {
        var path = [];
        route.markers = [];
        $.each(route.points,function(index){
            point = this;
            path[index] = [this.latitude,this.longitude];
            $(plugin.element).gmap3({
                action: 'addMarker',
                latLng: path[index],
                marker:{
                    options:{
                        icon:new google.maps.MarkerImage(plugin.options.iconUrl, new google.maps.Size(32, 37), new google.maps.Point((parseInt(this.order)+1)*32, 0)),
                        visible: false
                    },
                    data: point,
                    callback: function(marker){
                        route.markers.push(marker);
                }
                }
            });
        });
        
        $(plugin.element).gmap3(
        {
            action: 'addPolyline',
            options:{
                strokeColor: "#FF00F0",
                strokeOpacity: 1.0,
                strokeWeight: 3,
                //editable: true,
                geodesic: true
            },
            path:path,
            data: route,
            tag: route._id,
            events: {
                mouseover: plugin.route.mouseover,
                mouseout: plugin.route.mouseout,
                click: plugin.route.click
            },
            callback: function(polyline){
                route.polyline = polyline;
            }
        });
    }
    Plugin.prototype.route.mouseover = function(polyline,event,data)
    {
        polyline.setOptions({
            strokeWeight: 10,
            strokeColor: 'green'
        });
    }
    Plugin.prototype.route.mouseout = function(polyline,event,data)
    {
        polyline.setOptions({
            strokeWeight: 3,
            strokeColor: "#FF00F0"
        });
    }
    Plugin.prototype.route.click = function(polyline,event,data)
    {
        //send object as data
        console.log(data);
    }
    //Area object
    Plugin.prototype.area = {};
    Plugin.prototype.area.add = function(index,area)
    {
        var path = [];
        $.each(area.points,function(index){
            point = this;
            path[index] = [this.latitude,this.longitude];
        });
        
        $(plugin.element).gmap3(
        {
            action: 'addPolygon',
            options:{
                strokeColor: "#FF00F0",
                strokeOpacity: 1.0,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35
            },
            paths:path,
            tag: area._id,
            data: area,
            callback: function(polygon){
                area.polygon = polygon;
            }
        });
    }
    
    
    
    
    
    
    //
    $.fn[pluginName] = function ( options ) {
        return this.each(function () {
            if (!$.data(this, 'plugin_' + pluginName)) {
                $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
            }
        });
    }

})( jQuery, window, document );