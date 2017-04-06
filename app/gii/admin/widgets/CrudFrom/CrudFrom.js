import React, {PropTypes} from 'react';
import {connect} from 'react-redux';
import {Field, reduxForm, formValueSelector} from 'redux-form';

class CrudFrom extends React.Component {

    static formId = 'CrudFrom';

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
        formValues: PropTypes.object,
        csrfToken: PropTypes.string,
    };

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
                            list={`${CrudFrom.formId}_moduleIdList`}
                            className='form-control'
                        />
                        <datalist id={`${CrudFrom.formId}_moduleIdList`}>
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
                            list={`${CrudFrom.formId}_modelNameList`}
                            className='form-control'
                        />
                        <datalist id={`${CrudFrom.formId}_modelNameList`}>
                            {this.props.models.filter(model => model.module === this.props.formValues.moduleId).map(model => (
                                <option key={model.name} value={model.name} />
                            ))}
                        </datalist>
                    </div>
                </div>
                <div className='form-group'>
                    <label className='col-sm-2 control-label'>
                        Name
                    </label>
                    <div className='col-sm-10'>
                        <Field
                            name='name'
                            component='input'
                            className='form-control'
                        />
                    </div>
                </div>
                <div className='form-group'>
                    <div className='col-sm-offset-2 col-sm-10'>
                        <button
                            type='submit'
                            className='btn btn-success'
                        >
                            {'Создать'}
                        </button>
                    </div>
                </div>
            </form>
        );
    }

}

const selector = formValueSelector(CrudFrom.formId);
export default __appWidget.register('\\app\\gii\\admin\\widgets\\CrudFrom\\CrudFrom', connect(
    state => ({
        formValues: {
            moduleId: selector(state, 'moduleId'),
            modelName: selector(state, 'modelName'),
        }
    })
)(reduxForm({
    form: CrudFrom.formId,
})(CrudFrom)));