<?php
            use yii\db\Migration;
            class m160419_085655_add_text_text-sample extends Migration
            {
                public function up()
                {
                    $this->insert('contents', [
                        'uid' => '1eb773d2-a127-446e-9af6-22e391b7924d',
                        'creatorUserUid' => '666b0a97-e36e-4bd9-b31e-babf3216cef0',
                        'type' => 'text',
                        'name' => 'text-sample',
                        'title' => 'Sample',
                        'text' => '<p>Some text.</p>
',
                        'isPublished' => '1',
                        'publishTime' => '2016-04-19 08:56:00',
                        'createTime' => '2016-04-19 08:56:55',
                        'updateTime' => '2016-04-19 08:56:55',
                    ]);
                }
                public function down() {
                    $this->delete('contents', ['uid' => '1eb773d2-a127-446e-9af6-22e391b7924d']);
                }
            }
        