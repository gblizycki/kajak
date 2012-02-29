mongoose = require 'mongoose'
Schema = mongoose.Schema
ObjectId = Schema.ObjectId
Mixed = Schema.Types.Mixed
Info = require './embedded/info.js'
Section = require './embedded/section.js'
routeSchema = new Schema
	_id: ObjectId
	authorId: ObjectId
	sections: [Section]
	style: []
	info: Mixed
	category: ObjectId
	createDate: Date
	updateDate: Date
routeSchema.methods.export = ()->
	object = {}
	object.id = this._id
	object.author = this.authorId if this.authorId
	object.category = this.category
	object.sections = this.exportSections()
	#object.style = this.style if this.style.legnth>0
	#object.info = this.exportInfo() if this.info
	return object
routeSchema.methods.exportSections = ()->
	sections = []
	for section in this.sections
		sections[section.order] = section.export()
		sections[section.order].id = this.id
	sections = sections.filter (element)->
		element isnt null
	return sections
routeSchema.methods.exportInfo = ()->
	null
routeSchema.statics.search = (query,params)->
	query.where 'category',paramas.category if params.category
	query.where 'authorId',paramas.authorId if params.authorId
	query.where '_id',paramas._id if params._id
	query.sort 'info.name',1
module.exports = mongoose.model 'Route', routeSchema, 'route'