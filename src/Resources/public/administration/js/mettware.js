(this.webpackJsonp=this.webpackJsonp||[]).push([["mettware"],{"44Yp":function(e,t,n){var r=n("s9Ho");"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);(0,n("SZ7m").default)("55d6722c",r,!0,{})},"8DQL":function(e,t){e.exports='<div>\n    <sw-button-process\n        :isLoading="isLoading"\n        :processSuccess="isResetSuccessful"\n        @process-finish="resetFinish"\n        @click="onOpenOrders"\n    >{{ label }}</sw-button-process>\n</div>\n'},CkOj:function(e,t,n){"use strict";n.d(t,"a",(function(){return l}));var r=n("lSNA"),i=n.n(r),o=n("lO2t"),s=n("lYO9");function a(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function c(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?a(Object(n),!0).forEach((function(t){i()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):a(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}function l(e){var t=function(e){var t;if(o.a.isString(e))try{t=JSON.parse(e)}catch(e){return!1}else{if(!o.a.isObject(e)||o.a.isArray(e))return!1;t=e}return t}(e);if(!t)return null;if(!0===t.parsed||!function(e){return void 0!==e.data||void 0!==e.errors||void 0!==e.links||void 0!==e.meta}(t))return t;var n=function(e){var t={links:null,errors:null,data:null,associations:null,aggregations:null};if(e.errors)return t.errors=e.errors,t;var n=function(e){var t=new Map;if(!e||!e.length)return t;return e.forEach((function(e){var n="".concat(e.type,"-").concat(e.id);t.set(n,e)})),t}(e.included);if(o.a.isArray(e.data))t.data=e.data.map((function(e){var r=u(e,n);return Object(s.g)(r,"associationLinks")&&(t.associations=c(c({},t.associations),r.associationLinks),delete r.associationLinks),r}));else if(o.a.isObject(e.data)){var r=u(e.data,n);Object.prototype.hasOwnProperty.call(r,"associationLinks")&&(t.associations=c(c({},t.associations),r.associationLinks),delete r.associationLinks),t.data=r}else t.data=null;e.meta&&Object.keys(e.meta).length&&(t.meta=m(e.meta));e.links&&Object.keys(e.links).length&&(t.links=e.links);e.aggregations&&Object.keys(e.aggregations).length&&(t.aggregations=e.aggregations);return t}(t);return n.parsed=!0,n}function u(e,t){var n={id:e.id,type:e.type,links:e.links||{},meta:e.meta||{}};if(e.attributes&&Object.keys(e.attributes).length>0){var r=m(e.attributes);n=c(c({},n),r)}if(e.relationships){var i=function(e,t){var n={},r={};return Object.keys(e).forEach((function(i){var s=e[i];if(s.links&&Object.keys(s.links).length&&(r[i]=s.links.related),s.data){var a=s.data;o.a.isArray(a)?n[i]=a.map((function(e){return d(e,t)})):o.a.isObject(a)?n[i]=d(a,t):n[i]=null}})),{mappedRelations:n,associationLinks:r}}(e.relationships,t);n=c(c(c({},n),i.mappedRelations),{associationLinks:i.associationLinks})}return n}function m(e){var t={};return Object.keys(e).forEach((function(n){var r=e[n],i=n.replace(/-([a-z])/g,(function(e,t){return t.toUpperCase()}));t[i]=r})),t}function d(e,t){var n="".concat(e.type,"-").concat(e.id);return t.has(n)?u(t.get(n),t):e}},"DL/g":function(e,t,n){var r=n("Mg5o");"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);(0,n("SZ7m").default)("e30386ac",r,!0,{})},Dboy:function(e,t){e.exports='{% block mettware_cms_element_order_overview %}\n    <div class="mettware-cms-el-order-overview">\n        <table v-if="showDetails">\n            <thead>\n            <tr>\n                <th scope="col">#</th>\n                <th scope="col">{{ $tc(\'mettware-plugin.cms.orderOverview.list.orderNumber\') }}</th>\n                <th scope="col">{{ $tc(\'mettware-plugin.cms.orderOverview.list.name\') }}</th>\n                <th scope="col">{{ $tc(\'mettware-plugin.cms.orderOverview.list.order\') }}</th>\n                <th scope="col">{{ $tc(\'mettware-plugin.cms.orderOverview.list.manufacturer\') }}</th>\n                <th scope="col">{{ $tc(\'mettware-plugin.cms.orderOverview.list.count\') }}</th>\n                <th scope="col" colspan="2">{{ $tc(\'mettware-plugin.cms.orderOverview.list.price\') }}</th>\n            </tr>\n            </thead>\n            <tbody>\n            <tr>\n                <th scope="row">1</th>\n                <th scope="row">10001</th>\n                <td>Sebastian Hölscher</td>\n                <td>Mett Bun - With Onions</td>\n                <td>Butcher Of Trust</td>\n                <td>2</td>\n                <td>3€</td>\n                <td>3€</td>\n            </tr>\n            <tr>\n                <th scope="row" rowspan="2">2</th>\n                <th scope="row" rowspan="2">10002</th>\n                <td rowspan="2">Sebastian Hölscher</td>\n                <td>Mett Bun - With Onions</td>\n                <td>Butcher Of Trust</td>\n                <td>1</td>\n                <td>1.5€</td>\n                <td rowspan="2">3€</td>\n            </tr>\n            <tr>\n                <td>Mett Bun - Without Onions</td>\n                <td>Butcher Of Trust</td>\n                <td>1</td>\n                <td>1.5€</td>\n            </tr>\n            </tr>\n            </tbody>\n        </table>\n\n        <div v-if="showSummary">\n            <div\n                class="">{{ $tc(\'mettware-plugin.cms.orderOverview.summary.title\') }}</div>\n            <ul class="list-group list-group-flush">\n                <li class="list-group-item">\n                    Count: 2x Mett Bun - With Onions\n                </li>\n                <li class="list-group-item">\n                    Count: 1x Mett Bun - Without Onions\n                </li>\n            </ul>\n            <div class="card-footer text-muted">\n                <div class="row">\n                    <div class="col-9">\n                        <div>\n                            {{ $tc(\'mettware-plugin.cms.orderOverview.summary.totalCount\') }}\n                            : 3\n                        </div>\n                        <div>\n                            {{ $tc(\'mettware-plugin.cms.orderOverview.summary.totalPrice\') }}\n                            : €4.5\n                        </div>\n                    </div>\n                    <div class="col-3 message-wrapper">\n                        <button type="button"\n                                class="btn btn-danger">\n                            {{ $tc(\'mettware-plugin.cms.orderOverview.summary.stopButton\') }}\n                        </button>\n                    </div>\n                </div>\n            </div>\n        </div>\n    </div>\n{% endblock %}\n'},"F+UZ":function(e){e.exports=JSON.parse('{"mettware-plugin":{"detail":{"title":"Mettware","openOrders":"Open Orders","ordersOpened":"Orders successfully opened","error":"Ups, an error occurred"},"cms":{"orderOverview":{"label":"Order Overview","showDetails":"Show Details","showSummary":"Show Summary","list":{"orderNumber":"Order Number","name":"Name","order":"Order","manufacturer":"Manufacturer","count":"Count","price":"Price"},"summary":{"title":"Summary","totalCount":"Total Count","totalPrice":"Total","stopButton":"Stop Orders"}},"statistics":{"label":"Order Statistics","list":{"customerNumber":"Customer Number","name":"Name","count":"Count","meat":"Meat (in Gramm)"}}}}}')},Mg5o:function(e,t,n){},N0JI:function(e,t){e.exports='{% block mettware_cms_element_order_overview_preview %}\n    <div class="mettware-cms-el-preview-order-overview">\n        <img class="mettware-cms-el-preview-order-overview-img"\n             :src="\'mettware/static/img/cms/order_overview_preview.png\' | asset">\n    </div>\n{% endblock %}\n'},PuYW:function(e,t,n){"use strict";function r(e){return(r="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function i(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function o(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function s(e,t){return(s=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function a(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Boolean.prototype.valueOf.call(Reflect.construct(Boolean,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,r=l(e);if(t){var i=l(this).constructor;n=Reflect.construct(r,arguments,i)}else n=r.apply(this,arguments);return c(this,n)}}function c(e,t){return!t||"object"!==r(t)&&"function"!=typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function l(e){return(l=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}n.r(t);var u=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&s(e,t)}(l,e);var t,n,r,c=a(l);function l(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"mettware";return i(this,l),c.call(this,e,t,n)}return t=l,r=[{key:"name",get:function(){return"mwOrderService"}}],(n=[{key:"openOrders",value:function(){var e="_action/".concat(this.getApiBasePath(),"/free"),t=this.getBasicHeaders();return this.httpClient.post(e,{},{headers:t})}}])&&o(t.prototype,n),r&&o(t,r),l}(n("SwLI").default);Shopware.Application.addServiceProvider(u.name,(function(e){var t=Shopware.Application.getContainer("init");return new u(t.httpClient,e.loginService)}));var m=n("8DQL"),d=n.n(m),p=Shopware,f=p.Component,v=p.Mixin;f.register("mettware-plugin-detail",{template:d.a,props:["label"],inject:["mwOrderService"],mixins:[v.getByName("notification")],data:function(){return{isLoading:!1,isResetSuccessful:!1}},methods:{resetFinish:function(){this.isResetSuccessful=!1},onOpenOrders:function(){var e=this;this.isLoading=!0,this.mwOrderService.openOrders().then((function(t){t.data.ok?(e.isResetSuccessful=!0,e.createNotificationSuccess({title:e.$tc("mettware-plugin.detail.title"),message:e.$tc("mettware-plugin.detail.ordersOpened")})):e.createNotificationError({title:e.$tc("mettware-plugin.detail.title"),message:e.$tc("mettware-plugin.detail.error")}),e.isLoading=!1}))}}});var w=n("Dboy"),h=n.n(w);n("vtqv");Shopware.Component.register("mettware-cms-el-order-overview",{template:h.a,mixins:["cms-element"],computed:{showDetails:function(){return this.element.config.showDetails.value},showSummary:function(){return this.element.config.showSummary.value}},created:function(){this.createdComponent()},methods:{createdComponent:function(){this.initElementConfig("mettware-order-overview")}}});var g=n("VnFn"),b=n.n(g);Shopware.Component.register("mettware-cms-el-config-order-overview",{template:b.a,mixins:["cms-element"],created:function(){this.createdComponent()},methods:{createdComponent:function(){this.initElementConfig("mettware-order-overview")},onElementUpdate:function(e){this.$emit("element-update",e)}}});var y=n("N0JI"),O=n.n(y);n("DL/g");Shopware.Component.register("mettware-cms-el-preview-order-overview",{template:O.a}),Shopware.Service("cmsService").registerCmsElement({name:"mettware-order-overview",label:"mettware-plugin.cms.orderOverview.label",component:"mettware-cms-el-order-overview",configComponent:"mettware-cms-el-config-order-overview",previewComponent:"mettware-cms-el-preview-order-overview",defaultConfig:{showDetails:{source:"static",value:!0},showSummary:{source:"static",value:!0}}});var S=n("oM6f"),k=n.n(S);n("44Yp");Shopware.Component.register("mettware-cms-el-statistics",{template:k.a,mixins:["cms-element"],computed:{showDetails:function(){return this.element.config.showDetails.value},showSummary:function(){return this.element.config.showSummary.value}},created:function(){this.createdComponent()},methods:{createdComponent:function(){this.initElementConfig("mettware-statistics")}}});var j=n("ugqz"),C=n.n(j);Shopware.Component.register("mettware-cms-el-config-statistics",{template:C.a,mixins:["cms-element"],created:function(){this.createdComponent()},methods:{createdComponent:function(){this.initElementConfig("mettware-statistics")},onElementUpdate:function(e){this.$emit("element-update",e)}}});var _=n("WlZN"),P=n.n(_);n("sxvQ");Shopware.Component.register("mettware-cms-el-preview-statistics",{template:P.a}),Shopware.Service("cmsService").registerCmsElement({name:"mettware-statistics",label:"mettware-plugin.cms.statistics.label",component:"mettware-cms-el-statistics",configComponent:"mettware-cms-el-config-statistics",previewComponent:"mettware-cms-el-preview-statistics"});var E=n("jmHo"),D=n("F+UZ");Shopware.Locale.extend("de-DE",E),Shopware.Locale.extend("en-GB",D)},SwLI:function(e,t,n){"use strict";n.r(t);var r=n("lwsE"),i=n.n(r),o=n("W8MJ"),s=n.n(o),a=n("CkOj"),c=function(){function e(t,n,r){var o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"application/vnd.api+json";i()(this,e),this.httpClient=t,this.loginService=n,this.apiEndpoint=r,this.contentType=o}return s()(e,[{key:"getApiBasePath",value:function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"",n="";return null!=t&&t.length&&(n+="".concat(t,"/")),e&&e.length>0?"".concat(n).concat(this.apiEndpoint,"/").concat(e):"".concat(n).concat(this.apiEndpoint)}},{key:"getBasicHeaders",value:function(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t={Accept:this.contentType,Authorization:"Bearer ".concat(this.loginService.getToken()),"Content-Type":"application/json"};return Object.assign({},t,e)}},{key:"apiEndpoint",get:function(){return this.endpoint},set:function(e){this.endpoint=e}},{key:"httpClient",get:function(){return this.client},set:function(e){this.client=e}},{key:"contentType",get:function(){return this.type},set:function(e){this.type=e}}],[{key:"handleResponse",value:function(t){if(null===t.data||void 0===t.data)return t;var n=t.data,r=t.headers;return null!=r&&r["content-type"]&&"application/vnd.api+json"===r["content-type"]&&(n=e.parseJsonApiData(n)),n}},{key:"parseJsonApiData",value:function(e){return Object(a.a)(e)}},{key:"getVersionHeader",value:function(e){return{"sw-version-id":e}}}]),e}();t.default=c},VnFn:function(e,t){e.exports='{% block mettware_cms_element_order_overview_config %}\n    <div>\n        <sw-switch-field\n            class="mettware-order-overview-show-details"\n            :label="$tc(\'mettware-plugin.cms.orderOverview.showDetails\')"\n            v-model="element.config.showDetails.value"\n            @element-update="onElementUpdate">\n        </sw-switch-field>\n\n        <sw-switch-field\n            class="mettware-order-overview-show-summary"\n            :label="$tc(\'mettware-plugin.cms.orderOverview.showSummary\')"\n            v-model="element.config.showSummary.value"\n            @element-update="onElementUpdate">\n        </sw-switch-field>\n    </div>\n{% endblock %}\n'},WlZN:function(e,t){e.exports='{% block mettware_cms_element_order_overview_preview %}\n    <div class="mettware-cms-el-preview-order-overview">\n        <img class="mettware-cms-el-preview-order-overview-img"\n             :src="\'mettware/static/img/cms/order_overview_preview.png\' | asset">\n    </div>\n{% endblock %}\n'},ePo6:function(e,t,n){},jmHo:function(e){e.exports=JSON.parse('{"mettware-plugin":{"detail":{"title":"Mettware","openOrders":"Bestellungen freigeben","ordersOpened":"Bestellungen wurden erfolgreich freigegeben!","error":"Es ist ein Fehler aufgetreten!"},"cms":{"orderOverview":{"label":"Bestell Übersicht","showDetails":"Zeige Details","showSummary":"Zeige Zusammenfassung","list":{"orderNumber":"Bestellnummer","name":"Name","manufacturer":"Hersteller","order":"Bestellung","count":"Anzahl","price":"Preis"},"summary":{"title":"Zusammenfassung","totalCount":"Gesamtanzahl","totalPrice":"Summe","stopButton":"Stoppe Bestellungen"}},"statistics":{"label":"Bestell Statistiken","list":{"customerNumber":"Kunden Nummer","name":"Name","count":"Anzahl","meat":"Fleisch (in Gramm)"}}}}}')},lO2t:function(e,t,n){"use strict";n.d(t,"b",(function(){return C}));var r=n("GoyQ"),i=n.n(r),o=n("YO3V"),s=n.n(o),a=n("E+oP"),c=n.n(a),l=n("wAXd"),u=n.n(l),m=n("Z0cm"),d=n.n(m),p=n("lSCD"),f=n.n(p),v=n("YiAA"),w=n.n(v),h=n("4qC0"),g=n.n(h),b=n("Znm+"),y=n.n(b),O=n("Y+p1"),S=n.n(O),k=n("UB5X"),j=n.n(k);function C(e){return void 0===e}t.a={isObject:i.a,isPlainObject:s.a,isEmpty:c.a,isRegExp:u.a,isArray:d.a,isFunction:f.a,isDate:w.a,isString:g.a,isBoolean:y.a,isEqual:S.a,isNumber:j.a,isUndefined:C}},lYO9:function(e,t,n){"use strict";n.d(t,"h",(function(){return y})),n.d(t,"i",(function(){return O})),n.d(t,"a",(function(){return S})),n.d(t,"d",(function(){return k})),n.d(t,"k",(function(){return j})),n.d(t,"j",(function(){return C})),n.d(t,"g",(function(){return _})),n.d(t,"b",(function(){return P})),n.d(t,"c",(function(){return E})),n.d(t,"f",(function(){return D})),n.d(t,"e",(function(){return B}));var r=n("lSNA"),i=n.n(r),o=n("QkVN"),s=n.n(o),a=n("JBE3"),c=n.n(a),l=n("BkRI"),u=n.n(l),m=n("mwIZ"),d=n.n(m),p=n("D1y2"),f=n.n(p),v=n("JZM8"),w=n.n(v),h=n("lO2t");function g(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,r)}return n}function b(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?g(Object(n),!0).forEach((function(t){i()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):g(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}s.a,s.a,u.a,d.a,f.a,w.a;var y=s.a,O=c.a,S=u.a,k=d.a,j=f.a,C=w.a;function _(e,t){return Object.prototype.hasOwnProperty.call(e,t)}function P(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{};return JSON.parse(JSON.stringify(e))}function E(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:{},t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{};return O(e,t,(function(e,t){if(Array.isArray(e))return e.concat(t)}))}function D(e,t){return e===t?{}:h.a.isObject(e)&&h.a.isObject(t)?h.a.isDate(e)||h.a.isDate(t)?e.valueOf()===t.valueOf()?{}:t:Object.keys(t).reduce((function(n,r){if(!_(e,r))return b(b({},n),{},i()({},r,t[r]));if(h.a.isArray(t[r])){var o=B(e[r],t[r]);return Object.keys(o).length>0?b(b({},n),{},i()({},r,t[r])):n}if(h.a.isObject(t[r])){var s=D(e[r],t[r]);return!h.a.isObject(s)||Object.keys(s).length>0?b(b({},n),{},i()({},r,s)):n}return e[r]!==t[r]?b(b({},n),{},i()({},r,t[r])):n}),{}):t}function B(e,t){if(e===t)return[];if(!h.a.isArray(e)||!h.a.isArray(t))return t;if(e.length<=0&&t.length<=0)return[];if(e.length!==t.length)return t;if(!h.a.isObject(t[0]))return t.filter((function(t){return!e.includes(t)}));var n=[];return t.forEach((function(r,i){var o=D(e[i],t[i]);Object.keys(o).length>0&&n.push(t[i])})),n}},oM6f:function(e,t){e.exports='{% block mettware_cms_element_order_overview %}\n    <div class="mettware-cms-el-order-overview">\n        <table>\n            <thead>\n            <tr>\n                <th scope="col">#</th>\n                <th scope="col">{{ $tc(\'mettware-plugin.cms.statistics.list.customerNumber\') }}</th>\n                <th scope="col">{{ $tc(\'mettware-plugin.cms.statistics.list.name\') }}</th>\n                <th scope="col">{{ $tc(\'mettware-plugin.cms.statistics.list.count\') }}</th>\n                <th scope="col">{{ $tc(\'mettware-plugin.cms.statistics.list.meat\') }}</th>\n            </tr>\n            </thead>\n            <tbody>\n            <tr>\n                <th scope="row">1</th>\n                <th scope="row">42</th>\n                <td>Sebastian Hölscher</td>\n                <td>4</td>\n                <td>500</td>\n            </tr>\n            <tr>\n                <th scope="row">2</th>\n                <th scope="row">2</th>\n                <td>Max Mustermann</td>\n                <td>3</td>\n                <td>200</td>\n            </tr>\n            <tr>\n                <th scope="row">2</th>\n                <th scope="row">37</th>\n                <td>Albert Einstein</td>\n                <td>1</td>\n                <td>80</td>\n            </tr>\n            </tbody>\n        </table>\n    </div>\n{% endblock %}\n'},qvAq:function(e,t,n){},s9Ho:function(e,t,n){},sxvQ:function(e,t,n){var r=n("qvAq");"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);(0,n("SZ7m").default)("1b022bd6",r,!0,{})},ugqz:function(e,t){e.exports='{% block mettware_cms_element_order_overview_config %}\n    <div>\n        <sw-switch-field\n            class="mettware-order-overview-show-details"\n            :label="$tc(\'mettware-plugin.cms.orderOverview.showDetails\')"\n            v-model="element.config.showDetails.value"\n            @element-update="onElementUpdate">\n        </sw-switch-field>\n\n        <sw-switch-field\n            class="mettware-order-overview-show-summary"\n            :label="$tc(\'mettware-plugin.cms.orderOverview.showSummary\')"\n            v-model="element.config.showSummary.value"\n            @element-update="onElementUpdate">\n        </sw-switch-field>\n    </div>\n{% endblock %}\n'},vtqv:function(e,t,n){var r=n("ePo6");"string"==typeof r&&(r=[[e.i,r,""]]),r.locals&&(e.exports=r.locals);(0,n("SZ7m").default)("4d35f37f",r,!0,{})}},[["PuYW","runtime","vendors-node"]]]);