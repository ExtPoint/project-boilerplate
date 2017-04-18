<?php

namespace app\example\types\models\meta;

use app\core\base\AppModel;
use extpoint\yii2\file\models\File;
use app\example\types\models\Player;
use extpoint\yii2\behaviors\TimestampBehavior;
use arogachev\ManyToMany\behaviors\ManyToManyBehavior;
use yii\db\ActiveQuery;

/**
 * @property string $id
 * @property string $createTime
 * @property string $updateTime
 * @property string $title
 * @property string $shortDescription
 * @property string $fullDescription
 * @property integer $rating
 * @property boolean $isDisabled
 * @property string $price
 * @property string $tillDate
 * @property integer $logoId
 * @property integer $winExeId
 * @property integer $macDmgId
 * @property integer $creatorId
 * @property-read File $logo
 * @property-read File[] $photos
 * @property-read File $winExe
 * @property-read File $macDmg
 * @property-read File[] $documents
 * @property-read Player $creator
 * @property-read Player[] $players
 */
abstract class GameMeta extends AppModel
{
    public $photoIds = [];
    public $documentIds = [];
    public $playersIds = [];

    public static function tableName()
    {
        return 'example_types_games';
    }

    public function rules()
    {
        return [
            [['createTime', 'updateTime', 'tillDate', 'photoIds', 'documentIds', 'playersIds'], 'safe'],
            [['title', 'shortDescription', 'fullDescription'], 'string'],
            [['rating', 'logoId', 'winExeId', 'macDmgId', 'creatorId'], 'integer'],
            [['isDisabled'], 'boolean'],
            [['price'], 'number'],
            ['logo', 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['logoId' => 'id']],
            ['winExe', 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['winExeId' => 'id']],
            ['macDmg', 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['macDmgId' => 'id']],
            ['creator', 'exist', 'skipOnError' => true, 'targetClass' => Player::className(), 'targetAttribute' => ['creatorId' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    [
                        'name' => 'photos',
                        'editableAttribute' => 'photoIds',
                        'autoFill' => false
                    ],
                    [
                        'name' => 'documents',
                        'editableAttribute' => 'documentIds',
                        'autoFill' => false
                    ],
                    [
                        'name' => 'players',
                        'editableAttribute' => 'playersIds',
                        'autoFill' => false
                    ]
                ]
            ],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getLogo()
    {
        return $this->hasOne(File::className(), ['id' => 'logoId']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPhotos()
    {
        return $this->hasMany(File::className(), ['id' => 'fileId'])
            ->viaTable('example_types_games_photos', ['gameId' => 'photoIds']);
    }

    /**
     * @return ActiveQuery
     */
    public function getWinExe()
    {
        return $this->hasOne(File::className(), ['id' => 'winExeId']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMacDmg()
    {
        return $this->hasOne(File::className(), ['id' => 'macDmgId']);
    }

    /**
     * @return ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(File::className(), ['id' => 'fileId'])
            ->viaTable('example_types_games_documents', ['gameId' => 'documentIds']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(Player::className(), ['id' => 'creatorId']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPlayers()
    {
        return $this->hasMany(Player::className(), ['id' => 'playerId'])
            ->viaTable('example_types_games_players', ['gameId' => 'id']);
    }

    public static function meta()
    {
        return [
            'id' => [
                'label' => 'ID',
                'appType' => 'primaryKey',
                'showInTable' => true,
                'showInView' => true
            ],
            'createTime' => [
                'label' => 'Дата создания',
                'appType' => 'autoTime',
                'showInTable' => true,
                'showInView' => true
            ],
            'updateTime' => [
                'label' => 'Дата обновления',
                'appType' => 'autoTime',
                'showInView' => true,
                'touchOnUpdate' => true
            ],
            'title' => [
                'label' => 'Название',
                'showInForm' => true,
                'showInTable' => true,
                'showInView' => true
            ],
            'shortDescription' => [
                'label' => 'Краткое описание',
                'appType' => 'text',
                'showInForm' => true,
                'showInTable' => true,
                'showInView' => true
            ],
            'fullDescription' => [
                'label' => 'Полное описание',
                'appType' => 'html',
                'showInForm' => true,
                'showInView' => true
            ],
            'rating' => [
                'label' => 'Рейтинг',
                'appType' => 'integer',
                'showInForm' => true,
                'showInView' => true
            ],
            'isDisabled' => [
                'label' => 'Отключен?',
                'appType' => 'boolean',
                'showInForm' => true,
                'showInView' => true
            ],
            'price' => [
                'label' => 'Цена (руб)',
                'appType' => 'currency',
                'showInForm' => true,
                'showInTable' => true,
                'showInView' => true,
                'currency' => 'RUB'
            ],
            'tillDate' => [
                'label' => 'Активен "до"',
                'appType' => 'date',
                'showInForm' => true,
                'showInView' => true,
                'format' => 'php:Y.d.m'
            ],
            'logoId' => [
                'label' => 'Логотип',
                'appType' => 'file',
                'showInForm' => true,
                'showInTable' => true,
                'showInView' => true
            ],
            'photoIds' => [
                'label' => 'Фотографии',
                'appType' => 'files',
                'showInForm' => true,
                'showInView' => true,
                'relationName' => 'photos'
            ],
            'winExeId' => [
                'label' => 'Скачать (win)',
                'appType' => 'file',
                'showInForm' => true,
                'showInView' => true
            ],
            'macDmgId' => [
                'label' => 'Скачать (mac)',
                'appType' => 'file',
                'showInForm' => true,
                'showInView' => true
            ],
            'documentIds' => [
                'label' => 'Инструкции',
                'appType' => 'files',
                'showInForm' => true,
                'showInView' => true,
                'relationName' => 'documents'
            ],
            'creatorId' => [
                'label' => 'Игру добавил',
                'appType' => 'relation',
                'showInForm' => true,
                'showInView' => true,
                'relationName' => 'creator'
            ],
            'playersIds' => [
                'label' => 'Игроки',
                'appType' => 'relation',
                'showInForm' => true,
                'showInView' => true,
                'relationName' => 'players'
            ]
        ];
    }
}
