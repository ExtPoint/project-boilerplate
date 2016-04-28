<?php

namespace app\auth\controllers;

use app\core\base\AppController;
use app\auth\models\PasswordResetForm;
use app\auth\models\PasswordRecoveryKeyForm;

class RecoveryController extends AppController {

    public function actions() {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ];
    }

    public function actionIndex() {
        // Write email form
        $keyForm = new PasswordRecoveryKeyForm();
        if ($keyForm->load(\Yii::$app->request->post()) && $keyForm->send()) {
            return $this->render('recovery-sent', [
                'email' => $keyForm->email
            ]);
        }

        return $this->render('recovery-form', [
            'model' => $keyForm
        ]);
    }

    public function actionCode($code) {
        // Validate code
        if (!PasswordResetForm::keyExists($code)) {
            \Yii::$app->session->addFlash('error', \Yii::t('app', 'Передаваемый вами код устарел, либо уже был использован. Воспользуйтесь, пожалуйста, формой напоминания пароля ещё раз.'));
            $this->redirect(['/auth/recovery/index']);
        }

        // Reset password form
        $resetForm = new PasswordResetForm();
        if ($resetForm->load(\Yii::$app->request->post()) && $resetForm->resetPassword($code)) {
            \Yii::$app->session->addFlash('success', \Yii::t('app', 'Пароль успешно изменен'));

            return $this->goHome();
        }

        return $this->render('reset-form', [
            'model' => $resetForm
        ]);
    }

}
