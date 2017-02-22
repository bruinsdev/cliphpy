<?php

namespace Cliphpy;

class Sentry extends Element
{
    /**
     * @param string $signal
     */
    public function close($signal)
    {
    }

    public function init()
    {
        $this->client = new \Raven_Client($this->config->sentryCdn);
    }

    /**
     * @param string $msg
     */
    public function captureMessage($msg)
    {
        $idEvent = $this->client->getIdent($this->client->captureMessage($msg,
        $this->getProperties()));
        $this->logCaptureMessage($idEvent, $msg);
    }

    /**
     * @param Exception $ex
     */
    public function captureException(\Exception $ex)
    {
        $idEvent = $this->client->getIdent($this->client->captureException($ex,
        $this->getProperties()));
        $this->logCaptureException($idEvent, $ex->getMessage());
    }

    private function getProperties()
    {
        return [
            'tags' => [
                'php_version' => phpversion(),
                'environment' => $this->config->getEnvironment(),
            ],
        ];
    }

    /**
     * @param string $idEvent
     * @param string $message
     */
    private function logCaptureMessage($idEvent, $message)
    {
        $this->logCaptureEvent($idEvent, $message, 'message');
    }

    /**
     * @param string $idEvent
     * @param string $message
     */
    private function logCaptureException($idEvent, $message)
    {
        $this->logCaptureEvent($idEvent, $message, 'exception');
    }

    /**
     * @param string $idEvent
     * @param string $message
     * @param string $type
     */
    private function logCaptureEvent($idEvent, $message, $type)
    {
        if (true === is_object($this->log) && property_exists($this->log, 'info')
        ) {
            $format = 'Sentry %s captured, idEvent %s, message: %s';
            $msg = sprintf($format, $type, $idEvent, $message);
            $this->log->info($msg);
        }
    }
}
