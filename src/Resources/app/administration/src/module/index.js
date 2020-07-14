import deDE from './snippet/de-DE';
import enGB from './snippet/en-GB';
import '../component/mettware-plugin-detail';

Shopware.Module.register('mettware-plugin', {
    type: 'plugin',
    name: 'Mettware',
    title: 'mettware-plugin.general.mainMenuItemGeneral',
    description: 'mettware-plugin.general.descriptionTextModule',
    color: '#ff3d58',
    icon: 'default-shopping-paper-bag-product',

    routes: {
        detail: {
            component: 'mettware-plugin-detail',
            path: 'detail',
        }
    },

    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },

    settingsItem: {
        group: 'system',
        to: 'mettware.plugin.detail',
        icon: 'default-object-rocket'
    }
});
