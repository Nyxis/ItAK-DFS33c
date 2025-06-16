<?php

class Docker
{
    private array $images;

    public function __construct(
        Image ...$images
    ) {
        $this->images = $images;
    }

    public function run()
    {
        foreach ($this->images as $image) {
            new Container($image);
        }
    }
}

abstract class Image
{
    public function __construct(
        public readonly string $programme
    ) {
    }

    abstract public function runScript();
}

class Container
{
    public function __construct(
        private Image $image
    ){
        var_dump($image);
        echo sprintf("----- runing image of type %s  -----\n", $image->programme);
        $image->runScript();
    }
}

class Pedro extends Image
{
    public function __construct()
    {
        parent::__construct('Pedro');
    }

    public function runScript()
    {
        echo "<3\n";
    }
}

class Anne extends Image
{
    public function __construct()
    {
        parent::__construct('Anne');
    }

    public function runScript()
    {
        echo "06.......\n";
    }
}

class JeanDidier extends Image
{
    public function runScript()
    {
        return $this->lancerInstruction();
    }

    public function lancerInstruction()
    {
        echo "Il y a pas de changement climatique, il a gelé à Paris 16\n";
    }
}


$docker = new Docker(
    new Pedro,
    new Anne,
    new JeanDidier('Boomer')
);

$docker->run();










class Logger
{
    public function log(string $message)
    {
        echo $message."\n";
    }
}

class ProdLogger extends Logger
{
    public function log(string $message)
    {
        shell_exec(sprintf('echo %s >> file.log', $message));
    }
}


$logger = $_SERVER['env'] == 'dev' ? new Logger : new ProdLogger;

if ($_SERVER['env'] == 'dev') {
    $logger = new Logger;
}
else {
    $logger = new ProdLogger;
}

$logger->log('Test log message');





