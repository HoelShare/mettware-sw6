import './service/api/mw-order.api.service';
import './component/mettware-plugin-detail';

import localeDE from './snippet/de-DE.json';
import localeEN from './snippet/en-GB.json';
Shopware.Locale.extend('de-DE', localeDE);
Shopware.Locale.extend('en-GB', localeEN);
