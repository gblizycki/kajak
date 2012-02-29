mongoose = require 'mongoose'
Schema = mongoose.Schema
ObjectId = Schema.ObjectId
Mixed = Schema.Types.Mixed
Point = require './point.js'
Info = require './info.js'

sectionSchema = new Schema
	points: [Point]
	order: Number
	info: Mixed
sectionSchema.methods.export = ()->
	points: this.exportPoints()
	#info: this.exportInfo() if this.info
	order: this.order
sectionSchema.methods.exportPoints = ()->
	points = []
	for point in this.points
		data = point.export()
		points[point.order] = data if data
	points = points.filter (element)->
		element isnt null
	return points
sectionSchema.methods.exportInfo = ()->
	return  (new (mongoose.model 'Info',Info) this.info).export()
module.exports = sectionSchema
