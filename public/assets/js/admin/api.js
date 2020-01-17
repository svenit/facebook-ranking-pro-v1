'use strict';
(function(factory) {
  var root = "object" == typeof self && self.self === self && self || "object" == typeof global && global.global === global && global;
  root.Facebook = factory(root, {}, root._, root.jQuery || root.Zepto || root.ender || root.$);
})(function($scope, exports, _, $) {
  var dojoEvents = $scope.Facebook;
  /** @type {string} */
  exports.VERSION = "4.0";
  /** @type {!Object} */
  exports.$ = $;
  /**
   * @return {?}
   */
  exports.noConflict = function() {
    $scope.Facebook = dojoEvents;
    return this;
  };
  var Events = exports.Events = {};
  /** @type {!RegExp} */
  var eventSplitter = /\s+/;
  /**
   * @param {!Function} iteratee
   * @param {?} events
   * @param {string} name
   * @param {!Object} callback
   * @param {!Object} opts
   * @return {?}
   */
  var eventsApi = function(iteratee, events, name, callback, opts) {
    /** @type {number} */
    var i = 0;
    var names;
    if (name && "object" === typeof name) {
      if (void 0 !== callback && "context" in opts && void 0 === opts.context) {
        /** @type {!Object} */
        opts.context = callback;
      }
      names = _.keys(name);
      for (; i < names.length; i++) {
        events = eventsApi(iteratee, events, names[i], name[names[i]], opts);
      }
    } else {
      if (name && eventSplitter.test(name)) {
        names = name.split(eventSplitter);
        for (; i < names.length; i++) {
          events = iteratee(events, names[i], callback, opts);
        }
      } else {
        events = iteratee(events, name, callback, opts);
      }
    }
    return events;
  };
  /**
   * @param {string} name
   * @param {!Object} callback
   * @param {!Object} context
   * @return {?}
   */
  Events.on = function(name, callback, context) {
    return internalOn(this, name, callback, context);
  };
  /**
   * @param {!Object} obj
   * @param {string} name
   * @param {!Object} callback
   * @param {!Object} context
   * @param {!Object} listening
   * @return {?}
   */
  var internalOn = function(obj, name, callback, context, listening) {
    obj._events = eventsApi(onApi, obj._events || {}, name, callback, {
      context : context,
      ctx : obj,
      listening : listening
    });
    if (listening) {
      /** @type {!Object} */
      (obj._listeners || (obj._listeners = {}))[listening.id] = listening;
    }
    return obj;
  };
  /**
   * @param {!Object} obj
   * @param {string} name
   * @param {!Object} callback
   * @return {?}
   */
  Events.listenTo = function(obj, name, callback) {
    if (!obj) {
      return this;
    }
    var id = obj._listenId || (obj._listenId = _.uniqueId("l"));
    var listeningTo = this._listeningTo || (this._listeningTo = {});
    var listening = listeningTo[id];
    if (!listening) {
      listening = this._listenId || (this._listenId = _.uniqueId("l"));
      listening = listeningTo[id] = {
        obj : obj,
        objId : id,
        id : listening,
        listeningTo : listeningTo,
        count : 0
      };
    }
    internalOn(obj, name, callback, this, listening);
    return this;
  };
  /**
   * @param {!Window} widget_class
   * @param {!Array} events
   * @param {!Function} callback
   * @param {!Object} options
   * @return {?}
   */
  var onApi = function(widget_class, events, callback, options) {
    if (callback) {
      events = widget_class[events] || (widget_class[events] = []);
      var context = options.context;
      var ctx = options.ctx;
      if (options = options.listening) {
        options.count++;
      }
      events.push({
        callback : callback,
        context : context,
        ctx : context || ctx,
        listening : options
      });
    }
    return widget_class;
  };
  /**
   * @param {string} name
   * @param {!Object} callback
   * @param {string} context
   * @return {?}
   */
  Events.off = function(name, callback, context) {
    if (!this._events) {
      return this;
    }
    this._events = eventsApi(offApi, this._events, name, callback, {
      context : context,
      listeners : this._listeners
    });
    return this;
  };
  /**
   * @param {string} obj
   * @param {string} event
   * @param {!Object} callback
   * @return {?}
   */
  Events.stopListening = function(obj, event, callback) {
    var index = this._listeningTo;
    if (!index) {
      return this;
    }
    obj = obj ? [obj._listenId] : _.keys(index);
    /** @type {number} */
    var j = 0;
    for (; j < obj.length; j++) {
      var p = index[obj[j]];
      if (!p) {
        break;
      }
      p.obj.off(event, callback, this);
    }
    return this;
  };
  /**
   * @param {!Object} events
   * @param {!Object} name
   * @param {!Object} callback
   * @param {!Object} listeners
   * @return {?}
   */
  var offApi = function(events, name, callback, listeners) {
    if (events) {
      /** @type {number} */
      var i = 0;
      var context = listeners.context;
      listeners = listeners.listeners;
      if (name || callback || context) {
        var parts = name ? [name] : _.keys(events);
        for (; i < parts.length; i++) {
          name = parts[i];
          var spheres = events[name];
          if (!spheres) {
            break;
          }
          /** @type {!Array} */
          var listener = [];
          /** @type {number} */
          var iter_sph = 0;
          for (; iter_sph < spheres.length; iter_sph++) {
            var listening = spheres[iter_sph];
            if (callback && callback !== listening.callback && callback !== listening.callback._callback || context && context !== listening.context) {
              listener.push(listening);
            } else {
              if ((listening = listening.listening) && 0 === --listening.count) {
                delete listeners[listening.id];
                delete listening.listeningTo[listening.objId];
              }
            }
          }
          if (listener.length) {
            /** @type {!Array} */
            events[name] = listener;
          } else {
            delete events[name];
          }
        }
        return events;
      }
      events = _.keys(listeners);
      for (; i < events.length; i++) {
        listening = listeners[events[i]];
        delete listeners[listening.id];
        delete listening.listeningTo[listening.objId];
      }
    }
  };
  /**
   * @param {string} name
   * @param {!Object} callback
   * @param {!Object} obj
   * @return {?}
   */
  Events.once = function(name, callback, obj) {
    var events = eventsApi(onceMap, {}, name, callback, _.bind(this.off, this));
    if ("string" === typeof name && null === obj) {
      callback = void 0;
    }
    return this.on(events, callback, obj);
  };
  /**
   * @param {!Object} obj
   * @param {string} name
   * @param {!Object} callback
   * @return {?}
   */
  Events.listenToOnce = function(obj, name, callback) {
    name = eventsApi(onceMap, {}, name, callback, _.bind(this.stopListening, this, obj));
    return this.listenTo(obj, name);
  };
  /**
   * @param {!NodeList} map
   * @param {number} name
   * @param {!Function} callback
   * @param {?} offer
   * @return {?}
   */
  var onceMap = function(map, name, callback, offer) {
    if (callback) {
      var once = map[name] = _.once(function() {
        offer(name, once);
        callback.apply(this, arguments);
      });
      /** @type {!Function} */
      once._callback = callback;
    }
    return map;
  };
  /**
   * @param {string} type
   * @return {?}
   */
  Events.trigger = function(type) {
    if (!this._events) {
      return this;
    }
    /** @type {number} */
    var _len = Math.max(0, arguments.length - 1);
    /** @type {!Array} */
    var args = Array(_len);
    /** @type {number} */
    var _i = 0;
    for (; _i < _len; _i++) {
      args[_i] = arguments[_i + 1];
    }
    eventsApi(callback, this._events, type, void 0, args);
    return this;
  };
  /**
   * @param {!Object} data
   * @param {string} index
   * @param {string} item
   * @param {!Array} file
   * @return {?}
   */
  var callback = function(data, index, item, file) {
    if (data) {
      item = data[index];
      var filter = data.all;
      if (item && filter) {
        filter = filter.slice();
      }
      if (item) {
        done(item, file);
      }
      if (filter) {
        done(filter, [index].concat(file));
      }
    }
    return data;
  };
  /**
   * @param {string} f
   * @param {!Array} values
   * @return {undefined}
   */
  var done = function(f, values) {
    var self;
    /** @type {number} */
    var lang = -1;
    var V = f.length;
    var a = values[0];
    var med = values[1];
    var optValues = values[2];
    switch(values.length) {
      case 0:
        for (; ++lang < V;) {
          (self = f[lang]).callback.call(self.ctx);
        }
        break;
      case 1:
        for (; ++lang < V;) {
          (self = f[lang]).callback.call(self.ctx, a);
        }
        break;
      case 2:
        for (; ++lang < V;) {
          (self = f[lang]).callback.call(self.ctx, a, med);
        }
        break;
      case 3:
        for (; ++lang < V;) {
          (self = f[lang]).callback.call(self.ctx, a, med, optValues);
        }
        break;
      default:
        for (; ++lang < V;) {
          (self = f[lang]).callback.apply(self.ctx, values);
        }
    }
  };
  /** @type {function(string, !Object, !Object): ?} */
  Events.bind = Events.on;
  /** @type {function(string, !Object, string): ?} */
  Events.unbind = Events.off;
  _.extend(exports, Events);
  /** @type {function(string): undefined} */
  var api = exports.Api = function(options) {
    if ("string" === typeof options) {
      options = {
        token : options
      };
    }
    if ("object" !== typeof options) {
      options = {};
    }
    options = _.extend({
      endpoint : "https://graph.facebook.com/",
      token : ""
    }, options);
    this.endpoint = options.endpoint;
    /** @type {string} */
    this.token = options.token;
    /** @type {number} */
    this.c = this.r = 0;
    this.initialize.apply(this, arguments);
    if (!this.token) {
      throw Error("No Token");
    }
  };
  _.extend(api.prototype, Events, {
    initialize : function() {
    },
    get : function(url, data, c) {
      if ("function" === typeof data) {
        /** @type {string} */
        var prefix = c;
        /** @type {string} */
        c = data;
        data = prefix;
      }
      var self = this;
      this.r++;
      if (-1 === url.indexOf("https")) {
        url = this.endpoint + url;
      }
      data = data || {};
      data.access_token = this.token;
      return $.ajax(url, {
        dataType : "jsonp",
        data : data
      }).then(function(lookupSoFar) {
        return lookupSoFar;
      }).then(function(results) {
        if (c) {
          c(results);
        }
        self.c++;
        return results;
      }).then(function(options) {
        self.trigger("progress", self.c, self.r, self);
        if (options && options.paging && options.paging.next) {
          return self.get(options.paging.next, [], c);
        }
        if (self.r === self.c) {
          self.trigger("complete", self);
          self.trigger("done", self);
        }
      });
    }
  });
  /** @type {function(string, (Uint8Array|number)): undefined} */
  var target = exports.Feed = function(url, params) {
    /** @type {string} */
    this.id = url;
    var config;
    if (!(config = params)) {
      throw Error("No Token");
    }
    this.api = new api(config);
    /** @type {string} */
    this._since = "";
    /** @type {number} */
    this.limit = 500;
    this.args = {
      info : false,
      post : false,
      reaction : false,
      comment : false,
      share : false
    };
    this.initialize.apply(this, arguments);
  };
  _.extend(target.prototype, Events, {
    initialize : function() {
    },
    progress : function(name) {
      this.api.on("progress", name);
      return this;
    },
    done : function(callback) {
      this.api.on("done", callback);
      return this;
    },
    since : function(value) {
      /** @type {!Date} */
      var returnDate = new Date;
      returnDate.setDate(returnDate.getDate() - value);
      /** @type {string} */
      this._since = value = returnDate.toISOString();
      return this;
    },
    limit : function(limit) {
      /** @type {number} */
      this.limit = limit;
      return this;
    },
    withPost : function(callback, numberOfLogs) {
      return this["with"]("post", callback, numberOfLogs);
    },
    withComment : function(callback, comment) {
      return this["with"]("comment", callback, comment);
    },
    withReaction : function(callback, _userIds) {
      return this["with"]("reaction", callback, _userIds);
    },
    withShare : function(callback, _userIds) {
      return this["with"]("share", callback, _userIds);
    },
    "with" : function(key, options, val) {
      if (_.isFunction(val)) {
        /** @type {!Object} */
        var method = val;
        options = options || {};
      } else {
        /** @type {!Object} */
        method = options;
        options = val || {};
      }
      if (!_.isObject(options)) {
        options = {};
      }
      /** @type {!Object} */
      this.args[key] = options;
      if (_.isFunction(method)) {
        this.on(key, method);
      }
      return this;
    },
    get : function() {
      this.run();
    },
    run : function() {
      var ctrl = this;
      var args = this.args;
      var data = {
        fields : "from"
      };
      if (this._since) {
        data.since = this._since;
      }
      if (args.post) {
        _.extend(data, args.post);
        this.api.get(this.id + "/feed", data, function(b) {
          _.each(b.data, function(id) {
            ctrl.trigger("post", id);
            ctrl.loadPost(id);
          });
        });
      }
      return this;
    },
    loadPost : function(id) {
      var self = this;
      var data = this.args;
      if (data.comment) {
        var d = _.extend({
          limit : self.limit,
          fields : "from,message"
        }, data.comment);
        self.api.get(id.id + "/comments", d, function(c) {
          _.each(c.data, function(legalInfo) {
            self.trigger("comment", legalInfo, id);
          });
        });
      }
      if (data.reaction) {
        d = _.extend({
          limit : self.limit
        }, data.reaction);
        self.api.get("v2.6/"+id.id + "/reactions", d, function(c) {
          _.each(c.data, function(legalInfo) {
            self.trigger("reaction", legalInfo, id);
          });
        });
      }
      if (data.share) {
        data = _.extend({
          limit : self.limit,
          fields : "from"
        }, data.share);
        self.api.get(id.id + "/sharedposts", data, function(c) {
          _.each(c.data, function(legalInfo) {
            self.trigger("share", legalInfo, id);
          });
        });
      }
    }
  });
  /** @type {function(!Function, string): ?} */
  api.extend = target.extend = function(protoProps, staticProps) {
    var parent = this;
    var child = protoProps && _.has(protoProps, "constructor") ? protoProps.constructor : function() {
      return parent.apply(this, arguments);
    };
    _.extend(child, parent, staticProps);
    child.prototype = _.create(parent.prototype, protoProps);
    child.prototype.constructor = child;
    child.__super__ = parent.prototype;
    return child;
  };
  exports.Post = target.extend({
    run : function() {
      var ctrl = this;
      var args = this.args;
      var data = {
        fields : "from"
      };
      if (this._since) {
        data.since = this._since;
      }
      if (args.post) {
        _.extend(data, args.post);
        this.api.get(this.id, data, function(id) {
          ctrl.trigger("post", id);
          ctrl.loadPost(id);
        });
      }
      return this;
    },
    loaded : function(callback, numberOfLogs) {
      return this.withPost(callback, numberOfLogs);
    }
  });
  return exports;
});
