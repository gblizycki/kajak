var Info, Mixed, ObjectId, Schema, Section, mongoose, routeSchema;

mongoose = require('mongoose');

Schema = mongoose.Schema;

ObjectId = Schema.ObjectId;

Mixed = Schema.Types.Mixed;

Info = require('./embedded/info.js');

Section = require('./embedded/section.js');

routeSchema = new Schema({
  _id: ObjectId,
  authorId: ObjectId,
  sections: [Section],
  style: [],
  info: Mixed,
  category: ObjectId,
  createDate: Date,
  updateDate: Date
});

routeSchema.methods["export"] = function() {
  var object;
  object = {};
  object.id = this._id;
  if (this.authorId) object.author = this.authorId;
  object.category = this.category;
  object.sections = this.exportSections();
  return object;
};

routeSchema.methods.exportSections = function() {
  var section, sections, _i, _len, _ref;
  sections = [];
  _ref = this.sections;
  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
    section = _ref[_i];
    sections[section.order] = section["export"]();
    sections[section.order].id = this.id;
  }
  sections = sections.filter(function(element) {
    return element !== null;
  });
  return sections;
};

routeSchema.methods.exportInfo = function() {
  return null;
};

routeSchema.statics.search = function(query, params) {
  if (params.category) query.where('category', paramas.category);
  if (params.authorId) query.where('authorId', paramas.authorId);
  if (params._id) query.where('_id', paramas._id);
  return query.sort('info.name', 1);
};

module.exports = mongoose.model('Route', routeSchema, 'route');
