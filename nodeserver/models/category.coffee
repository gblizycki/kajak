mongoose = require 'mongoose'
Schema = mongoose.Schema
ObjectId = Schema.ObjectId
Mixed = Schema.Types.Mixed
Filter = require './embedded/filter.js'

categorySchema = new Schema
	_id: ObjectId
	description: String
	name: String
	title: String
	filters: [Filter]
	style: []
categorySchema.methods.export = ()->
	name: this.name
	style: this.style
module.exports = []
module.exports['Area'] = mongoose.model('AreaCategory',categorySchema,'categoryarea')
module.exports['Route'] = mongoose.model('RouteCategory',categorySchema,'categoryroute')
module.exports['Place'] = mongoose.model('PlaceCategory',categorySchema,'categoryplace')
