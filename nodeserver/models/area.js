var Info, Mixed, ObjectId, Point, Schema, areaSchema, mongoose;

mongoose = require('mongoose');

Schema = mongoose.Schema;

ObjectId = Schema.ObjectId;

Mixed = Schema.Types.Mixed;

Point = require('./embedded/point.js');

Info = require('./embedded/info.js');

areaSchema = new Schema({
  _id: ObjectId,
  points: [Point],
  style: [],
  category: ObjectId,
  createDate: Date,
  updateDate: Date,
  info: Mixed
});

areaSchema.methods["export"] = function() {
  var object;
  object = {};
  object.id = this._id;
  object.points = this.exportPoints();
  if (this.style.length > 0) object.style = this.style;
  object.category = this.category;
  if (this.info) object.info = this.exportInfo();
  return object;
};

areaSchema.methods.exportPoints = function() {
  var point, points, _i, _len, _ref;
  points = [];
  _ref = this.points;
  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
    point = _ref[_i];
    points[point.order] = point["export"]();
  }
  points = points.filter(function(element) {
    return element !== null;
  });
  return points;
};

areaSchema.methods.exportInfo = function() {
  return null;
};

areaSchema.statics.search = function(query, params) {
  if (params.category) query.where('category', params.category);
  if (params.authorId) query.where('authorId', params.authorId);
  if (params._id) query.where('_id', params._id);
  return query.sort('info.name', 1);
};

module.exports = mongoose.model('Area', areaSchema, 'area');
