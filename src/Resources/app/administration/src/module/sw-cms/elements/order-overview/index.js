import './component';
import './config';
import './preview';

Shopware.Service('cmsService').registerCmsElement({
    name: 'mettware-order-overview',
    label: 'mettware-plugin.cms.orderOverview.label',
    component: 'mettware-cms-el-order-overview',
    configComponent: 'mettware-cms-el-config-order-overview',
    previewComponent: 'mettware-cms-el-preview-order-overview',
    defaultConfig: {
        showDetails: {
            source: 'static',
            value: true
        },
        showSummary: {
            source: 'static',
            value: true
        }
    }
});
