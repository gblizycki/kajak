var Info, Mixed, ObjectId, Point, Schema, mongoose, placeSchema;

mongoose = require('mongoose');

Schema = mongoose.Schema;

ObjectId = Schema.ObjectId;

Mixed = Schema.Types.Mixed;

Point = require('./embedded/point.js');

Info = require('./embedded/info.js');

placeSchema = new Schema({
  _id: ObjectId,
  address: String,
  authorId: ObjectId,
  category: [ObjectId],
  type: String,
  style: [],
  location: Mixed,
  info: Mixed
});

placeSchema.methods["export"] = function() {
  var object;
  object = {};
  object.id = this._id;
  if (this.category) object.category = this.category;
  if (this.authorId) object.author = this.authorId;
  object.location = this.exportLocation();
  return object;
};

placeSchema.methods.exportLocation = function() {
  return (new (mongoose.model('Point', Point))(this.location))["export"]();
};

placeSchema.methods.exportInfo = function() {
  return (new (mongoose.model('Info', Info))(this.info))["export"]();
};

placeSchema.statics.search = function(query, params) {
  if (params.category) query.where('category', params.category);
  if (params.authorId) query.where('authorId', params.authorId);
  if (params._id) query.where('_id', params._id);
  return query.sort('info.name', 1);
};

module.exports = mongoose.model('Place', placeSchema, 'place');
