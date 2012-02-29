var ObjectId, Schemas, async, findCategories;

async = require('async');

ObjectId = require('mongoose').Types.ObjectId;

Schemas = {
  'Place': require('../models/place.js'),
  'Area': require('../models/area.js'),
  'Route': require('../models/route.js'),
  'Category': require('../models/category.js')
};

exports.index = function(req, res) {
  var objects;
  if (req.query.type === void 0) return res.json({});
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "X-Requested-With");
  objects = {};
  return async.forEach(req.query.type, function(type, callback) {
    var query;
    objects[type] = [];
    query = Schemas[type].find({});
    return async.series([
      function(call1) {
        query = Schemas[type].search(query, req.query[type]);
        return call1();
      }, function(call2) {
        return findCategories(query, type, req.query[type], call2);
      }
    ], function() {
      query.limit(req.query.pagesize[type]);
      query.skip(req.query.pagesize[type] * req.query.page);
      console.log(query);
      return query.exec(function(err, docs) {
        return async.forEach(docs, function(object, callback2) {
          objects[type].push(object["export"]());
          return callback2();
        }, callback);
      });
    });
  }, function() {
    return res.json({
      objects: objects
    });
  });
};

findCategories = function(query, type, params, callback) {
  var object;
  object = new Schemas[type](params);
  if (object.category) {
    return Schemas.Category[type].findById(object.category, function(err, category) {
      if (category && category.filters.length > 0) {
        return async.forEach(category.filters, function(filter, callback) {
          filter.setFilter(query, object);
          return callback();
        }, callback);
      } else {
        return callback();
      }
    });
  } else {
    return Schemas[type].find({}).only('category').distinct('category', function(err, categories) {
      return Schemas.Category[type].find({})["in"]('_id', categories).exec(function(err, categories) {
        return async.forEach(categories, function(category, callback) {
          if (category && category.filters.length > 0) {
            return async.forEach(category.filters, function(filter, callback) {
              filter.setFilter(query, object);
              return callback();
            }, callback);
          } else {
            return callback();
          }
        }, callback);
      });
    });
  }
};
