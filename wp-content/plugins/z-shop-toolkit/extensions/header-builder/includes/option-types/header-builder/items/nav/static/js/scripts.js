fwEvents.one('fw-builder:' + 'header-builder' + ':register-items', function (builder) {
	var localized = header_builder_item_type_nav;

	var ItemView = builder.classes.ItemView.extend({
		template: _.template(
			'<div class="fw-header-builder-item-style-default fw-header-builder-item-type-nav <%- center_el %>">' +
			/**/'<div class="fw-header-item-control-buttons">' +
			/**//**/'<a class="fw-header-item-control-remove dashicons dashicons-trash" data-hover-tip="<%- remove %>" href="#" onclick="return false;" ></a>' +
			/**/'</div>' +
			/**/'<div class="item-preview" id="nav-<%- menu %>" data-menuid="<%- menu %>" data-style="<%- style %>">' +
			/**//**/'<%- helptext %>' +
			/**/'</div>' +
			'</div>'
		),
		events: {
			'click': 'openEdit',
			'click .fw-header-builder-item-type-nav': 'openEdit',
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

			// this.widthChangerView = new FwBuilderComponents.ItemView.WidthChanger({
			// 	model: this.model,
			// 	view: this
			// });
		},
		render: function () {
			var
				renderData   = {
					label: localized.l10n.name,
					default_value: fw.opg('default_value', this.model.get('options')),
					menu: fw.opg('menu', this.model.get('options')),
					center_el: fw.opg('center_el', this.model.get('options')) ? 'center-el' : '',
					edit: localized.l10n.edit,
					remove: localized.l10n.delete,
					duplicate: localized.l10n.duplicate,
					helptext: localized.l10n.helptext,
					style: '',
				},
				custom = fw.opg('custom_style', this.model.get('options'))
				;

			if ( custom.style === 'custom' ) {
				var custom_style = custom.custom;
				renderData.style = '';
				renderData.style += 'font-size: ' + custom_style.nav_item_typo.size + 'px;';
				if( custom_style.nav_item_typo.spacing !== 'undefined' ) {
					renderData.style += 'letter-spacing: ' + custom_style.nav_item_typo.spacing + 'px;';
				}

				if( custom_style.nav_text_transform === 'uppercase-first-level' ) {
					renderData.style += 'text-transform: uppercase;';
				} else {
					renderData.style += 'text-transform: ' + custom_style.nav_text_transform + ';';
				}

				renderData.style += 'color: ' + custom_style.nav_item_color + ';';
			}

			this.defaultRender(renderData);

			fwEvents.trigger('fw:header-builder:after-render-item');
			fwEvents.trigger('fw:header-builder:before-render-menu', renderData.menu);

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
			fwEvents.trigger('fw:header-builder:after-remove-item');
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
				id: 'fw-builder-nav-item-' + this.cid,
				model: this
			});
		},
		allowDestinationType: function (type) {
			return 'section' === type;
		}
	});

	builder.registerItemClass(Item);
});