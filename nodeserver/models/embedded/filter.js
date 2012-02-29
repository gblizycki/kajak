var ObjectId, Schema, filterSchema, mongoose;

mongoose = require('mongoose');

Schema = mongoose.Schema;

ObjectId = Schema.ObjectId;

filterSchema = new Schema({
  _id: ObjectId,
  attribute: String,
  "class": String,
  name: String,
  order: Number,
  partialMatch: Boolean,
  type: String,
  data: [],
  style: []
});

filterSchema.methods.setFilter = function(query, object) {
  var newname, value;
  newname = (this.attribute.replace(/\[/g, ".")).replace(/\]/g, "");
  value = object.get(newname);
  if (!value) return query;
  if ((this.type.toLowerCase('string')) && this.partialMatch) {
    return query.regex(newname, RegExp('.*' + value + '.*', 'i'));
  }
  return query.where(newname, value);
};

module.exports = filterSchema;
