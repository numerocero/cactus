<?php

namespace App\Constants;

class RouteNames
{
    const API_CUSTOMER_INDEX              = 'api.customer.index';
    const API_CUSTOMER_SHOW               = 'api.customer.show';
    const API_CUSTOMER_STORE              = 'api.customer.store';
    const API_CUSTOMER_UPDATE             = 'api.customer.update';
    const API_CUSTOMER_DELETE             = 'api.customer.delete';
    const API_CUSTOMER_INTERACTION_INDEX  = 'api.customer.interaction.index';
    const API_CUSTOMER_INTERACTION_STORE  = 'api.customer.interaction.store';
    const API_CUSTOMER_INTERACTION_UPDATE = 'api.customer.interaction.update';
    const API_CUSTOMER_INTERACTION_SHOW   = 'api.customer.interaction.show';
    const API_CUSTOMER_INTERACTION_DELETE = 'api.customer.interaction.delete';
    const API_AUTH_LOGIN                  = 'api.auth.login';
    const API_AUTH_LOGOUT                 = 'api.auth.logout';
    const WEB_AUTH_LOGIN                  = 'web.auth.login';
    const WEB_DASHBOARD                   = 'web.dashboard';
    const WEB_CUSTOMER_SHOW               = 'web.customer.show';
    const WEB_CUSTOMER_INTERACTION_CREATE = 'web.customer.interaction.create';
    const WEB_CUSTOMER_INTERACTION_SHOW   = 'web.customer.interaction.show';
}
