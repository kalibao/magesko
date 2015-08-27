<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\mail;

use Yii;
use yii\base\Component;
use yii\base\Exception;
use kalibao\common\models\mailTemplate\MailTemplate as ModelMailTemplate;
use kalibao\common\models\mailSendingRole\MailSendingRole;

/**
 * Class MailTemplate provide a component to send mail template
 *
 * @version 1.0
 * @package kalibao\common\components\i18n
 * @author Kévin Walter <walkev13@gmail.com>
 */
class MailTemplate extends Component
{
    /**
     * @var Array of parameters used to build the request
     */
    public $sqlParams = [];

    /**
     * @var Array of parameters used to build the mail
     */
    public $staticParams = [];

    /**
     * @var Array of file path to include
     */
    public $filesPath = [];

    /**
     * @var Array of sending information
     */
    public $sending = [
        'from' => [/* 'EMAIL', 'NAME'|null */],
        'to' => [/* [EMAIL, 'NAME'|null], [EMAIL2, 'NAME'|null], ..., [EMAIL3, 'NAME'|null] */],
        'cc' => [/* [EMAIL, 'NAME'|null], [EMAIL2, 'NAME'|null], ..., [EMAIL3, 'NAME'|null] */],
        'bcc' => [/* [EMAIL, 'NAME'|null], [EMAIL2, 'NAME'|null], ..., [EMAIL3, 'NAME'|null] */],
    ];

    /**
     * @var boolean Enable code parsing to execute static functions
     */
    public $parseToExecute = true;

    /**
     * Class name contained functions to execute
     */
    public $classFunction = 'kalibao\common\components\mail\MailFunction';

    /**
     * @var Reply email
     */
    public $replyTo = [/* 'EMAIL', 'NAME'|null */];

    private $mailer;

    /**
     * Get mailer instance
     */
    public function getMailer()
    {
        if ($this->mailer === null) {
            $this->mailer = Yii::$app->mailer;
        }
        return $this->mailer;
    }

