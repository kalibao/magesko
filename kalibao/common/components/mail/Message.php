<?php
/**
 * @copyright Copyright (c) 2015 Kévin Walter <walkev13@gmail.com> - Kalibao
 * @license https://github.com/kalibao/magesko/blob/master/LICENSE
 */

namespace kalibao\common\components\mail;

use Yii;
use yii\base\ErrorHandler;
use yii\base\Object;
use yii\mail\MailerInterface;

/**
 * Message implements a message class based on \yii\swiftmailer\Message.
 *
 * @package kalibao\common\components\mail
 * @version 1.0
 * @author Kevin Walter <walkev13@gmail.com>
 */
class Message extends Object
{
    /**
     * @var MailerInterface the mailer instance that created this message.
     * For independently created messages this is `null`.
     */
    public $mailer;

    /**
     * Sends this email message.
     * @param MailerInterface $mailer the mailer that should be used to send this message.
     * If no mailer is given it will first check if [[mailer]] is set and if not,
     * the "mail" application component will be used instead.
     * @return boolean whether this message is sent successfully.
     */
    public function send(MailerInterface $mailer = null)
    {
        if ($mailer === null && $this->mailer === null) {
            $mailer = Yii::$app->getMailer();
        } elseif ($mailer === null) {
            $mailer = $this->mailer;
        }
        return $mailer->send($this);
    }

    /**
     * PHP magic method that returns the string representation of this object.
     * @return string the string representation of this object.
     */
    public function __toString()
    {
        // __toString cannot throw exception
        // use trigger_error to bypass this limitation
        try {
            return $this->toString();
        } catch (\Exception $e) {
            ErrorHandler::convertExceptionToError($e);
            return '';
        }
    }

    /**
     * @inheritdoc
     */
    public function setFrom($from, $name = null)
    {
        $this->getSwiftMessage()->setFrom($from, $name);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setReplyTo($replyTo, $name)
    {
        $this->getSwiftMessage()->setReplyTo($replyTo, $name);

        return $this;
    }

    /**
     * @var \Swift_Message Swift message instance.
     */
    private $_swiftMessage;


    /**
     * @return \Swift_Message Swift message instance.
     */
    public function getSwiftMessage()
    {
        if (!is_object($this->_swiftMessage)) {
            $this->_swiftMessage = $this->createSwiftMessage();
        }

        return $this->_swiftMessage;
    }

    /**
     * @inheritdoc
     */
    public function getCharset()
    {
        return $this->getSwiftMessage()->getCharset();
    }

    /**
     * @inheritdoc
     */
    public function setCharset($charset)
    {
        $this->getSwiftMessage()->setCharset($charset);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFrom()
    {
        return $this->getSwiftMessage()->getFrom();
    }


    /**
     * @inheritdoc
     */
    public function getReplyTo()
    {
        return $this->getSwiftMessage()->getReplyTo();
    }

    /**
     * @inheritdoc
     */
    public function getTo()
    {
        return $this->getSwiftMessage()->getTo();
    }

    /**
     * @inheritdoc
     */
    public function setTo($to, $name)
    {
        $this->getSwiftMessage()->setTo($to, $name);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCc()
    {
        return $this->getSwiftMessage()->getCc();
    }

    /**
     * @inheritdoc
     */
    public function setCc($cc, $name)
    {
        $this->getSwiftMessage()->setCc($cc, $name);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getBcc()
    {
        return $this->getSwiftMessage()->getBcc();
    }

    /**
     * @inheritdoc
     */
    public function setBcc($bcc, $name)
    {
        $this->getSwiftMessage()->setBcc($bcc, $name);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getSubject()
    {
        return $this->getSwiftMessage()->getSubject();
    }

    /**
     * @inheritdoc
     */
    public function setSubject($subject)
    {
        $this->getSwiftMessage()->setSubject($subject);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTextBody($text)
    {
        $this->setBody($text, 'text/plain');

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setHtmlBody($html)
    {
        $this->setBody($html, 'text/html');

        return $this;
    }

    /**
     * Sets the message body.
     * If body is already set and its content type matches given one, it will
     * be overridden, if content type miss match the multipart message will be composed.
     * @param string $body body content.
     * @param string $contentType body content type.
     */
    protected function setBody($body, $contentType)
    {
        $message = $this->getSwiftMessage();
        $oldBody = $message->getBody();
        $charset = $message->getCharset();
        if (empty($oldBody)) {
            $parts = $message->getChildren();
            $partFound = false;
            foreach ($parts as $key => $part) {
                if (!($part instanceof \Swift_Mime_Attachment)) {
                    /* @var $part \Swift_Mime_MimePart */
                    if ($part->getContentType() == $contentType) {
                        $charset = $part->getCharset();
                        unset($parts[$key]);
                        $partFound = true;
                        break;
                    }
                }
            }
            if ($partFound) {
                reset($parts);
                $message->setChildren($parts);
                $message->addPart($body, $contentType, $charset);
            } else {
                $message->setBody($body, $contentType);
            }
        } else {
            $oldContentType = $message->getContentType();
            if ($oldContentType == $contentType) {
                $message->setBody($body, $contentType);
            } else {
                $message->setBody(null);
                $message->setContentType(null);
                $message->addPart($oldBody, $oldContentType, $charset);
                $message->addPart($body, $contentType, $charset);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attach($fileName, array $options = [])
    {
        $attachment = \Swift_Attachment::fromPath($fileName);
        if (!empty($options['fileName'])) {
            $attachment->setFilename($options['fileName']);
        }
        if (!empty($options['contentType'])) {
            $attachment->setContentType($options['contentType']);
        }
        $this->getSwiftMessage()->attach($attachment);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function attachContent($content, array $options = [])
    {
        $attachment = \Swift_Attachment::newInstance($content);
        if (!empty($options['fileName'])) {
            $attachment->setFilename($options['fileName']);
        }
        if (!empty($options['contentType'])) {
            $attachment->setContentType($options['contentType']);
        }
        $this->getSwiftMessage()->attach($attachment);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function embed($fileName, array $options = [])
    {
        $embedFile = \Swift_EmbeddedFile::fromPath($fileName);
        if (!empty($options['fileName'])) {
            $embedFile->setFilename($options['fileName']);
        }
        if (!empty($options['contentType'])) {
            $embedFile->setContentType($options['contentType']);
        }

        return $this->getSwiftMessage()->embed($embedFile);
    }

    /**
     * @inheritdoc
     */
    public function embedContent($content, array $options = [])
    {
        $embedFile = \Swift_EmbeddedFile::newInstance($content);
        if (!empty($options['fileName'])) {
            $embedFile->setFilename($options['fileName']);
        }
        if (!empty($options['contentType'])) {
            $embedFile->setContentType($options['contentType']);
        }

        return $this->getSwiftMessage()->embed($embedFile);
    }

    /**
     * @inheritdoc
     */
    public function toString()
    {
        return $this->getSwiftMessage()->toString();
    }

    /**
     * Creates the Swift email message instance.
     * @return \Swift_Message email message instance.
     */
    protected function createSwiftMessage()
    {
        return new \Swift_Message();
    }
}
