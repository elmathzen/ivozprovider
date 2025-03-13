import { Edit, RouteSpec } from '@irontec/ivoz-ui';
import MyAccount from '../components/MyAccount';

const addCustomRoutes = (routes: Array<RouteSpec>): Array<RouteSpec> => {
  if (routes.length === 0) {
    return routes;
  }

  const preferencesRoute = routes.find((route) => {
    return route.path === '/my/preferences';
  }) as RouteSpec;
  preferencesRoute.component = Edit;

  const accountRoute = routes.find((route) => {
    return route.path === '/my/account';
  }) as RouteSpec;
  accountRoute.component = MyAccount;

  return routes;
};

export default addCustomRoutes;
