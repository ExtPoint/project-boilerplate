import React from 'react';

import GameMeta from '../models/GameMeta';
import Form from 'extpoint-yii2/form/Form';
import Field from 'extpoint-yii2/form/Field';

export default class GameForm extends React.Component {

    render() {
        return (
            <div className='row'>
                <div className='col-sm-offset-1 col-sm-4'>
                    <Form
                        formId='GameForm-default'
                        model={GameMeta}
                        layoutCols={[3,6]}
                    >
                        {this.renderFields()}
                    </Form>
                </div>
                <div className='col-sm-6'>
                    <Form
                        formId='GameForm-horizontal'
                        modelMeta={GameMeta}
                        layout='horizontal'
                        layoutCols={[3,6]}
                    >
                        {this.renderFields()}
                    </Form>
                </div>
            </div>
        );
    }

    renderFields() {
        const meta = GameMeta.meta();
        return Object.keys(meta).map(attribute => (
            <Field
                key={attribute}
                attribute={attribute}
                {...meta[attribute].componentProps}
            />
        ));
    }
}