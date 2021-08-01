import template from './mettware-cms-el-order-overview.html.twig';
import './mettware-cms-el-order-overview.scss';

Shopware.Component.register('mettware-cms-el-order-overview', {
    template,

    mixins: [
        'cms-element'
    ],

    computed: {
        showDetails() {
            return this.element.config.showDetails.value;
        },
        showSummary() {
            return this.element.config.showSummary.value;
        }
    },

    created() {
        this.createdComponent();
    },

    methods: {
        createdComponent() {
            this.initElementConfig('mettware-order-overview');
        }
    }
});
