mongoose = require 'mongoose'
Schema = mongoose.Schema
ObjectId = Schema.ObjectId

infoSchema = new Schema
	name: String
	description: String
	format: String
	title: String
	data: []
infoSchema.methods.export = ()->
	object = {}
	object.name = this.name if this.name
	object.description = this.description if this.description
	object.format = this.format if this.format
	object.title = this.title if this.title
	object.data = this.data if this.data
	return object
module.exports = infoSchema