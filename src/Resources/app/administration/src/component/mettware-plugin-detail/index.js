import template from './mettware-plugin-detail.html.twig';

Shopware.Component.register('mettware-plugin-detail', {
    inject: [
        'mwOrderService'
    ],

    template,

    data() {
        return {
            ok: null
        };
    },

    methods: {
        onOpenOrders() {
            this.mwOrderService.openOrders().then((result) => {
                this.ok = result.data.ok;
            });
        }
    }
});
