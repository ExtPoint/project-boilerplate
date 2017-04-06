import React, {PropTypes} from 'react';
import {connect} from 'react-redux';
import {Field, formValueSelector} from 'redux-form';

class ModelRelationsArrayField extends React.Component {

    static formId = 'ModelEditor';

    static propTypes = {
        fields: PropTypes.object,
        dbTypes: PropTypes.arrayOf(PropTypes.string),
        fieldWidgets: PropTypes.arrayOf(PropTypes.shape({
            name: PropTypes.string
        })),
        formatters: PropTypes.arrayOf(PropTypes.shape({
            name: PropTypes.string
        })),
        formValues: PropTypes.object,
        models: PropTypes.array,
    };

    constructor() {
        super(...arguments);

        this.state = {
            relationFocuses: {},
            selfFocuses: {},
        };
    }

    render() {
        return (
            <div className='form-inline'>
                <h3>
                    Relations
                </h3>
                <datalist id={`${ModelRelationsArrayField.formId}_allModelNameList`}>
                    {this.props.models.map(model => (
                        <option key={model.className} value={model.className} />
                    ))}
                </datalist>
                <datalist id={`${ModelRelationsArrayField.formId}_selfAttributesList`}>
                    {this.props.formValues.meta.map(item => (
                        <option key={item.name} value={item.name} />
                    ))}
                </datalist>
                <table className='table table-striped'>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Relation key</th>
                        <th>Self key</th>
                        <th />
                        <th />
                    </tr>
                    </thead>
                    <tbody>
                    {this.props.fields.map((attribute, index) => (
                        <tr key={index}>
                            <td>
                                {index+1}
                            </td>
                            <td>
                                <Field
                                    name={`${attribute}[type]`}
                                    component='select'
                                    className='form-control input-sm'
                                >
                                    <option value='hasOne'>hasOne</option>
                                    <option value='hasMany'>hasMany</option>
                                    <option value='manyToMany'>manyToMany</option>
                                </Field>
                            </td>
                            <td>
                                <Field
                                    name={`${attribute}[name]`}
                                    component='input'
                                    className='form-control input-sm'
                                    placeholder='Name'
                                    style={{width: 100}}
                                />
                            </td>
                            <td className={this._isFocused(index, true) ? 'bg-success' : ''}>
                                <datalist id={`${ModelRelationsArrayField.formId}_${index}_relationAttributesList`}>
                                    {this._getModelMeta(index).map(item => (
                                        <option key={item.name} value={item.name} />
                                    ))}
                                </datalist>
                                <Field
                                    name={`${attribute}[relationModelClassName]`}
                                    component='input'
                                    className='form-control input-sm'
                                    list={`${ModelRelationsArrayField.formId}_allModelNameList`}
                                    placeholder='Model class'
                                    style={{width: 200}}
                                />
                                &nbsp;.&nbsp;
                                <Field
                                    name={`${attribute}[relationKey]`}
                                    component='input'
                                    className='form-control input-sm'
                                    list={`${ModelRelationsArrayField.formId}_${index}_relationAttributesList`}
                                    style={{width: 100}}
                                    placeholder='Key'
                                />
                            </td>
                            <td className={this._isFocused(index, false) ? 'bg-success' : ''}>
                                <input
                                    className='form-control input-sm'
                                    defaultValue={this.props.formValues.modelName}
                                    disabled={true}
                                />
                                &nbsp;.&nbsp;
                                <Field
                                    name={`${attribute}[selfKey]`}
                                    component='input'
                                    className='form-control input-sm'
                                    placeholder='Key'
                                    list={`${ModelRelationsArrayField.formId}_selfAttributesList`}
                                    style={{width: 100}}
                                />
                            </td>
                            <td>
                                {this._getType(index) === 'manyToMany' && (
                                    <span>
                                        <Field
                                            name={`${attribute}[viaTable]`}
                                            component='input'
                                            list={`${ModelRelationsArrayField.formId}_tableNameList`}
                                            className='form-control input-sm'
                                            placeholder='Table name'
                                        />
                                        &nbsp;
                                        <span className={this._isFocused(index, true) ? 'has-success' : ''}>
                                            <Field
                                                name={`${attribute}[viaRelationKey]`}
                                                component='input'
                                                className={'form-control input-sm' + (this._isFocused(index, true) ? ' bg-success' : '')}
                                                placeholder='Key'
                                                onFocus={() => this._setFocus(index, true, true)}
                                                onBlur={() => this._setFocus(index, true, false)}
                                                style={{width: 100}}
                                            />
                                        </span>
                                        &nbsp;
                                        <span className={this._isFocused(index, false) ? 'has-success' : ''}>
                                            <Field
                                                name={`${attribute}[viaSelfKey]`}
                                                component='input'
                                                className='form-control input-sm'
                                                placeholder='Key'
                                                onFocus={() => this._setFocus(index, false, true)}
                                                onBlur={() => this._setFocus(index, false, false)}
                                                style={{width: 100}}
                                            />
                                        </span>
                                    </span>
                                )}
                            </td>
                            <td>
                                <button
                                    className={'btn btn-primary'}
                                    onClick={() => this.props.fields.remove(index)}
                                >
                                    <span className='glyphicon glyphicon-remove' />
                                </button>
                            </td>
                        </tr>
                    ))}
                    </tbody>
                </table>
                <div>
                    <a
                        className='btn btn-sm btn-primary'
                        href='javascript:void(0)'
                        onClick={() => this.props.fields.push()}
                    >
                        <span className='glyphicon glyphicon-plus' /> Добавить
                    </a>
                </div>
            </div>
        );
    }

    _isFocused(index, isRelation) {
        const key = isRelation ? 'relationFocuses' : 'selfFocuses';
        return this.state[key][index] === true;
    }

    _setFocus(index, isRelation, isFocus) {
        const key = isRelation ? 'relationFocuses' : 'selfFocuses';
        this.setState({
            [key]: {
                ...this.state[key],
                [index]: isFocus,
            },
        });
    }

    _getType(index) {
        return this.props.formValues.relations[index] && this.props.formValues.relations[index].type || null;
    }

    _getModelMeta(index) {
        const relationModelClassName = this.props.formValues.relations[index] && this.props.formValues.relations[index].relationModelClassName || null;
        const model = this.props.models.find(model => model.className === relationModelClassName);
        return model ? model.meta : [];
    }

}

const selector = formValueSelector(ModelRelationsArrayField.formId);
export default connect(
    state => ({
        formValues: {
            modelName: selector(state, 'modelName'),
            meta: selector(state, 'meta'),
            relations: selector(state, 'relations'),
        }
    })
)(ModelRelationsArrayField);