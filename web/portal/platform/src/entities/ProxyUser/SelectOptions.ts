import { DropdownChoices, EntityValues } from '@irontec/ivoz-ui';
import defaultEntityBehavior from '@irontec/ivoz-ui/entities/DefaultEntityBehavior';
import { SelectOptionsType } from '@irontec/ivoz-ui/entities/EntityInterface';
import store from 'store';

const ProxyUserSelectOptions: SelectOptionsType = ({
  callback,
  cancelToken,
}): Promise<unknown> => {
  const entities = store.getState().entities.entities;
  const ProxyUser = entities.ProxyUser;

  return defaultEntityBehavior.fetchFks(
    ProxyUser.path,
    ['id', 'name'],
    (data: Array<EntityValues>) => {
      const options: DropdownChoices = [];
      for (const item of data) {
        options.push({ id: item.id as number, label: item.name as string });
      }

      callback(options);
    },
    cancelToken
  );
};

export default ProxyUserSelectOptions;
