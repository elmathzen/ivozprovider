import React from 'react';

interface KeyValList {
    [key: string]: any
}

interface KeyNumList {
    [key: string]: number
}

export interface ActionModelSpec {
    parameters: KeyNumList,
    paths: Array<any>,
    properties: Array<any>,
    required: Array<string>,
    type: string
}

export interface ActionModelList {
    [modelName: string]: ActionModelSpec
}

interface GetActionSpec {
    collection?: ActionModelList,
    item?: ActionModelList
}

export interface ActionsSpec {
    get?: GetActionSpec,
    post?: ActionModelList,
    put?: ActionModelList,
    delete?: ActionModelList
}

export interface visualToggleList {
    [fldName: string]: visualToggleValue
};

export interface visualToggleValue {
    [value: string]: visualToggle
};

export interface visualToggle {
    show: Array<string>,
    hide: Array<string>,
}

enum customComponentContext {
    write = "write",
    read = "read",
}

export interface propertyCustomComponent extends React.FunctionComponent<any> {
    _context?: customComponentContext,
    _columnName?: string
}

export interface ScalarProperty {
    type?: string,
    format?: string,
    readOnly?: boolean,
    description?: string,
    maxLength?: number,
    default?: any,
    enum?: KeyValList,
    null?: string | React.ReactElement<any>,
    visualToggle?: visualToggleValue
    label: string | React.ReactElement<any>,
    prefix?: string | React.ReactElement<any>,
    component?: propertyCustomComponent,
    required: boolean,
    pattern?: RegExp,
    helpText?: string | React.ReactElement<any>,
}

export interface FkProperty {
    $ref: string,
    label: string | React.ReactElement<any>,
    prefix?: string | React.ReactElement<any>,
    null?: string | React.ReactElement<any>,
    required: boolean,
    helpText?: string,
}

export type PropertySpec = ScalarProperty | FkProperty;

export interface PropertyList {
    [key: string]: PropertySpec
}

export interface EntitySpec {
    actions: ActionsSpec,
    properties: PropertyList,
}

export default interface ParsedApiSpecInterface {
    [key: string]: EntitySpec
}