import React, {PropTypes} from 'react';
import {connect} from 'react-redux';
import {Field, FieldArray, reduxForm, formValueSelector} from 'redux-form';
import {initialize} from 'redux-form/lib/actions';

import ModelMetaArrayField from './views/ModelMetaArrayField';
import ModelRelationsArrayField from './views/ModelRelationsArrayField';

class ModelEditor extends React.Component {

    static formId = 'ModelEditor';

    static propTypes = {
        modules: PropTypes.arrayOf(PropTypes.shape({
            id: PropTypes.string,
            className: PropTypes.string,
        })),
        models: PropTypes.arrayOf(PropTypes.shape({
            id: PropTypes.string,
            name: PropTypes.string,
            module: PropTypes.string,
            className: PropTypes.string,
        })),
        dbTypes: PropTypes.array,
        fieldWidgets: PropTypes.array,
        formatters: PropTypes.array,
        tableNames: PropTypes.array,
        formValues: PropTypes.object,
        csrfToken: PropTypes.string,
    };

    static defaultMeta = [
        {
            name: 'id',
            label: 'ID',
            dbType: 'pk',
            notNull: true,
            formatter: 'integer',
        },
        {
            name: 'createTime',
            label: 'Дата создания',
            dbType: 'datetime',
            notNull: true,
            formatter: 'datetime',
        },
        {
            name: 'updateTime',
            label: 'Дата добавления',
            dbType: 'datetime',
            notNull: true,
            formatter: 'datetime',
        },
    ];

    componentWillReceiveProps(nextProps) {
        if ((!this.props.formValues.moduleId || !this.props.formValues.modelName)
            && nextProps.formValues.moduleId && nextProps.formValues.modelName) {

            const model = this.getModel(nextProps);
            const values = {
                ...nextProps.formValues,
                meta: model ? model.meta : ModelEditor.defaultMeta,
                relations: model ? model.relations : [],
            };
            if (model) {
                values.tableName = model.tableName;
            }

            this.props.dispatch(initialize(ModelEditor.formId, values));
        }
    }

    getModel(props) {
        props = props || this.props;
        return props.models.find(m => m.module === props.formValues.moduleId && m.name === props.formValues.modelName);
    }

    render() {
        return (
            <form
                method='post'
                className='form-horizontal'
            >
                <input
                    type='hidden'
                    name='_csrf'
                    value={this.props.csrfToken}
                />
                <div className='form-group'>
                    <label className='col-sm-2 control-label'>
                        Module
                    </label>
                    <div className='col-sm-10'>
                        <Field
                            name='moduleId'
                            component='input'
                            list={`${ModelEditor.formId}_moduleIdList`}
                            className='form-control'
                        />
                        <datalist id={`${ModelEditor.formId}_moduleIdList`}>
                            {this.props.modules.map(module => (
                                <option key={module.id} value={module.id} />
                            ))}
                        </datalist>
                    </div>
                </div>
                <div className='form-group'>
                    <label className='col-sm-2 control-label'>
                        Model
                    </label>
                    <div className='col-sm-10'>
                        <Field
                            name='modelName'
                            component='input'
                            list={`${ModelEditor.formId}_modelNameList`}
                            className='form-control'
                        />
                        <datalist id={`${ModelEditor.formId}_modelNameList`}>
                            {this.props.models.filter(model => model.module === this.props.formValues.moduleId).map(model => (
                                <option key={model.name} value={model.name} />
                            ))}
                        </datalist>
                    </div>
                </div>
                <div className='form-group'>
                    <label className='col-sm-2 control-label'>
                        Table name
                    </label>
                    <div className='col-sm-10'>
                        <Field
                            name='tableName'
                            component='input'
                            list={`${ModelEditor.formId}_tableNameList`}
                            className='form-control'
                        />
                        <datalist id={`${ModelEditor.formId}_tableNameList`}>
                            {this.props.tableNames.map(name => (
                                <option key={name} value={name} />
                            ))}
                        </datalist>
                    </div>
                </div>
                {this.props.formValues.moduleId && this.props.formValues.modelName && (
                    <FieldArray
                        name='meta'
                        component={ModelMetaArrayField}
                        dbTypes={this.props.dbTypes}
                        fieldWidgets={this.props.fieldWidgets}
                        formatters={this.props.formatters}
                    />
                )}
                {this.props.formValues.moduleId && this.props.formValues.modelName && (
                    <FieldArray
                        name='relations'
                        component={ModelRelationsArrayField}
                        models={this.props.models}
                    />
                )}
                <div className='form-group'>
                    <div className='col-sm-offset-2 col-sm-10'>
                        <button
                            type='submit'
                            className='btn btn-success'
                        >
                            {this.getModel() ? 'Обновить модель' : 'Создать модель'}
                        </button>
                    </div>
                </div>
            </form>
        );
    }

}

const selector = formValueSelector(ModelEditor.formId);
export default __appWidget.register('\\app\\gii\\admin\\widgets\\ModelEditor\\ModelEditor', connect(
    state => ({
        formValues: {
            moduleId: selector(state, 'moduleId'),
            modelName: selector(state, 'modelName'),
        }
    })
)(reduxForm({
    form: ModelEditor.formId,
})(ModelEditor)));