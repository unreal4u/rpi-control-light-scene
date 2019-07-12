<?php

declare(strict_types=1);

namespace unreal4u\ControlLightTrio;

use PiPHP\GPIO\GPIO;
use PiPHP\GPIO\Pin\InputPin;
use PiPHP\GPIO\Pin\InputPinInterface;
use PiPHP\GPIO\Pin\OutputPin;
use PiPHP\GPIO\Pin\PinInterface;
use unreal4u\rpiCommonLibrary\Base;
use unreal4u\rpiCommonLibrary\JobContract;

class ReadStateFile extends Base {
    /**
     * FALSE: lamp is off, TRUE: lamp is on
     * @var bool
     */
    private $currentState = false;

    /**
     * OutputPin
     */
    private $relayPin;

    /**
     * @var string
     */
    private $stateFileLocation;

    /**
     * @var int
     */
    private $lastStateFileModification;

    /**
     * Will be executed once before running the actual job
     *
     * @return JobContract
     */
    public function setUp(): JobContract
    {
	$this->stateFileLocation = __DIR__ . '/../state/current.state';

        return $this;
    }

    public function configure()
    {
        $this
            ->setName('light-trio:read-state-file')
            ->setDescription('Turn the lights off or on depending on the state of the statefile')
            ->setHelp('Reads out the state file and turns the light on or off, notifying the broker as well')
        ;
    }

    /**
     * Runs the actual job that needs to be executed
     *
     * @return bool Returns true if job was successful, false otherwise
     */
    public function runJob(): bool
    {
        $run = true;
        $mqttCommunicator = $this->communicationsFactory('MQTT');
	
	while ($run === true) {
            $statInformation = stat($this->stateFileLocation);
            if ($statInformation['mtime'] > $this->lastStateFileModification) {
		$this->lastStateFileModification = $statInformation['mtime'];
		$fileContents = file_get_contents($this->stateFileLocation);
		$mqttCommunicator->sendMessage('commands/singlelamp/Power1', $fileContents);
		$mqttCommunicator->sendMessage('commands/doublelamp/Power1', $fileContents);
            }
            usleep(100000);
	    clearstatcache();
        }
        return true;
    }

    /**
     * If method runJob returns false, this will return an array with errors that may have happened during execution
     *
     * @return \Generator
     */
    public function retrieveErrors(): \Generator
    {
        yield '';
    }

    /**
     * The number of seconds after which this script should kill itself
     *
     * @return int
     */
    public function forceKillAfterSeconds(): int
    {
        return 1;
    }

    /**
     * The loop should run after this amount of microseconds (1 second === 1000000 microseconds)
     *
     * @return int
     */
    public function executeEveryMicroseconds(): int
    {
        return 0;
    }
}
