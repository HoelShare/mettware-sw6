import template from './mettware-cms-el-statistics.html.twig';
import './mettware-cms-el-statistics.scss';

Shopware.Component.register('mettware-cms-el-statistics', {
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
            this.initElementConfig('mettware-statistics');
        }
    }
});
