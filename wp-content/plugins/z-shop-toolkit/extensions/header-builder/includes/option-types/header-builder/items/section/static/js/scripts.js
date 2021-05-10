fwEvents.one('fw-builder:' + 'header-builder' + ':register-items', function (builder) {
	var localized = header_builder_item_type_section;

	var ItemView = builder.classes.ItemView.extend({
		template: _.template(
			'<div class="fw-header-builder-item-style-default fw-header-builder-item-type-section">' +
			/**/'<div class="fw-header-item-controls fw-row">' +
			/**//**/'<div class="fw-header-item-control-buttons">' +
			/**//**//**/'<a class="fw-header-item-control-edit dashicons dashicons-edit" data-hover-tip="<%- edit %>" href="#" onclick="return false;" ></a>' +
			/**//**//**/'<a class="fw-header-item-control-remove dashicons dashicons-trash" data-hover-tip="<%- remove %>" href="#" onclick="return false;" ></a>' +
			/**//**/'</div>' +
			/**/'</div>' +
			/**/'<div class="builder-items-wrapper stretch-<%= stretch %>" style="background-color: <%= bg_color %>; height: <%= height %>px; background-image: url(<%= bg_image.url %>); background-size: <%= bg_size %>; background-position: <%= bg_position %>; background-repeat: <%= bg_repeat %>;">' +
			/**//**/'<div class="builder-items"></div>' +
			/**/'</div>' +
			'</div>'
		),
		events: {
			'click': 'openEdit',
			'click .fw-header-builder-item-type-section': 'openEdit',
			'click .fw-header-item-control-remove': 'removeItem',
		},
		initialize: function () {
			this.defaultInitialize();

			// prepare edit options modal
			{
				this.modal = new fw.OptionsModal({
					title: localized.l10n.item_title,
					options: this.model.modalOptions,
					values: this.model.get('options'),
					size: 'small'
				});

				this.listenTo(this.modal, 'change:values', function (modal, values) {
					this.model.set('options', values);
				});

				this.model.on('change:options', function () {
					this.modal.set(
						'values',
						this.model.get('options')
					);
				}, this);
			}
		},
		render: function () {
			this.defaultRender({
				label: localized.l10n.name,
				default_value: fw.opg('default_value', this.model.get('options')),
				height: fw.opg('height', this.model.get('options')),
				bg_color: fw.opg('bg_color', this.model.get('options')),
				bg_image: fw.opg('bg_image', this.model.get('options')),
				bg_position: fw.opg('bg_position', this.model.get('options')),
				bg_repeat: fw.opg('bg_repeat', this.model.get('options')),
				bg_size: fw.opg('bg_size', this.model.get('options')),
				stretch: fw.opg('stretch', this.model.get('options')),
				custom_class: fw.opg('custom_class', this.model.get('options')),
				edit: localized.l10n.edit,
				remove: localized.l10n.delete,
				duplicate: localized.l10n.duplicate,
			});
		},
		openEdit: function (e) {
			e.stopPropagation();

			if ( !this.modal ) {
				return;
			}

			var flow = { cancelModalOpening: false };

			fwEvents.trigger('fw:header-builder:item-simple:modal:before-open', {
				modal: this.modal,
				model: this.model,
				builder: builder,
				flow: flow
			});

			/**
			 * Skip modal opening, if the user wants to.
			 */
			if ( !flow.cancelModalOpening ) {
				this.modal.open();
			}

		},
		removeItem: function () {
			this.remove();
			this.model.collection.remove(this.model);
			return false
		},
		updateDefaultValueFromPreviewInput: function () {
			var values = _.clone(
				// clone to not modify by reference, else model.set() will not trigger the 'change' event
				this.model.get('options')
			);

			this.model.set('options', values);
		}
	});

	var Item = builder.classes.Item.extend({
		defaults: function () {
			var defaults = _.clone(localized.defaults);

			defaults.shortcode = headerHeaderBuilder.uniqueShortcode(defaults.type + '_');

			return defaults;
		},
		initialize: function () {
			this.defaultInitialize();

			/**
			 * get options from wp_localize_script() variable
			 */
			this.modalOptions = localized.options;

			this.view = new ItemView({
				id: 'fw-builder-item-' + this.cid,
				model: this
			});
		},
		allowIncomingType: function (type) {
			return 'section' !== type;
		},
		allowDestinationType: function (type) {
			return 'column' !== type;
		}
	});

	builder.registerItemClass(Item);
});