const { Component, Mixin } = Shopware;
import template from './mettware-plugin-detail.html.twig';

Component.register('mettware-plugin-detail', {
    template,

    props: ['label'],
    inject: ['mwOrderService'],

    mixins: [
        Mixin.getByName('notification')
    ],

    data() {
        return {
            isLoading: false,
            isResetSuccessful: false,
        };
    },

    methods: {
        resetFinish() {
            this.isResetSuccessful = false;
        },

        onOpenOrders() {
            this.isLoading = true;
            this.mwOrderService.openOrders().then((result) => {
                if (result.data.ok) {
                    this.isResetSuccessful = true;
                    this.createNotificationSuccess({
                        title: this.$tc('mettware-plugin.detail.title'),
                        message: this.$tc('mettware-plugin.detail.ordersOpened')
                    });
                } else {
                    this.createNotificationError({
                        title: this.$tc('mettware-plugin.detail.title'),
                        message: this.$tc('mettware-plugin.detail.error')
                    })
                }

                this.isLoading = false;
            });
        }
    }
});
