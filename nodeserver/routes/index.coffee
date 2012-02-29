async = require 'async'
ObjectId = require('mongoose').Types.ObjectId
Schemas =
	'Place': require '../models/place.js'
	'Area': require '../models/area.js'
	'Route': require '../models/route.js'
	'Category': require '../models/category.js'
exports.index = (req,res)->
	return res.json {}  if req.query.type is undefined
	res.header "Access-Control-Allow-Origin", "*"
	res.header "Access-Control-Allow-Headers", "X-Requested-With"
	objects = {}
	async.forEach req.query.type,(type,callback)->
		objects[type]=[]
		query = Schemas[type].find {}
		async.series [
			(call1)->
				query = Schemas[type].search query, req.query[type]
				call1()
			(call2)->
				#findCategories
				findCategories query,type,req.query[type],call2
			],()->
				query.limit req.query.pagesize[type]
				query.skip req.query.pagesize[type]*req.query.page
				console.log query
				query.exec (err,docs)->
					async.forEach docs,(object,callback2)->
						objects[type].push object.export()
						callback2()
					,callback
	,()->
		res.json objects:objects
findCategories = (query,type,params,callback)->
	object = new Schemas[type] params
	if object.category
		Schemas.Category[type].findById object.category,(err,category)->
			if category and category.filters.length>0
				async.forEach category.filters,(filter,callback)->
					filter.setFilter query, object
					callback()
				,callback
			else
				callback()
	else
		Schemas[type].find({}).only('category').distinct 'category',(err,categories)->
			Schemas.Category[type].find({}).in('_id',categories).exec (err,categories)->
				async.forEach categories,(category,callback)->
					if category and category.filters.length>0
						async.forEach category.filters,(filter,callback)->
							filter.setFilter query, object
							callback()
						,callback
					else
						callback()
				,callback