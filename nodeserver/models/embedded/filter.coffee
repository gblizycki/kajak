mongoose = require 'mongoose'
Schema = mongoose.Schema
ObjectId = Schema.ObjectId

filterSchema = new Schema
	_id: ObjectId
	attribute: String
	class: String
	name: String
	order: Number
	partialMatch: Boolean
	type: String
	data: []
	style: []
filterSchema.methods.setFilter = (query,object)->
	newname = (this.attribute.replace /\[/g, ".").replace /\]/g, ""
	value = object.get(newname)#object[(this.attribute.replace /\[/g, ".").replace /\]/g, ""]
	return query if !value
	return query.regex newname,RegExp('.*'+value+'.*','i') if (this.type.toLowerCase 'string') and this.partialMatch
	return query.where newname,value
module.exports = filterSchema