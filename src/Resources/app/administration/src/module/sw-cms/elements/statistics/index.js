import './component';
import './config';
import './preview';

Shopware.Service('cmsService').registerCmsElement({
    name: 'mettware-statistics',
    label: 'mettware-plugin.cms.statistics.label',
    component: 'mettware-cms-el-statistics',
    configComponent: 'mettware-cms-el-config-statistics',
    previewComponent: 'mettware-cms-el-preview-statistics',
    // defaultConfig: {
    // }
});
