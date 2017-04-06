import React, {PropTypes} from 'react';
import {Field} from 'redux-form';

export default class ModelMetaArrayField extends React.Component {

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
    };

    render() {
        return (
            <div className='form-inline'>
                <h3>
                    Attributes meta information
                </h3>
                <datalist id={`${ModelMetaArrayField.formId}_dbTypeList`}>
                    {this.props.dbTypes.map(value => (
                        <option key={value} value={value} />
                    ))}
                </datalist>
                <datalist id={`${ModelMetaArrayField.formId}_fieldWidgetList`}>
                    {this.props.fieldWidgets.map(value => (
                        <option key={value.name} value={value.name} />
                    ))}
                </datalist>
                <datalist id={`${ModelMetaArrayField.formId}_formatterList`}>
                    {this.props.formatters.map(value => (
                        <option key={value.name} value={value.name} />
                    ))}
                </datalist>
                <table className='table table-striped'>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Label</th>
                        <th>Hint</th>
                        <th>DB Type</th>
                        <th>Not Null</th>
                        <th>Field Widget</th>
                        <th>Formatter</th>
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
                                    name={`${attribute}[name]`}
                                    component='input'
                                    className='form-control input-sm'
                                />
                            </td>
                            <td>
                                <Field
                                    name={`${attribute}[label]`}
                                    component='input'
                                    className='form-control input-sm'
                                />
                            </td>
                            <td>
                                <Field
                                    name={`${attribute}[hint]`}
                                    component='input'
                                    className='form-control input-sm'
                                />
                            </td>
                            <td>
                                <Field
                                    name={`${attribute}[dbType]`}
                                    component='input'
                                    className='form-control input-sm'
                                    placeholder='string'
                                    list={`${ModelMetaArrayField.formId}_dbTypeList`}
                                />
                            </td>
                            <td>
                                <div className='checkbox'>
                                    <label>
                                        <Field
                                            name={`${attribute}[notNull]`}
                                            component='input'
                                            type='checkbox'
                                        />
                                    </label>
                                </div>
                            </td>
                            <td>
                                <Field
                                    name={`${attribute}[fieldWidget]`}
                                    component='input'
                                    className='form-control input-sm'
                                    placeholder='textInput'
                                    list={`${ModelMetaArrayField.formId}_fieldWidgetList`}
                                />
                            </td>
                            <td>
                                <Field
                                    name={`${attribute}[formatter]`}
                                    component='input'
                                    className='form-control input-sm'
                                    placeholder='text'
                                    list={`${ModelMetaArrayField.formId}_formatterList`}
                                />
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

}
