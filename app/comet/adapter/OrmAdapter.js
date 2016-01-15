/**
 * @class app.comet.adapter.OrmAdapter
 * @extends NeatComet.adapters.backbone.NeatCometBackboneCollectionAdapter
 */
Jii.defineClass('app.comet.adapter.OrmAdapter', NeatComet.adapters.backbone.NeatCometBackboneCollectionAdapter, /** @lends app.comet.adapter.OrmAdapter.prototype */{

    add: function(attributes) {

        if (this.idMapper) {
            attributes.id = this.idMapper(attributes);
        }

        // Skip own messages
        if (attributes.cometTracker) {
            var ownMessage = this.collection.find(function(model) {
                return model.cometTracker === attributes.cometTracker;
            });
            if (ownMessage) {
                ownMessage.set('id', attributes.id);
                return;
            }
        }

        this.collection.add([attributes]);
    },

    update: function(newAttributes, oldAttributes) {

        if (this.idMapper) {
            oldAttributes.id = this.idMapper(oldAttributes);
            newAttributes.id = this.idMapper(newAttributes);
        }

        var model = this.collection.get(oldAttributes.id);
        if (model) {
            // Skip own messages
            if (newAttributes.cometTracker && model.cometTracker === newAttributes.cometTracker) {
                return;
            }
            model.set(newAttributes);
        }
        else {
            NeatComet.Exception.warning('Model to update not found');
        }
    },

    remove: function(oldAttributes) {

        if (this.idMapper) {
            oldAttributes.id = this.idMapper(oldAttributes);
        }

        var model = this.collection.get(oldAttributes.id);
        if (model) {
            this.collection.remove(model);
        }
        else {
            // No warning // NeatComet.Exception.warning('Model to remove not found');
        }
    }

}, /** @lends app.comet.adapter.OrmAdapter */{

    createCollection: function(profileId, bindingId, definition, openedProfile) {
        // Get model class or definition
        var modelClass = app.models[profileId][bindingId];

        // Require model class
        if (!(modelClass instanceof Backbone.Model)) {
            app.models[profileId][bindingId] = modelClass = Joints.RelationalModel.extend(modelClass);
        }

        // Create
        return new app.comet.adapter.OrmAdapter({
            collection: new Backbone.Collection([], {
                model: modelClass
            })
        });
    }
});
