mongoose = require 'mongoose'
Schema = mongoose.Schema
ObjectId = Schema.ObjectId
Mixed = Schema.Types.Mixed
Point = require './embedded/point.js'
Info = require './embedded/info.js'
areaSchema = new Schema
	_id: ObjectId
	points: [Point]
	style: []
	category: ObjectId
	createDate: Date
	updateDate: Date
	info: Mixed
areaSchema.methods.export = ()->
	object = {}
	object.id = this._id
	object.points = this.exportPoints()
	object.style = this.style if this.style.length>0
	object.category =  this.category
	object.info = this.exportInfo() if this.info
	return object
areaSchema.methods.exportPoints = ()->
	points = []
	for point in this.points
		points[point.order] = point.export()
	points = points.filter (element)->
		element isnt null
	return points
areaSchema.methods.exportInfo = ()->
	return null
areaSchema.statics.search = (query,params)->
	query.where 'category',params.category if params.category
	query.where 'authorId',params.authorId if params.authorId
	query.where '_id',params._id if params._id
	query.sort 'info.name',1
module.exports = mongoose.model 'Area',areaSchema,'area'