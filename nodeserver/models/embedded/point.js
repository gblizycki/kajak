var Info, Mixed, ObjectId, Schema, mongoose, pointSchema;

mongoose = require('mongoose');

Schema = mongoose.Schema;

ObjectId = Schema.ObjectId;

Mixed = Schema.Types.Mixed;

Info = require('./info.js');

pointSchema = new Schema({
  location: [Number],
  order: Number,
  info: Mixed,
  style: []
});

pointSchema.methods["export"] = function() {
  var object;
  object = {};
  object.latitude = this.latitude();
  object.longitude = this.longitude();
  if (this.order) object.order = this.order;
  return object;
};

pointSchema.methods.latitude = function() {
  return this.location[1];
};

pointSchema.methods.longitude = function() {
  return this.location[0];
};

module.exports = pointSchema;
