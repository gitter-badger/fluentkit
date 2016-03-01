/* */ 
(function() {

    this.Polycast = function() {

        this.options = {};

        this.channels = {};

        this.timeout = null;

        this.connected = false;

        var defaults = {
            url: null,
            polling: 5,
            token: null
        };

        if (arguments[0] && typeof arguments[0] === "object") {
            this.options = this.extend(defaults, arguments[0]);
        }else if(arguments[0] && typeof arguments[0] === "string"){
            if (arguments[1] && typeof arguments[1] === "object") {
                var opts = this.extend({url: arguments[0]}, arguments[1]);
                this.options = this.extend(defaults, opts);
            }else{
                this.options = this.extend(defaults, {url: arguments[0]});
            }
        }else{
            throw "Polycast url must be defined!";
        }

        this.init();

    };

    this.Polycast.prototype = {
        init: function(){

            var PolycastObject = this;

            var params = this.serialize({
                polling: this.options.polling,
                '_token': this.options.token
            });

            var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
            xhr.open('POST', this.options.url + '/connect');
            xhr.onreadystatechange = function() {
                if (xhr.readyState > 3 && xhr.status === 200) {
                    response = JSON.parse(xhr.responseText);
                    if(response.status == 'success'){
                        PolycastObject.setTime(response.time);
                        PolycastObject.setTimeout();
                        console.log('Polycast connection established!');
                    }
                }
            };
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(params);

            return this;
        },
        extend: function(source, properties) {
            var property;
            for (property in properties) {
                if (properties.hasOwnProperty(property)) {
                    source[property] = properties[property];
                }
            }
            return source;
        },
        setTime: function(time){
            this.options.time = time;
        },
        setTimeout: function(){
            var PolycastObject = this;
            this.timeout = setTimeout(function(){
                PolycastObject.fetch();
            }, (this.options.polling * 1000));
        },
        fetch: function(){
            this.request();
        },
        request: function(){
            var PolycastObject = this;

            //serialize just the channel names and events attached
            var channelData = {};
            for (var channel in this.channels) {
                if (this.channels.hasOwnProperty(channel)) {
                    if(channelData[channel] === undefined){
                        channelData[channel] = [];
                    }
                    for (var i = 0; i < this.channels[channel].length; i++) {
                        var obj = this.channels[channel][i];
                        var events = obj.events;
                        for(var key in events){
                            channelData[channel].push(key);
                        }
                    }
                }
            }

            var data = {
                time: this.options.time,
                channels: channelData,
                '_token': this.options.token
            };

            var params = this.serialize(data);

            var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
            xhr.open('POST', this.options.url + '/receive');
            xhr.onreadystatechange = function() {
                if (xhr.readyState > 3 && xhr.status === 200) {
                    PolycastObject.parseResponse(xhr.responseText);
                }
            };
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send(params);

            return xhr;
        },
        serialize: function(obj, prefix) {
            var str = [];
            for(var p in obj) {
                if (obj.hasOwnProperty(p)) {
                    var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
                    str.push(typeof v == "object" ?
                        this.serialize(v, k) :
                    encodeURIComponent(k) + "=" + encodeURIComponent(v));
                }
            }
            return str.join("&");
        },
        parseResponse: function(response){
            response = JSON.parse(response);
            if(response.status == 'success'){
                //do something
                this.setTime(response.time);

                for (var payload in response.payloads) {
                    if (response.payloads.hasOwnProperty(payload)) {
                        //foreach payload channels defer to channel class
                        for (i = 0; i < response.payloads[payload]['channels'].length; ++i) {
                            var channel = response.payloads[payload]['channels'][i];
                            //console.log('Polycast channel: ' + channel + ' received event: ' + response.payloads[payload]['event']);
                            for(index = 0; index < this.channels[channel].length; ++index){
                                this.channels[channel][index].fire(response.payloads[payload]['event'], response.payloads[payload]['payload']);
                            }
                        }
                    }
                }

                //lets do it again!
                this.setTimeout();
            }
        },
        subscribe: function(channel){

            var $channel = new PolycastChannel({channel: channel});
            if(this.channels[channel] === undefined){
                this.channels[channel] = [];
            }
            this.channels[channel].push($channel);
            return $channel;
        }
    };

    this.PolycastChannel = function(){

        this.options = {};

        this.events = {};

        var defaults = {
            channel: null
        };

        if (arguments[0] && typeof arguments[0] === "object") {
            this.options = this.extend(defaults, arguments[0]);
        }else{
            throw "Polycast channel options must be defined!";
        }
    };

    this.PolycastChannel.prototype = {
        init: function(){
            return this;
        },
        extend: function(source, properties) {
            var property;
            for (property in properties) {
                if (properties.hasOwnProperty(property)) {
                    source[property] = properties[property];
                }
            }
            return source;
        },
        on: function(event, callback){
            if(this.events[event] === undefined){
                this.events[event] = [];
            }
            this.events[event].push(callback);
            return this;
        },
        fire: function(event, payload){
            for(var e in this.events){
                if (this.events.hasOwnProperty(e)) {
                    if(e == event){
                        var func = this.events[e];
                        func[0](payload);
                    }
                }
            }
        }
    };

    this.Polycast.version = '1.0.0';

    this.PolycastChannel.version = '1.0.0';

    module.exports = this.Polycast;

}());