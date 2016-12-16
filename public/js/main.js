requirejs.config({
	baseUrl: 'js/backbone.marionette'
});

requirejs([
	'jquery',
	'json2',
	'underscore',
	'backbone',
	'backbone.radio',
	'backbone.marionette'
],
function($, json2, _, Backbone, Radio, Marionette) {
	var Marionette = require('backbone.marionette');
	var _ = require('underscore');

	var MyView = Marionette.View.extend({
	  tagName: 'h1',
	  template: _.template('Contents')
	});

	var myView = new MyView();
	myView.render();
	$('body').append(myView.$el);
});
