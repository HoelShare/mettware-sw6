import template from './mettware-cms-el-config-order-overview.html.twig';

Shopware.Component.register('mettware-cms-el-config-order-overview', {
    template,

    mixins: [
        'cms-element'
    ],

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('mettware-order-overview');
        },

        onElementUpdate(element) {
            this.$emit('element-update', element);
        }
    }
});
