import { PropertySpec } from '@irontec-voip/ivoz-ui/services/api/ParsedApiSpecInterface';
import {
  EntityValue,
  EntityValues,
} from '@irontec-voip/ivoz-ui/services/entity/EntityService';

export type CallCsvReportPropertyList<T> = {
  sentTo?: T;
  inDate?: T;
  outDate?: T;
  createdOn?: T;
  csv?: T;
  company?: T;
};

export type CallCsvReportProperties = CallCsvReportPropertyList<
  Partial<PropertySpec>
>;
export type CallCsvReportPropertiesList = Array<
  CallCsvReportPropertyList<EntityValue | EntityValues>
>;
