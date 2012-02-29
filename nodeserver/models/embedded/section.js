var Info, Mixed, ObjectId, Point, Schema, mongoose, sectionSchema;

mongoose = require('mongoose');

Schema = mongoose.Schema;

ObjectId = Schema.ObjectId;

Mixed = Schema.Types.Mixed;

Point = require('./point.js');

Info = require('./info.js');

sectionSchema = new Schema({
  points: [Point],
  order: Number,
  info: Mixed
});

sectionSchema.methods["export"] = function() {
  return {
    points: this.exportPoints(),
    order: this.order
  };
};

sectionSchema.methods.exportPoints = function() {
  var data, point, points, _i, _len, _ref;
  points = [];
  _ref = this.points;
  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
    point = _ref[_i];
    data = point["export"]();
    if (data) points[point.order] = data;
  }
  points = points.filter(function(element) {
    return element !== null;
  });
  return points;
};

sectionSchema.methods.exportInfo = function() {
  return (new (mongoose.model('Info', Info))(this.info))["export"]();
};

module.exports = sectionSchema;
