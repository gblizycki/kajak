mongoose = require 'mongoose'
Schema = mongoose.Schema
ObjectId = Schema.ObjectId
Mixed = Schema.Types.Mixed
Info = require './info.js'

pointSchema = new Schema
	location: [Number]
	order: Number
	info: Mixed
	style: []
pointSchema.methods.export = ()->
	object = {}
	object.latitude = this.latitude()
	object.longitude = this.longitude()
	object.order = this.order if this.order
	#object.info = this.info if this.info
	return object
pointSchema.methods.latitude = ()->
	this.location[1]
pointSchema.methods.longitude = ()->
	this.location[0]
module.exports = pointSchema