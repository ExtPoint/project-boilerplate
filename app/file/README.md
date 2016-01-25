# File module


## Add file field to model (one file)

1. Add string(36) attribute to model
2. Add field to form:

```php
<?= $form->field($model, 'photo')->widget(\app\file\widgets\fileup\FileInput::className()) ?>
```

## Add file field to model (multiple files)

1. Add long string or array attribute to model. File widget automatically detected field format.
2. Add field to form:

```php
<?= $form->field($model, 'attachments')->widget(\app\file\widgets\fileup\FileInput::className(), ['multiple' => true]) ?>
```

## Get file by uid:

```php
\app\file\models\File::findOne($uid)->getDownloadUrl()
```
