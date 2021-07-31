import template from './mettware-cms-el-config-statistics.html.twig';

Shopware.Component.register('mettware-cms-el-config-statistics', {
    template,

    mixins: [
        'cms-element'
    ],

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('mettware-statistics');
        },

        onElementUpdate(element) {
            this.$emit('element-update', element);
        }
    }
});
