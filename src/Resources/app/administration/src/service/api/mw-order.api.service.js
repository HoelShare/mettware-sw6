import ApiService from 'src/core/service/api.service';

class MwOrderApiService extends ApiService {
    constructor(httpClient, loginService, apiEndpoint = 'mwOrder') {
        super(httpClient, loginService, apiEndpoint);
    }

    static get name() {
        return 'mwOrderService'
    }

    openOrders() {
        const route = `_action/mettware/free`;
        const headers = this.getBasicHeaders();

        return this.httpClient
            .post(route, {}, {
                headers
            });
    }
}

Shopware.Application.addServiceProvider(MwOrderApiService.name, (container) => {
    const initContainer = Shopware.Application.getContainer('init');
    return new MwOrderApiService(initContainer.httpClient, container.loginService);
})

export default MwOrderApiService;
