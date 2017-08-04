import React from 'react';

import ListView from 'extpoint-yii2/list/ListView';
import GridView from 'extpoint-yii2/list/GridView';

export default class GameForm extends React.Component {

    render() {
        const items = [
            {
                id: 1,
                title: 'aaa',
            },
            {
                id: 2,
                title: 'bbb',
            },
            {
                id: 3,
                title: 'ccc',
            },
        ];

        return (
            <div className='row'>
                <div className='col-sm-offset-2 col-sm-8'>
                    <ListView
                        id='list1'
                        items={items}
                        itemComponent={({item}) => (
                            <div>
                                #{item.id} {item.title}
                            </div>
                        )}
                    />
                    <GridView
                        id='list2'
                        items={items}
                        search={{
                            fields: [
                                {
                                    attribute: 'title',
                                }
                            ]
                        }}
                        columns={[
                            {
                                title: 'ID',
                                attribute: 'id',
                            },
                            {
                                title: 'Title',
                                attribute: 'title',
                            },
                        ]}
                    />
                </div>
            </div>
        );
    }
}