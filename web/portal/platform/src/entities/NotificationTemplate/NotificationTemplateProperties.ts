import { PropertySpec } from '@irontec-voip/ivoz-ui/services/api/ParsedApiSpecInterface';
import {
  EntityValue,
  EntityValues,
} from '@irontec-voip/ivoz-ui/services/entity/EntityService';

export type NotificationTemplatePropertyList<T> = {
  name?: T;
  type?: T;
  id?: T;
  brand?: T;
};

export type NotificationTemplateProperties = NotificationTemplatePropertyList<
  Partial<PropertySpec>
>;
export type NotificationTemplatePropertiesList = Array<
  NotificationTemplatePropertyList<EntityValue | EntityValues>
>;