    /**
     * Set mailer instance
     * @param mixed $mailer
     */
    public function setMailer($mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send an email using a specific mail template
     *
     * @param int $id mail template ID
     * @param string $language i18n ID
     * @throws Exception
     * @return bool return true if message is correctly sent else false
     */
    public function sendMailTemplate($id, $language)
    {
        $mailMessage = $this->getMailer()->compose();

        // get mail template
        $mailTemplate = ModelMailTemplate::find()
            ->with([
                'mailTemplateI18ns' => function ($query) use($language)  {
                    $query
                        ->select(['mail_template_id', 'object', 'message'])
                        ->onCondition(['mail_template_i18n.i18n_id' => $language]);
                }
            ])
            ->where(['id' => $id])
            ->one();


        if ($mailTemplate === null) {
            throw new Exception('Mail template does not exists');
        } elseif (!isset($mailTemplate->mailTemplateI18ns[0])) {
            throw new Exception('Translate of mail template does not exists');
        }

        // get sending roles
        $sendingRoles = MailSendingRole::find()
            ->with('person')
            ->where(['mail_template_id' => $mailTemplate->id])
            ->all();

        $mailObject = $mailTemplate->mailTemplateI18ns[0]->object;
        $mailBody = $mailTemplate->mailTemplateI18ns[0]->message;

        // replace static parameters
        foreach ($this->staticParams as $param => $value) {
            $mailObject = str_replace('{' . $param . '}', $value, $mailObject);
            $mailBody = str_replace('{' . $param . '}', $value, $mailBody);
        }

        if ($mailTemplate->sql_request != '') {
            // build sql parameters
            $params = empty($this->sqlParams) ? $this->buildSqlParams($mailTemplate->sql_param) : $this->sqlParams;
            if (empty($params)) {
                throw new Exception('Sql parameters are empty');
            }

            // execute query
            $command = Yii::$app->db->createCommand($mailTemplate->sql_request);
            foreach ($params as $param => $value) {
                $command->bindParam(':' . $param, $value);
            }
            $results = $command->queryOne();

            if (empty($results)) {
                throw new Exception(Yii::t('kalibao', 'mail_template_request_error'));
            }

            // exception
            foreach ($results as $attributeName => $attributeValue) {
                $mailObject = str_replace('{' . $attributeName . '}', $attributeValue, $mailObject);
                $mailBody = str_replace('{' . $attributeName . '}', $attributeValue, $mailBody);
                if ($attributeName === Yii::$app->variable->get('kalibao', 'mail_template_sql_alias_mailto') && $attributeValue != '') {
                    $this->sending['to'][] = [$attributeValue];
                } elseif ($attributeName === Yii::$app->variable->get('kalibao', 'mail_template_sql_alias_mailfrom') && $attributeValue != '') {
                    $this->sending['from'][0] = $attributeValue;
                } elseif ($attributeName === Yii::$app->variable->get('kalibao', 'mail_template_sql_alias_sender') && $attributeValue != '') {
                    $this->sending['from'][1] = $attributeValue;
                }
            }
        }

        if (!empty($this->replyTo)) {
            $mailMessage->setReplyTo($this->replyTo[0], isset($this->replyTo[1]) ? $this->replyTo[1] : null);
        }

        if ($this->parseToExecute) {
            $mailBody = self::parseMailFunction($mailBody, $this->classFunction);
        }

        $mailBodyHtml = '';
        if ($mailTemplate->html_mode == 1) {
            $mailBodyHtml = $mailBody;
        }

        // add attachment
        foreach ($this->filesPath as $path) {
            $mailMessage->attach($path);
        }

        $mailMessage->setSubject($mailObject);
        if ($mailBodyHtml != '') {
            $mailMessage->setHtmlBody(utf8_decode($mailBodyHtml));
            $mailMessage->setTextBody(strip_tags(html_entity_decode($mailBodyHtml)));
        } else {
            $mailMessage->setTextBody(utf8_decode($mailBody));
        }

        $variable = Yii::$app->variable;
        foreach ($sendingRoles as $sendingRole) {
            switch ($sendingRole->mail_send_role_id) {
                case $variable->get('kalibao', 'send_role_id:from'):
                    $this->sending['from'][0] = $sendingRole->person->email;
                    break;
                case $variable->get('kalibao', 'send_role_id:to'):
                    $this->sending['to'][] = [$sendingRole->person->email];
                    break;
                case $variable->get('kalibao', 'send_role_id:cc'):
                    $this->sending['cc'][] = [$sendingRole->person->email];
                    break;
                case $variable->get('kalibao', 'send_role_id:bcc'):
                    $this->sending['bcc'][] = [$sendingRole->person->email];
                    break;
            }
        }

        $mailMessage->setFrom($this->sending['from'][0], isset($this->sending['from'][1]) ? $this->sending['from'][1] : null);
        if (!empty($this->sending['to'])) {
            foreach ($this->sending['to'] as $to) {
                $mailMessage->setTo($to[0], isset($to[1]) ? $to[1] : null);
            }
        }
        if (!empty($this->sending['cc'])) {
            foreach ($this->sending['cc'] as $cc) {
                $mailMessage->setCc($cc[0], isset($cc[1]) ? $cc[1] : null);
            }
        }
        if (!empty($this->sending['bcc'])) {
            foreach ($this->sending['bcc'] as $bcc) {
                $mailMessage->setBcc($bcc[0], isset($bcc[1]) ? $bcc[1] : null);
            }
        }

        return $mailMessage->Send();
    }

    /**
     * Extract params from mail functions.
     * The separator character used is "|"
     * @param string $string
     * @return array
     */
    public static function extractParamsMailFunction($string)
    {
        $params = explode('|', $string);
        return $params;
    }

    /**
     * Build sql parameters
     * @param string $value string to transform
     * @return mixed array of parameters array( array(0 => id, 1 => value), array(0 => id, 1 => value), ...)
     */
    public function buildSqlParams($value)
    {
        $params = [];
        $tmpParams = explode('&', $value);
        if (count($tmpParams) > 1) {
            foreach ($tmpParams as $param) {
                $exParam = explode('=', $param);
                if (count($exParam) == 2) {
                    $params[$exParam[0]] = $exParam[1];
                }
            }
        }
        return $params;
    }

    /**
     * Parse string in order to find functions to execute
     * Functions are contained in the class $classFunction
     *
     * @param string $string string to parse
     * @param string $classFunction class name contained functions to execute
     * @return string
     */
    protected static function parseMailFunction($string, $classFunction)
    {
        $list = [];
        preg_match_all("#\{(.*)\((.*)\)\}#msU", $string, $list, PREG_SET_ORDER);
        $find = [];
        $replace = [];
        foreach ($list as $function) {
            $find[] = '{' . $function[1] . '(' . $function[2] . ')}';
            $replace[] = $classFunction::$function[1]($function[2]);
        }
        return str_replace($find, $replace, $string);
    }
} 