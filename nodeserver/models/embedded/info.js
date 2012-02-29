var ObjectId, Schema, infoSchema, mongoose;

mongoose = require('mongoose');

Schema = mongoose.Schema;

ObjectId = Schema.ObjectId;

infoSchema = new Schema({
  name: String,
  description: String,
  format: String,
  title: String,
  data: []
});

infoSchema.methods["export"] = function() {
  var object;
  object = {};
  if (this.name) object.name = this.name;
  if (this.description) object.description = this.description;
  if (this.format) object.format = this.format;
  if (this.title) object.title = this.title;
  if (this.data) object.data = this.data;
  return object;
};

module.exports = infoSchema;
