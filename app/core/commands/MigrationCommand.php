<?php

namespace app\core\commands;

use yii\console\Exception;
use yii\helpers\Console;

class MigrationCommand extends \bariew\moduleMigration\ModuleMigrateController {

    public $migrationPath = '@app';

    /**
     * @inheritdoc
     */
    public function actionCreate($name, $module='core')
    {
        if (!preg_match('/^\w+$/', $name)) {
            throw new Exception("The migration name should contain letters, digits and/or underscore characters only.");
        }

        $name = 'm' . gmdate('ymd_His') . '_' . $name;
        $dir = $this->migrationPath . DIRECTORY_SEPARATOR . $module . DIRECTORY_SEPARATOR . 'migrations' . DIRECTORY_SEPARATOR;
        $file = $dir . $name . '.php';

        if ($this->confirm("Create new migration '$file'?")) {
            $content = $this->renderFile(\Yii::getAlias($this->templateFile), ['className' => $name]);
            if (!is_dir($dir)) {
                mkdir($dir);
                chmod($dir, 0775);
            }
            file_put_contents($file, $content);
            $this->stdout("New migration created successfully.\n", Console::FG_GREEN);
        }
    }

}