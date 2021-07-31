import './service/api/mw-order.api.service';
import './component/mettware-plugin-detail';
import './module/sw-cms/elements/order-overview';
import './module/sw-cms/elements/statistics';

import localeDE from './snippet/de-DE.json';
import localeEN from './snippet/en-GB.json';
Shopware.Locale.extend('de-DE', localeDE);
Shopware.Locale.extend('en-GB', localeEN);
