mongoose = require 'mongoose'
Schema = mongoose.Schema
ObjectId = Schema.ObjectId
Mixed = Schema.Types.Mixed
Point = require './embedded/point.js'
Info = require './embedded/info.js'
#async = require 'async'
placeSchema = new Schema
	_id: ObjectId
	address: String
	authorId: ObjectId
	category: [ObjectId]
	type: String
	style: []
	location: Mixed
	info: Mixed
placeSchema.methods.export = ()->
	object = {}
	object.id = this._id
	object.category = this.category if this.category
	object.author = this.authorId if this.authorId
	object.location = this.exportLocation()
	#object.info = this.exportInfo() if this.info
	return object
placeSchema.methods.exportLocation = ()->
	return  (new (mongoose.model 'Point',Point) this.location).export()
placeSchema.methods.exportInfo = ()->
	return  (new (mongoose.model 'Info',Info) this.info).export()
placeSchema.statics.search = (query,params) ->
	query.where 'category',params.category if params.category
	query.where 'authorId',params.authorId if params.authorId
	query.where '_id',params._id if params._id
	query.sort 'info.name',1
module.exports = mongoose.model 'Place',placeSchema,'place'